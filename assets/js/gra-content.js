(() => {
  const forms = Array.from(document.querySelectorAll('.site-form'));
  const leaderModal = document.querySelector('#leader-modal');
  const leaderProfileButtons = Array.from(document.querySelectorAll('.leader-profile-button'));
  const testimonialGrid = document.querySelector('.testimonial-grid');
  const testimonialDots = document.querySelector('.testimonial-dots');
  const formModalTriggers = Array.from(document.querySelectorAll('[data-open-form-modal]'));
  const formModals = Array.from(document.querySelectorAll('.form-modal'));

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
      } catch (error) {
        formOtpState.delete(form);
        button.textContent = error instanceof Error ? error.message : 'Please try again';
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

  mobileCourseCards();
  window.addEventListener('resize', mobileCourseCards);

})();
