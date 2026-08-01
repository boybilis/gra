<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Practice Quizzes | Gapuz Review Academy</title>
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    .quiz-page { background: #f4f7fb; }
    .quiz-launch-shell { max-width: 920px; min-height: calc(100vh - 210px); display: grid; place-items: center; }
    .quiz-launch-card { width: 100%; padding: clamp(28px, 5vw, 56px); border: 1px solid rgba(0, 48, 87, .14); border-radius: 22px; background: #fff; box-shadow: 0 18px 50px rgba(0, 48, 87, .1); text-align: center; }
    .quiz-launch-icon { width: 76px; height: 76px; margin: 0 auto 20px; display: grid; place-items: center; border-radius: 22px; background: linear-gradient(135deg, #003057, #1769aa); color: #fff; font-size: 34px; }
    .quiz-launch-card h1 { color: #003057; font-weight: 800; }
    .quiz-launch-card p { max-width: 650px; margin: 0 auto 24px; color: #536273; font-size: 1.05rem; }
    .quiz-meta { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; }
    .quiz-meta span { padding: 7px 13px; border-radius: 999px; background: #eef5fb; color: #003057; font-size: .9rem; font-weight: 700; }
    .quiz-start-btn { min-width: 190px; padding: 13px 24px; border: 0; border-radius: 999px; background: #f26522; color: #fff; font-weight: 800; box-shadow: 0 10px 24px rgba(242, 101, 34, .25); }
    .quiz-start-btn:hover { background: #d95213; }

    .quiz-modal { position: fixed; inset: 0; z-index: 10000; display: none; background: #f4f7fb; }
    .quiz-modal.is-open { display: flex; flex-direction: column; }
    .quiz-modal-header { flex: 0 0 auto; display: flex; align-items: center; gap: 18px; padding: 14px clamp(16px, 3vw, 36px); border-bottom: 1px solid #dce4ec; background: #fff; }
    .quiz-modal-brand { display: flex; align-items: center; gap: 12px; min-width: 210px; color: #003057; font-weight: 800; }
    .quiz-modal-brand img { width: 44px; height: 44px; object-fit: contain; }
    .quiz-progress-wrap { flex: 1; }
    .quiz-progress-copy { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 5px; color: #526173; font-size: .86rem; font-weight: 700; }
    .quiz-progress { height: 7px; overflow: hidden; border-radius: 999px; background: #e8edf2; }
    .quiz-progress-bar { height: 100%; border-radius: inherit; background: #f26522; transition: width .25s ease; }
    .quiz-close { width: 42px; height: 42px; border: 1px solid #d5dee7; border-radius: 50%; background: #fff; color: #003057; font-size: 24px; line-height: 1; }
    .quiz-modal-body { flex: 1; min-height: 0; overflow-y: auto; padding: clamp(20px, 4vw, 44px); }
    .quiz-question-shell { max-width: 1050px; margin: 0 auto; }
    .quiz-question-card { padding: clamp(22px, 4vw, 42px); border: 1px solid #dce4ec; border-radius: 18px; background: #fff; box-shadow: 0 10px 34px rgba(0, 48, 87, .08); }
    .quiz-type { display: inline-flex; align-items: center; gap: 7px; margin-bottom: 16px; padding: 6px 11px; border-radius: 999px; background: #e8f2fb; color: #07568e; font-size: .78rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; }
    .quiz-chart { margin-bottom: 24px; overflow: hidden; border: 1px solid #9eb5cc; border-radius: 8px; background: #eef3fa; }
    .quiz-chart-title { display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: #003057; color: #fff; font-size: .9rem; font-weight: 800; }
    .quiz-chart-grid { display: grid; grid-template-columns: repeat(var(--chart-columns, 1), minmax(0, 1fr)); }
    .quiz-chart-section { min-width: 0; }
    .quiz-chart-section + .quiz-chart-section { border-left: 1px solid #9eb5cc; }
    .quiz-chart-heading { padding: 9px 12px; border-bottom: 1px solid #9eb5cc; background: #3f76bd; color: #fff; font-size: .83rem; font-weight: 800; }
    .quiz-chart-content { min-height: 92px; padding: 13px 14px; color: #25384a; font-size: .94rem; line-height: 1.55; white-space: pre-line; }
    .quiz-question { margin: 0 0 8px; color: #172b3d; font-size: clamp(1.1rem, 2vw, 1.38rem); font-weight: 750; line-height: 1.5; }
    .quiz-instruction { margin-bottom: 22px; color: #687789; }
    .quiz-options { display: grid; gap: 11px; }
    .quiz-option { position: relative; display: flex; align-items: flex-start; gap: 13px; padding: 15px 17px; border: 1px solid #d7e0e9; border-radius: 11px; background: #fff; cursor: pointer; transition: border-color .18s ease, background-color .18s ease, transform .18s ease; }
    .quiz-option:hover { border-color: #5d94be; background: #f8fbfe; transform: translateY(-1px); }
    .quiz-option input { width: 20px; height: 20px; margin-top: 2px; accent-color: #1769aa; flex: 0 0 auto; }
    .quiz-option.is-selected { border-color: #1769aa; background: #eef7fd; }
    .quiz-option.is-correct { border-color: #188754; background: #eefaf4; }
    .quiz-option.is-incorrect { border-color: #c64040; background: #fff1f1; }
    .quiz-option-letter { min-width: 25px; color: #003057; font-weight: 800; }
    .quiz-feedback { display: none; margin-top: 22px; padding: 16px 18px; border-radius: 10px; }
    .quiz-feedback.is-visible { display: block; }
    .quiz-feedback.is-correct { border: 1px solid #8bd2ae; background: #effaf4; color: #176b45; }
    .quiz-feedback.is-incorrect { border: 1px solid #e4a6a6; background: #fff3f3; color: #8c2e2e; }
    .quiz-modal-footer { flex: 0 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px clamp(16px, 3vw, 36px); border-top: 1px solid #dce4ec; background: #fff; }
    .quiz-nav-group { display: flex; gap: 10px; }
    .quiz-btn { min-height: 44px; padding: 10px 18px; border-radius: 9px; font-weight: 750; }
    .quiz-btn-secondary { border: 1px solid #cbd6e0; background: #fff; color: #23415c; }
    .quiz-btn-primary { border: 1px solid #1769aa; background: #1769aa; color: #fff; }
    .quiz-btn-submit { border: 1px solid #f26522; background: #f26522; color: #fff; }
    .quiz-btn:disabled { cursor: not-allowed; opacity: .45; }
    .quiz-results { max-width: 700px; margin: 5vh auto; padding: clamp(28px, 5vw, 54px); border: 1px solid #dce4ec; border-radius: 20px; background: #fff; text-align: center; box-shadow: 0 15px 45px rgba(0, 48, 87, .1); }
    .quiz-score { width: 110px; height: 110px; margin: 0 auto 22px; display: grid; place-items: center; border: 9px solid #dcecf8; border-radius: 50%; color: #003057; font-size: 1.7rem; font-weight: 850; }
    body.quiz-modal-open { overflow: hidden; }
    @media (max-width: 700px) {
      .quiz-modal-header { gap: 10px; }
      .quiz-modal-brand { min-width: 0; }
      .quiz-modal-brand span { display: none; }
      .quiz-modal-brand img { width: 38px; height: 38px; }
      .quiz-modal-body { padding: 16px 12px; }
      .quiz-question-card { padding: 20px 15px; }
      .quiz-chart-grid { grid-template-columns: 1fr; }
      .quiz-chart-section + .quiz-chart-section { border-left: 0; border-top: 1px solid #9eb5cc; }
      .quiz-modal-footer { align-items: stretch; flex-direction: column; }
      .quiz-nav-group { width: 100%; }
      .quiz-btn { flex: 1; }
    }
  </style>
</head>
<body class="index-page gra-page footer-stick-page quiz-page">
  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
          <img src="assets/img/gra/gra-logo.png" alt="Gapuz Review Academy logo">
        </a>
        <a class="cta-btn" href="online-campus.php">Back to Online Campus</a>
      </div>
    </div>
  </header>
  <main class="container py-5 quiz-launch-shell">
    <section class="quiz-launch-card" aria-labelledby="quiz-page-title">
      <div class="quiz-launch-icon"><i class="bi bi-clipboard2-pulse"></i></div>
      <h1 id="quiz-page-title">Practice Quiz</h1>
      <p>Try a short nursing readiness quiz featuring multiple-choice and select-all-that-apply questions. Submit each answer to see immediate feedback.</p>
      <div class="quiz-meta" aria-label="Quiz information">
        <span><i class="bi bi-list-check me-1"></i>2 Questions</span>
        <span><i class="bi bi-clock me-1"></i>Untimed</span>
        <span><i class="bi bi-lightning-charge me-1"></i>Instant Feedback</span>
      </div>
      <button id="start-quiz" class="quiz-start-btn" type="button">Start Quiz</button>
    </section>
  </main>

  <section id="quiz-modal" class="quiz-modal" role="dialog" aria-modal="true" aria-labelledby="quiz-question-title" aria-hidden="true">
    <header class="quiz-modal-header">
      <div class="quiz-modal-brand"><img src="assets/img/gra/gra-logo.png" alt=""><span>GRA Practice Quiz</span></div>
      <div class="quiz-progress-wrap">
        <div class="quiz-progress-copy"><span id="quiz-progress-label">Question 1 of 2</span><span id="quiz-progress-percent">50%</span></div>
        <div class="quiz-progress" aria-hidden="true"><div id="quiz-progress-bar" class="quiz-progress-bar"></div></div>
      </div>
      <button id="close-quiz" class="quiz-close" type="button" aria-label="Close quiz">&times;</button>
    </header>
    <div id="quiz-modal-body" class="quiz-modal-body"></div>
    <footer id="quiz-modal-footer" class="quiz-modal-footer">
      <button id="previous-question" class="quiz-btn quiz-btn-secondary" type="button"><i class="bi bi-chevron-left me-1"></i>Previous</button>
      <div class="quiz-nav-group">
        <button id="submit-answer" class="quiz-btn quiz-btn-submit" type="button">Submit Answer</button>
        <button id="next-question" class="quiz-btn quiz-btn-primary" type="button">Next<i class="bi bi-chevron-right ms-1"></i></button>
      </div>
    </footer>
  </section>
  <footer id="footer" class="footer dark-background">
    <div class="container copyright text-center mt-4"><p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p></div>
  </footer>
  <script>
    (() => {
      const questions = [
        {
          type: 'single',
          label: 'Multiple Choice',
          chartTitle: 'Client Chart 1',
          chartSections: [
            { heading: "Nurses' Notes", content: "Review the client's information in the nurses' notes before selecting the nurse's priority response." }
          ],
          question: "Based on the client information provided, what is the nurse's first action?",
          instruction: 'Select the best answer.',
          choices: [
            "Ask the client's friends to check the client for additional weapons.",
            'Reassure the client that the client is safe and secure in the ED.',
            'Call security for assistance.',
            'Allow the client to vent own feelings.',
            'Administer an antianxiety medication.',
            'Distract the client and guide the client to practice skills.'
          ],
          correct: [3],
          explanation: "Allowing the client to express feelings is the priority therapeutic response and helps the nurse assess the client's immediate emotional needs."
        },
        {
          type: 'multiple',
          label: 'Select All That Apply',
          chartTitle: 'Client Chart 1',
          chartSections: [
            { heading: 'RN Notes', content: 'A 58-year-old male client arrives at the emergency department with chest pain.' },
            { heading: 'Assessment', content: 'The nurse reviews the RN notes and assessment to determine the appropriate dependent and independent interventions.' }
          ],
          question: 'Which interventions are immediate? Select all that apply.',
          instruction: 'Choose every option that should be performed immediately.',
          choices: [
            "Determine the client's daily activity.",
            'Begin supplemental O2 via nasal cannula at 2 L/min.',
            'Evaluate chest pain in response to sublingual nitroglycerin.',
            'Administer sublingual nitroglycerin.',
            'Teach the client proper diet to control blood cholesterol.',
            'Prepare and attach ECG leads to the client for monitoring.'
          ],
          correct: [1, 3, 5],
          explanation: 'Immediate priorities are supplemental oxygen, prescribed sublingual nitroglycerin, and continuous ECG monitoring. Assessment of response follows treatment, while activity and diet teaching are not immediate priorities.'
        }
      ];

      const modal = document.getElementById('quiz-modal');
      const modalBody = document.getElementById('quiz-modal-body');
      const modalFooter = document.getElementById('quiz-modal-footer');
      const progressLabel = document.getElementById('quiz-progress-label');
      const progressPercent = document.getElementById('quiz-progress-percent');
      const progressBar = document.getElementById('quiz-progress-bar');
      const startButton = document.getElementById('start-quiz');
      const closeButton = document.getElementById('close-quiz');
      const previousButton = document.getElementById('previous-question');
      const nextButton = document.getElementById('next-question');
      const submitButton = document.getElementById('submit-answer');
      let currentIndex = 0;
      let answers = questions.map(() => []);
      let submitted = questions.map(() => false);
      let lastFocusedElement = null;

      const sameAnswers = (selected, correct) => selected.length === correct.length && selected.every((value) => correct.includes(value));

      const selectedValues = () => Array.from(modalBody.querySelectorAll('input[name="quiz-answer"]:checked')).map((input) => Number(input.value));

      const updateSelectedStyles = () => {
        modalBody.querySelectorAll('.quiz-option').forEach((option) => {
          const input = option.querySelector('input');
          option.classList.toggle('is-selected', Boolean(input && input.checked));
        });
      };

      const renderQuestion = () => {
        const question = questions[currentIndex];
        const percent = Math.round(((currentIndex + 1) / questions.length) * 100);
        progressLabel.textContent = `Question ${currentIndex + 1} of ${questions.length}`;
        progressPercent.textContent = `${percent}%`;
        progressBar.style.width = `${percent}%`;
        modalFooter.hidden = false;

        const inputType = question.type === 'single' ? 'radio' : 'checkbox';
        const options = question.choices.map((choice, index) => {
          const checked = answers[currentIndex].includes(index) ? ' checked' : '';
          const disabled = submitted[currentIndex] ? ' disabled' : '';
          const correctClass = submitted[currentIndex] && question.correct.includes(index) ? ' is-correct' : '';
          const incorrectClass = submitted[currentIndex] && answers[currentIndex].includes(index) && !question.correct.includes(index) ? ' is-incorrect' : '';
          return `<label class="quiz-option${checked ? ' is-selected' : ''}${correctClass}${incorrectClass}"><input type="${inputType}" name="quiz-answer" value="${index}"${checked}${disabled}><span class="quiz-option-letter">${String.fromCharCode(65 + index)}.</span><span>${choice}</span></label>`;
        }).join('');

        const isCorrect = submitted[currentIndex] && sameAnswers(answers[currentIndex], question.correct);
        const feedback = submitted[currentIndex]
          ? `<div class="quiz-feedback is-visible ${isCorrect ? 'is-correct' : 'is-incorrect'}" role="status"><strong>${isCorrect ? 'Correct.' : 'Not quite.'}</strong> ${question.explanation}</div>`
          : '<div class="quiz-feedback" role="status"></div>';

        const chartSections = question.chartSections.map((section) => `<section class="quiz-chart-section"><div class="quiz-chart-heading">${section.heading}</div><div class="quiz-chart-content">${section.content}</div></section>`).join('');
        const chart = `<section class="quiz-chart" aria-label="${question.chartTitle}"><div class="quiz-chart-title"><i class="bi bi-clipboard2-data"></i>${question.chartTitle}</div><div class="quiz-chart-grid" style="--chart-columns:${question.chartSections.length}">${chartSections}</div></section>`;

        modalBody.innerHTML = `<div class="quiz-question-shell"><article class="quiz-question-card"><span class="quiz-type"><i class="bi ${question.type === 'single' ? 'bi-ui-radios' : 'bi-ui-checks'}"></i>${question.label}</span><h2 id="quiz-question-title" class="quiz-question">${currentIndex + 1}. ${question.question}</h2>${chart}<p class="quiz-instruction">${question.instruction}</p><div class="quiz-options">${options}</div>${feedback}</article></div>`;

        modalBody.querySelectorAll('input[name="quiz-answer"]').forEach((input) => input.addEventListener('change', () => {
          answers[currentIndex] = selectedValues();
          updateSelectedStyles();
          submitButton.disabled = answers[currentIndex].length === 0;
        }));

        previousButton.disabled = currentIndex === 0;
        submitButton.hidden = submitted[currentIndex];
        submitButton.disabled = answers[currentIndex].length === 0;
        nextButton.hidden = !submitted[currentIndex];
        nextButton.innerHTML = currentIndex === questions.length - 1 ? 'View Results<i class="bi bi-flag ms-1"></i>' : 'Next<i class="bi bi-chevron-right ms-1"></i>';
        modalBody.scrollTop = 0;
      };

      const renderResults = () => {
        const score = questions.reduce((total, question, index) => total + (sameAnswers(answers[index], question.correct) ? 1 : 0), 0);
        progressLabel.textContent = 'Quiz Complete';
        progressPercent.textContent = '100%';
        progressBar.style.width = '100%';
        modalFooter.hidden = true;
        modalBody.innerHTML = `<section class="quiz-results"><div class="quiz-score">${score}/${questions.length}</div><h2>Practice Quiz Complete</h2><p>You answered ${score} out of ${questions.length} questions correctly. Review the feedback and try again to strengthen your test-taking skills.</p><button id="restart-quiz" class="quiz-start-btn mt-2" type="button">Try Again</button></section>`;
        document.getElementById('restart-quiz').addEventListener('click', () => {
          currentIndex = 0;
          answers = questions.map(() => []);
          submitted = questions.map(() => false);
          renderQuestion();
        });
      };

      const openQuiz = () => {
        lastFocusedElement = document.activeElement;
        currentIndex = 0;
        answers = questions.map(() => []);
        submitted = questions.map(() => false);
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('quiz-modal-open');
        renderQuestion();
        closeButton.focus();
      };

      const closeQuiz = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('quiz-modal-open');
        if (lastFocusedElement instanceof HTMLElement) lastFocusedElement.focus();
      };

      startButton.addEventListener('click', openQuiz);
      closeButton.addEventListener('click', closeQuiz);
      previousButton.addEventListener('click', () => {
        if (currentIndex > 0) {
          currentIndex -= 1;
          renderQuestion();
        }
      });
      submitButton.addEventListener('click', () => {
        answers[currentIndex] = selectedValues();
        if (answers[currentIndex].length === 0) return;
        submitted[currentIndex] = true;
        renderQuestion();
      });
      nextButton.addEventListener('click', () => {
        if (!submitted[currentIndex]) return;
        if (currentIndex === questions.length - 1) {
          renderResults();
          return;
        }
        currentIndex += 1;
        renderQuestion();
      });
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) closeQuiz();
      });
    })();
  </script>
</body>
</html>



