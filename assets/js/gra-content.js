(() => {
  const forms = Array.from(document.querySelectorAll('.site-form'));
  const leaderModal = document.querySelector('#leader-modal');
  const leaderProfileButtons = Array.from(document.querySelectorAll('.leader-profile-button'));
  const testimonialGrid = document.querySelector('.testimonial-grid');
  const testimonialDots = document.querySelector('.testimonial-dots');
  const formModalTriggers = Array.from(document.querySelectorAll('[data-open-form-modal]'));
  const formModals = Array.from(document.querySelectorAll('.form-modal'));
  const teamProfileImages = Array.from(document.querySelectorAll('.team-member .member-img img'));

  const formOtpState = new WeakMap();
  const parseJsonSafe = async (response) => {
    try {
      return await response.json();
    } catch (_error) {
      return null;
    }
  };

  forms.forEach((form) => {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      const button = form.querySelector('button[type="submit"]');
      if (!button) return;
      const originalText = button.textContent;

      const emailInput = form.querySelector('input[name="email"]');
      const email = (emailInput && 'value' in emailInput ? String(emailInput.value).trim() : '');
      if (!email) {
        button.textContent = 'Email is required';
        window.setTimeout(() => { button.textContent = originalText; }, 1800);
        return;
      }
      button.disabled = true;

      try {
        const skipOtp = form.action.includes('submit-processing.php');
        const otpState = formOtpState.get(form);
        let verificationToken = otpState && otpState.email === email ? otpState.token : '';

        if (!skipOtp && !verificationToken) {
          button.textContent = 'Sending OTP...';
          const sendOtpResponse = await fetch('otp.php', {
            method: 'POST',
            headers: { Accept: 'application/json' },
            body: new URLSearchParams({ action: 'send', email }),
          });
          const sendOtpResult = await parseJsonSafe(sendOtpResponse);
          if (!sendOtpResponse.ok || !sendOtpResult || !sendOtpResult.ok) {
            throw new Error((sendOtpResult && sendOtpResult.message) || 'Unable to send OTP.');
          }

          const otpCode = window.prompt('Enter the 6-digit OTP sent to your email. Code expires in 2 minutes.');
          if (!otpCode) {
            throw new Error('OTP is required to continue.');
          }

          button.textContent = 'Verifying OTP...';
          const verifyOtpResponse = await fetch('otp.php', {
            method: 'POST',
            headers: { Accept: 'application/json' },
            body: new URLSearchParams({ action: 'verify', email, otp: otpCode }),
          });
          const verifyOtpResult = await parseJsonSafe(verifyOtpResponse);
          if (!verifyOtpResponse.ok || !verifyOtpResult || !verifyOtpResult.ok || !verifyOtpResult.verification_token) {
            throw new Error((verifyOtpResult && verifyOtpResult.message) || 'OTP verification failed.');
          }

          verificationToken = verifyOtpResult.verification_token;
          formOtpState.set(form, { email, token: verificationToken });
        }

        button.textContent = 'Submitting...';
        const formData = new FormData(form);
        if (!skipOtp) {
          formData.set('otp_verification_token', verificationToken);
        }
        const response = await fetch(form.action, { method: 'POST', body: formData, headers: { Accept: 'application/json' } });
        const result = await parseJsonSafe(response);
        if (!response.ok || !result || !result.ok) {
          throw new Error((result && result.message) || 'Please try again');
        }

        form.reset();
        formOtpState.delete(form);
        button.textContent = 'Submitted';

        const formTypeInput = form.querySelector('input[name="form_type"]');
        const formType = formTypeInput && 'value' in formTypeInput ? String(formTypeInput.value).trim() : '';
        const campusAccessSection = document.getElementById('campus-access');
        if (formType === 'booking' && campusAccessSection) {
          campusAccessSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
          if (!campusAccessSection.hasAttribute('tabindex')) {
            campusAccessSection.setAttribute('tabindex', '-1');
          }
          window.setTimeout(() => {
            campusAccessSection.focus();
          }, 350);
        }

        document.dispatchEvent(new CustomEvent('gra:form-submit-result', {
          detail: {
            ok: true,
            form,
            message: (result && result.message) ? String(result.message) : 'Submission received.',
            result,
          },
        }));
      } catch (error) {
        formOtpState.delete(form);
        const errorMessage = error instanceof Error ? error.message : 'Please try again';
        button.textContent = errorMessage;
        document.dispatchEvent(new CustomEvent('gra:form-submit-result', {
          detail: {
            ok: false,
            form,
            message: errorMessage,
          },
        }));
      } finally {
        window.setTimeout(() => { button.textContent = originalText; button.disabled = false; }, 2400);
      }
    });
  });

  if (leaderModal) {
    const modalImage = leaderModal.querySelector('.leader-modal-photo img');
    const modalLabel = leaderModal.querySelector('.leader-modal-copy .leader-label');
    const modalName = leaderModal.querySelector('#leader-modal-name');
    const modalBio = leaderModal.querySelector('.leader-modal-copy p');
    const modalCredentials = leaderModal.querySelector('.leader-modal-copy .credential-list');
    const closeLeaderModal = () => { leaderModal.classList.remove('is-open'); leaderModal.setAttribute('aria-hidden', 'true'); document.body.classList.remove('modal-open'); };
    leaderProfileButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const card = button.closest('.leader-card');
        if (!card) return;
        const photo = card.querySelector('.leader-photo img');
        const label = card.querySelector('.leader-label');
        const name = card.querySelector('h4');
        const bio = card.querySelector('.leader-copy p');
        const credentials = card.querySelector('.credential-list');
        if (photo && modalImage) { modalImage.src = photo.src; modalImage.alt = photo.alt; }
        if (label && modalLabel) modalLabel.textContent = label.textContent;
        if (name && modalName) modalName.textContent = name.textContent;
        if (bio && modalBio) modalBio.textContent = bio.textContent;
        if (credentials && modalCredentials) modalCredentials.innerHTML = credentials.innerHTML;
        leaderModal.classList.add('is-open'); leaderModal.setAttribute('aria-hidden', 'false'); document.body.classList.add('modal-open');
      });
    });
    leaderModal.querySelectorAll('[data-close-leader-modal]').forEach((button) => button.addEventListener('click', closeLeaderModal));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && leaderModal.classList.contains('is-open')) closeLeaderModal(); });
  }

  if (formModals.length) {
    const closeFormModal = () => { formModals.forEach((modal) => { modal.classList.remove('is-open'); modal.setAttribute('aria-hidden', 'true'); }); document.body.classList.remove('modal-open'); };
    formModalTriggers.forEach((trigger) => trigger.addEventListener('click', () => { const modal = document.getElementById(trigger.dataset.openFormModal); if (!modal) return; closeFormModal(); modal.classList.add('is-open'); modal.setAttribute('aria-hidden', 'false'); document.body.classList.add('modal-open'); }));
    document.querySelectorAll('[data-close-form-modal]').forEach((trigger) => trigger.addEventListener('click', closeFormModal));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && formModals.some((modal) => modal.classList.contains('is-open'))) closeFormModal(); });
  }

  if (testimonialGrid && testimonialDots) {
    const testimonials = Array.from(testimonialGrid.querySelectorAll('.testimonial'));
    const cardsPerSlide = window.matchMedia('(max-width: 767px)').matches ? 1 : 4;
    const slideCount = Math.ceil(testimonials.length / cardsPerSlide);
    const showTestimonialSlide = (slideIndex) => {
      testimonials.forEach((testimonial, index) => { testimonial.hidden = Math.floor(index / cardsPerSlide) !== slideIndex; });
      testimonialDots.querySelectorAll('.testimonial-dot').forEach((dot, index) => { dot.classList.toggle('is-active', index === slideIndex); dot.setAttribute('aria-pressed', String(index === slideIndex)); });
    };
    if (slideCount > 1) {
      Array.from({ length: slideCount }).forEach((_, index) => { const dot = document.createElement('button'); dot.className = 'testimonial-dot'; dot.type = 'button'; dot.setAttribute('aria-label', `Show testimonial slide ${index + 1}`); dot.setAttribute('aria-pressed', 'false'); dot.addEventListener('click', () => showTestimonialSlide(index)); testimonialDots.append(dot); });
    }
    showTestimonialSlide(0);
  }

  if (teamProfileImages.length && typeof bootstrap !== 'undefined') {
    if (!document.getElementById('testmaster-profile-modal-style')) {
      const style = document.createElement('style');
      style.id = 'testmaster-profile-modal-style';
      style.textContent = `
        #testmaster-profile-modal .modal-dialog { max-width: 940px; }
        .clickable-testmaster-wrap {
          width: 170px;
          height: 170px;
          margin: 0 auto;
          border-radius: 50%;
          overflow: hidden;
          transition: transform .25s ease, box-shadow .25s ease;
          box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }
        .clickable-testmaster-wrap:hover,
        .clickable-testmaster-wrap:focus-within {
          transform: translateY(-4px) scale(1.04);
          box-shadow: 0 12px 24px rgba(0, 0, 0, .2);
        }
        .clickable-testmaster-photo {
          width: 100%;
          height: 100%;
          border-radius: 50% !important;
          object-fit: cover;
          display: block;
        }
        #testmaster-profile-modal .modal-content { border: 0; border-radius: 14px; border-top: 6px solid var(--accent-color, #ff6a00); overflow: hidden; }
        #testmaster-profile-modal .modal-header { border-bottom: 0; padding: 10px 14px 0; }
        #testmaster-profile-modal .modal-title { font-size: 0; line-height: 0; }
        #testmaster-profile-modal .btn-close { width: 38px; height: 38px; border: 1px solid #d9e1ea; border-radius: 50%; opacity: 1; box-shadow: none; }
        #testmaster-profile-modal .modal-body { padding: 10px 24px 24px; }
        #testmaster-profile-modal .profile-badge { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #f4eee5; color: #a55b00; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; margin-bottom: 8px; }
        #testmaster-profile-modal .profile-name { margin: 0 0 8px; color: #003057; font-size: clamp(1.55rem, 2vw, 2.15rem); line-height: 1.15; font-weight: 700; font-family: var(--heading-font); }
        #testmaster-profile-modal .profile-summary { margin-bottom: 14px; font-size: 1rem; line-height: 1.5; font-family: var(--default-font); }
        #testmaster-profile-modal .profile-cred-title { margin: 0 0 8px; color: #003057; font-size: 1.05rem; font-weight: 700; text-transform: uppercase; font-family: var(--heading-font); }
        #testmaster-profile-modal .profile-credentials { margin: 0; padding-left: 0; list-style: none; }
        #testmaster-profile-modal .profile-credentials li { position: relative; padding-left: 18px; margin-bottom: 7px; font-size: .95rem; line-height: 1.45; font-family: var(--default-font); }
        #testmaster-profile-modal .profile-credentials li::before { content: ""; position: absolute; left: 0; top: .62em; width: 8px; height: 8px; border-radius: 50%; background: var(--accent-color, #ff6a00); }
        #testmaster-profile-modal .modal-footer { border-top: 0; padding: 0 24px 20px; }
        #testmaster-profile-modal .modal-footer .btn { min-width: 110px; }
        #testmaster-profile-photo { width: 100%; border-radius: 10px; object-fit: cover; }
        @media (max-width: 991.98px) {
          #testmaster-profile-modal .profile-name { font-size: 1.8rem; }
          #testmaster-profile-modal .profile-summary { font-size: .97rem; }
          #testmaster-profile-modal .profile-cred-title { font-size: 1rem; }
          #testmaster-profile-modal .profile-credentials li { font-size: .92rem; }
        }
        @media (max-width: 767.98px) {
          #testmaster-profile-modal .modal-dialog { margin: 0.75rem; max-width: none; }
          #testmaster-profile-modal .modal-header { padding: 8px 10px 0; }
          #testmaster-profile-modal .modal-body { padding: 10px 14px 16px; }
          #testmaster-profile-modal .profile-badge { font-size: 11px; margin-bottom: 6px; }
          #testmaster-profile-modal .profile-name { font-size: 1.35rem; line-height: 1.2; margin-bottom: 8px; }
          #testmaster-profile-modal .profile-summary { font-size: .93rem; line-height: 1.45; margin-bottom: 10px; }
          #testmaster-profile-modal .profile-cred-title { font-size: .95rem; margin-bottom: 6px; }
          #testmaster-profile-modal .profile-credentials li { font-size: .88rem; line-height: 1.4; margin-bottom: 5px; padding-left: 16px; }
          #testmaster-profile-modal .profile-credentials li::before { width: 7px; height: 7px; top: .58em; }
          #testmaster-profile-photo { max-height: 300px; object-fit: cover; }
          #testmaster-profile-modal .modal-footer { padding: 0 14px 14px; }
          #testmaster-profile-modal .modal-footer .btn { width: 100%; }
        }
      `;
      document.head.appendChild(style);
    }

    const profileData = {
      'mia_g.png': {
        name: 'Dr. Mia A. Gapuz, ME, MM',
        role: 'President and CEO',
        summary: 'A business leader and educator, with over two decades of experience in teaching and running test preparation centers in the Philippines.',
        details: [
          'Education: University of the Philippines - Manila; Asian Institute of Management (Makati, Philippines); Instituto de Empresa (Madrid, Spain); WED Technologies, Harvard (ongoing).',
          'Academic Awards: Board Topnotcher (Rank #2, Nationwide); Most Outstanding Clinician (Endodontics), University of the Philippines - Manila; Highest Distinction, Asian Institute of Management.',
          'International Award: Top 10 Asian Institute of Management Philippines Alumni Leaders 2024 (CEO Insights Asia).',
          'Previous Work: President and CEO, RA Gapuz Review Center, Inc.'
        ]
      },
      'liz_1.png': {
        name: 'Prof. Liz Gapuz Iciano, USRN, MBA, CNOR',
        role: 'Lead Testmaster, GRA - USA & Middle East',
        summary: 'An experienced clinical educator and nurse leader in the USA and the Middle East for more than 25 years in perioperative services, clinical supply chain, and clinical quality practice.',
        details: [
          'Licensed RN in New York, New Jersey, and Florida.',
          'Education: Hofstra University (New York); BS Nursing, St. Louis University.',
          'Work: Director of Clinical Resource, Miami Beach, Florida; Assistant Director of Perioperative Surgery, Palm Beach, Florida.',
          'Previous Work: Vice President, RA Gapuz Review Center, Inc.'
        ]
      },
      'jeni-iciano.jpg': {
        name: 'Prof. Jeni Gapuz-Iciano, USRN',
        role: 'International Bilingual Testmaster, GRA - USA & Latin America',
        summary: 'An experienced bilingual clinical educator, double summa cum laude graduate, and nurse leader with 12 years of experience in direct patient care, staff supervision, and department operations.',
        details: [
          'Licensed as a Registered Nurse in all 50 US states and Washington, DC.',
          'Education: BS Nursing, Seminole State College of Florida (Summa Cum Laude).',
          'Education: BS in Information Systems Technology, Seminole State College of Florida (Summa Cum Laude).'
        ]
      },
      'belviz_1.png': {
        name: 'Prof. Clement C. Belvis, USRN, RM, MPH',
        role: 'Senior Test Master / Adviser',
        summary: 'A nurse leader, licensed nurse, midwife, and educator; a double board topnotcher with a Master in Public Health and extensive teaching experience in major universities in the Philippines and in various international NCLEX bootcamps.',
        details: [
          'Licensed nurse, registered midwife, and educator.',
          'Double board topnotcher.',
          'Master in Public Health (MPH).',
          'Extensive teaching experience in major universities in the Philippines.',
          'Extensive teaching experience in international NCLEX bootcamps.'
        ]
      }
    };

    let profileModalEl = document.getElementById('testmaster-profile-modal');
    if (!profileModalEl) {
      profileModalEl = document.createElement('div');
      profileModalEl.className = 'modal fade';
      profileModalEl.id = 'testmaster-profile-modal';
      profileModalEl.tabIndex = -1;
      profileModalEl.setAttribute('aria-hidden', 'true');
      profileModalEl.innerHTML = `
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">&nbsp;</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3 align-items-start">
                <div class="col-md-4">
                  <img id="testmaster-profile-photo" src="" alt="" class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                  <span id="testmaster-profile-role" class="profile-badge"></span>
                  <h4 id="testmaster-profile-name" class="profile-name"></h4>
                  <p id="testmaster-profile-summary" class="profile-summary"></p>
                  <h5 class="profile-cred-title">Credentials and Achievements</h5>
                  <ul id="testmaster-profile-details" class="profile-credentials"></ul>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>`;
      document.body.appendChild(profileModalEl);
    }

    const profileModal = bootstrap.Modal.getOrCreateInstance(profileModalEl);
    const nameEl = profileModalEl.querySelector('#testmaster-profile-name');
    const roleEl = profileModalEl.querySelector('#testmaster-profile-role');
    const summaryEl = profileModalEl.querySelector('#testmaster-profile-summary');
    const detailsEl = profileModalEl.querySelector('#testmaster-profile-details');
    const photoEl = profileModalEl.querySelector('#testmaster-profile-photo');

    teamProfileImages.forEach((img) => {
      const src = (img.getAttribute('src') || '').toLowerCase();
      const key = Object.keys(profileData).find((file) => src.includes(file));
      if (!key) return;

      img.style.cursor = 'pointer';
      img.setAttribute('title', 'View profile');

      img.addEventListener('click', () => {
        const profile = profileData[key];
        if (!profile) return;

        if (nameEl) nameEl.textContent = profile.name;
        if (roleEl) roleEl.textContent = profile.role;
        if (summaryEl) summaryEl.textContent = profile.summary;
        if (detailsEl) {
          detailsEl.innerHTML = profile.details.map((item) => `<li>${item}</li>`).join('');
        }
        if (photoEl) {
          photoEl.src = img.getAttribute('src') || '';
          photoEl.alt = profile.name;
        }

        profileModal.show();
      });
      img.classList.add('clickable-testmaster-photo');
      const wrap = img.closest('.member-img');
      if (wrap) wrap.classList.add('clickable-testmaster-wrap');
    });
  }

  const campusAccessForm = document.getElementById('campus-access-form');
  if (campusAccessForm) {
    const campusEmailInput = document.getElementById('campus-access-email');
    const campusStatus = document.getElementById('campus-access-status');
    const resourceLinks = Array.from(document.querySelectorAll('[data-campus-resource]'));
    const storageKey = 'graCampusAccessEmail';

    const setCampusStatus = (message, kind) => {
      if (!campusStatus) return;
      campusStatus.textContent = message;
      campusStatus.classList.remove('is-error', 'is-success');
      if (kind === 'error') campusStatus.classList.add('is-error');
      if (kind === 'success') campusStatus.classList.add('is-success');
    };

    const disableCampusAutoScroll = document.body.classList.contains('campus-page');

    const focusFreeResources = () => {
      const resourcesSection = document.getElementById('free-resources');
      const firstResourceLink = document.querySelector('#free-resources [data-campus-resource]');
      if (resourcesSection) {
        resourcesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        if (!resourcesSection.hasAttribute('tabindex')) {
          resourcesSection.setAttribute('tabindex', '-1');
        }
        window.setTimeout(() => {
          if (firstResourceLink instanceof HTMLElement) {
            firstResourceLink.focus();
          } else {
            resourcesSection.focus();
          }
        }, 350);
      }
    };

    const setResourcesUnlocked = (email) => {
      resourceLinks.forEach((link) => {
        const baseHref = link.dataset.resourceHref || link.getAttribute('href') || '#';
        link.href = `${baseHref}?email=${encodeURIComponent(email)}`;
        link.setAttribute('aria-disabled', 'false');
        link.closest('.campus-resource-card')?.classList.remove('is-locked');
      });
    };

    const setResourcesLocked = () => {
      resourceLinks.forEach((link) => {
        link.href = '#';
        link.setAttribute('aria-disabled', 'true');
        link.closest('.campus-resource-card')?.classList.add('is-locked');
      });
    };

    const verifyCampusEmail = async (email) => {
      const formData = new FormData();
      formData.append('email', email);

      const response = await fetch(campusAccessForm.action, {
        method: 'POST',
        body: formData,
        headers: { Accept: 'application/json' },
      });

      const result = await response.json();
      if (!response.ok || !result.ok || !result.registered) {
        throw new Error(result.message || 'Email verification failed.');
      }

      return result;
    };

    setResourcesLocked();

    resourceLinks.forEach((link) => {
      link.addEventListener('click', (event) => {
        if (link.getAttribute('aria-disabled') === 'true') {
          event.preventDefault();
          setCampusStatus('Verify your registered email to unlock free resources.', 'error');
        }
      });
    });

    const rememberedEmail = window.localStorage.getItem(storageKey);
    if (rememberedEmail && campusEmailInput) {
      campusEmailInput.value = rememberedEmail;
      verifyCampusEmail(rememberedEmail)
        .then((result) => {
          setResourcesUnlocked(rememberedEmail);
          setCampusStatus(result.message || 'Email verified. Resources unlocked.', 'success');
          if (!disableCampusAutoScroll) {
            focusFreeResources();
          }
        })
        .catch(() => {
          window.localStorage.removeItem(storageKey);
          setResourcesLocked();
        });
    }

    campusAccessForm.addEventListener('submit', async (event) => {
      event.preventDefault();
      const email = (campusEmailInput?.value || '').trim();
      if (!email) {
        setResourcesLocked();
        setCampusStatus('Please enter your email first.', 'error');
        return;
      }

      const submitButton = document.getElementById('campus-access-submit');
      const originalText = submitButton ? submitButton.textContent : '';
      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Verifying...';
      }

      try {
        const result = await verifyCampusEmail(email);
        window.localStorage.setItem(storageKey, email);
        setResourcesUnlocked(email);
        setCampusStatus(result.message || 'Email verified. Resources unlocked.', 'success');
        focusFreeResources();
      } catch (error) {
        window.localStorage.removeItem(storageKey);
        setResourcesLocked();
        setCampusStatus(error instanceof Error ? error.message : 'Unable to verify email right now.', 'error');
      } finally {
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.textContent = originalText;
        }
      }
    });
  }

  let courseCardClickBound = false;
  const closeCourseCard = (card) => {
    card.classList.remove('is-desc-open');
    const toggle = card.querySelector('.course-desc-toggle');
    if (toggle) toggle.setAttribute('aria-expanded', 'false');
  };
  const mobileCourseCards = () => {
    const cards = Array.from(document.querySelectorAll('#courses .row.gy-4:not(.learning-mode-cards) .service-item'));
    const isMobile = window.matchMedia('(max-width: 575px)').matches;

    cards.forEach((card) => {
      const desc = card.querySelector('p');
      const existingToggle = card.querySelector('.course-desc-toggle');
      if (!desc) return;

      if (!isMobile) {
        closeCourseCard(card);
        if (existingToggle) existingToggle.remove();
        return;
      }

      if (existingToggle) {
        if (card.dataset.descHandlersBound !== 'true') {
          card.addEventListener('mouseleave', () => closeCourseCard(card));
          card.addEventListener('focusout', () => {
            window.setTimeout(() => {
              const active = document.activeElement;
              if (!(active instanceof Element) || !card.contains(active)) closeCourseCard(card);
            }, 0);
          });
          card.dataset.descHandlersBound = 'true';
        }
        return;
      }

      const toggle = document.createElement('button');
      toggle.type = 'button';
      toggle.className = 'course-desc-toggle';
      toggle.setAttribute('aria-label', 'Show course details');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.innerHTML = '<i class="bi bi-chevron-down"></i>';
      toggle.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        const isOpen = card.classList.toggle('is-desc-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
      card.appendChild(toggle);
      card.addEventListener('mouseleave', () => closeCourseCard(card));
      card.addEventListener('focusout', () => {
        window.setTimeout(() => {
          const active = document.activeElement;
          if (!(active instanceof Element) || !card.contains(active)) closeCourseCard(card);
        }, 0);
      });
      card.dataset.descHandlersBound = 'true';
    });

    if (!courseCardClickBound) {
      document.addEventListener('click', (event) => {
        const target = event.target;
        if (!(target instanceof Element)) return;
        const isMobileNow = window.matchMedia('(max-width: 575px)').matches;
        if (!isMobileNow) return;
        const activeCard = target.closest('#courses .row.gy-4:not(.learning-mode-cards) .service-item');
        const currentCards = Array.from(document.querySelectorAll('#courses .row.gy-4:not(.learning-mode-cards) .service-item'));
        currentCards.forEach((card) => {
          if (card === activeCard) return;
          closeCourseCard(card);
        });
      });
      courseCardClickBound = true;
    }
  };

  const coursePasserSwipers = Array.from(document.querySelectorAll('.course-passers .featured-passers-swiper'));
  if (coursePasserSwipers.length) {
    coursePasserSwipers.forEach((swiperEl) => {
      const course = (swiperEl.dataset.course || '').trim();
      if (!course) return;

      const initialLimit = Number.parseInt(swiperEl.dataset.initialLimit || '16', 10);
      const nextLimit = Number.parseInt(swiperEl.dataset.nextLimit || '8', 10);
      const state = {
        offset: Number.isFinite(initialLimit) ? initialLimit : 16,
        batch: Number.isFinite(nextLimit) ? nextLimit : 8,
        loading: false,
        done: false,
      };

      const fetchNextBatch = async () => {
        if (state.loading || state.done) return;
        const swiper = swiperEl.swiper;
        if (!swiper || typeof swiper.appendSlide !== 'function') return;

        state.loading = true;
        try {
          const response = await fetch(`passer-images.php?course=${encodeURIComponent(course)}&offset=${state.offset}&limit=${state.batch}`, {
            headers: { Accept: 'application/json' },
          });
          const result = await parseJsonSafe(response);
          const images = result && result.ok && Array.isArray(result.images) ? result.images : [];
          if (images.length === 0) {
            state.done = true;
            return;
          }

          const slidesHtml = images.map((item) => {
            const url = item && item.url ? String(item.url) : '';
            const rawName = item && item.name ? String(item.name) : 'GRA passer';
            const escapedUrl = url.replace(/"/g, '&quot;');
            const escapedAlt = `${rawName} testimonial poster`.replace(/"/g, '&quot;');
            return `<div class="swiper-slide"><article class="featured-passer-card"><a href="${escapedUrl}" class="glightbox" data-gallery="${course}-passers"><img src="${escapedUrl}" alt="${escapedAlt}" loading="lazy" decoding="async"></a></article></div>`;
          });

          swiper.appendSlide(slidesHtml);
          swiper.update();
          if (typeof window.refreshGRALightbox === 'function') {
            window.refreshGRALightbox();
          }
          state.offset += images.length;
          if (images.length < state.batch) {
            state.done = true;
          }
        } catch (_error) {
          // Keep silent in UI; retry on next threshold reach.
        } finally {
          state.loading = false;
        }
      };

      const bindWhenReady = () => {
        const swiper = swiperEl.swiper;
        if (!swiper) {
          window.setTimeout(bindWhenReady, 180);
          return;
        }

        swiper.on('slideChange', fetchNextBatch);
        swiper.on('reachEnd', fetchNextBatch);
      };

      bindWhenReady();
    });
  }

  mobileCourseCards();
  window.addEventListener('resize', mobileCourseCards);

})();
