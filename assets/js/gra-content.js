(() => {
  const forms = Array.from(document.querySelectorAll('.site-form'));
  const leaderModal = document.querySelector('#leader-modal');
  const leaderProfileButtons = Array.from(document.querySelectorAll('.leader-profile-button'));
  const testimonialGrid = document.querySelector('.testimonial-grid');
  const testimonialDots = document.querySelector('.testimonial-dots');
  const formModalTriggers = Array.from(document.querySelectorAll('[data-open-form-modal]'));
  const formModals = Array.from(document.querySelectorAll('.form-modal'));

  forms.forEach((form) => {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      const button = form.querySelector('button[type="submit"]');
      if (!button) return;
      const originalText = button.textContent;
      button.textContent = 'Submitting...';
      button.disabled = true;
      try {
        const response = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { Accept: 'application/json' } });
        const result = await response.json();
        if (!response.ok || !result.ok) throw new Error(result.message || 'Submission failed.');
        form.reset();
        button.textContent = 'Submitted';
      } catch (error) {
        button.textContent = 'Please try again';
      } finally {
        window.setTimeout(() => { button.textContent = originalText; button.disabled = false; }, 2200);
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

})();
