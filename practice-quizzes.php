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
    .quiz-modal-header { flex: 0 0 auto; display: flex; align-items: center; gap: 18px; padding: 14px clamp(16px, 3vw, 36px); border-bottom: 1px solid #164d78; background: #003057; color: #fff; box-shadow: 0 4px 16px rgba(0, 24, 45, .2); }
    .quiz-modal-brand { display: flex; align-items: center; gap: 12px; min-width: 210px; color: #fff; font-weight: 800; }
    .quiz-modal-brand img { width: 44px; height: 44px; object-fit: contain; }
    .quiz-progress-wrap { flex: 1; }
    .quiz-progress-copy { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 7px; color: #fff; font-size: .9rem; font-weight: 750; }
    .quiz-progress { height: 9px; overflow: hidden; border: 1px solid rgba(255, 255, 255, .35); border-radius: 999px; background: rgba(255, 255, 255, .22); }
    .quiz-progress-bar { height: 100%; border-radius: inherit; background: #f26522; box-shadow: 0 0 8px rgba(242, 101, 34, .65); transition: width .25s ease; }
    .quiz-close { width: 42px; height: 42px; border: 1px solid rgba(255, 255, 255, .7); border-radius: 50%; background: rgba(255, 255, 255, .1); color: #fff; font-size: 24px; line-height: 1; }
    .quiz-close:hover, .quiz-close:focus-visible { border-color: #fff; background: #fff; color: #003057; outline: none; }
    .quiz-modal-body { flex: 1; min-height: 0; overflow-y: auto; padding: clamp(20px, 4vw, 44px); }
    .quiz-question-shell { max-width: 1050px; margin: 0 auto; }
    .quiz-question-card { padding: clamp(22px, 4vw, 42px); border: 1px solid #dce4ec; border-radius: 18px; background: #fff; box-shadow: 0 10px 34px rgba(0, 48, 87, .08); }
    .quiz-type { display: inline-flex; align-items: center; gap: 7px; margin-bottom: 16px; padding: 6px 11px; border-radius: 999px; background: #e8f2fb; color: #07568e; font-size: .78rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; }
    .quiz-question { margin: 0 0 8px; color: #172b3d; font-size: clamp(1.1rem, 2vw, 1.38rem); font-weight: 750; line-height: 1.5; }
    .quiz-instruction { margin-bottom: 22px; color: #687789; }
    .quiz-options { display: grid; gap: 11px; }
    .quiz-page label.quiz-option { position: relative; display: grid; grid-template-columns: 22px 30px minmax(0, 1fr); align-items: flex-start; column-gap: 16px; margin-bottom: 0; padding: 15px 17px; border: 1px solid #d7e0e9; border-radius: 11px; background: #fff; cursor: pointer; transition: border-color .18s ease, background-color .18s ease, transform .18s ease; }
    .quiz-option:hover { border-color: #5d94be; background: #f8fbfe; transform: translateY(-1px); }
    .quiz-option input { width: 20px; height: 20px; margin: 2px 0 0; accent-color: #1769aa; }
    .quiz-option.is-selected { border-color: #1769aa; background: #eef7fd; }
    .quiz-option-letter { color: #003057; font-weight: 800; line-height: 1.5; }
    .quiz-option > span:last-child { line-height: 1.5; }
    .quiz-answer-recorded { margin-top: 20px; padding: 12px 15px; border: 1px solid #b8d5e9; border-radius: 9px; background: #f0f8fd; color: #07568e; font-weight: 700; }
    .quiz-modal-footer { flex: 0 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px clamp(16px, 3vw, 36px); border-top: 1px solid #dce4ec; background: #fff; }
    .quiz-nav-group { display: flex; gap: 10px; }
    .quiz-btn { min-height: 44px; padding: 10px 18px; border-radius: 9px; font-weight: 750; }
    .quiz-btn-secondary { border: 1px solid #cbd6e0; background: #fff; color: #23415c; }
    .quiz-btn-primary { border: 1px solid #1769aa; background: #1769aa; color: #fff; }
    .quiz-btn-submit { border: 1px solid #f26522; background: #f26522; color: #fff; }
    .quiz-btn:disabled { cursor: not-allowed; opacity: .45; }
    .quiz-answer-review { max-width: 1050px; margin: 2vh auto; padding: clamp(24px, 4vw, 44px); border: 1px solid #dce4ec; border-radius: 20px; background: #fff; text-align: center; box-shadow: 0 15px 45px rgba(0, 48, 87, .1); }
    .quiz-answer-review p { max-width: 720px; margin: 0 auto 24px; color: #687789; }
    .quiz-review-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; margin: 28px 0; text-align: left; }
    .quiz-review-item { display: flex; align-items: center; gap: 11px; min-height: 74px; padding: 12px; border: 1px solid #b9d4e7; border-radius: 11px; background: #f4faff; color: #173c59; text-align: left; }
    .quiz-review-item:hover { border-color: #1769aa; background: #eaf5fc; }
    .quiz-review-number { width: 34px; height: 34px; flex: 0 0 auto; display: grid; place-items: center; border-radius: 50%; background: #1769aa; color: #fff; font-weight: 800; }
    .quiz-review-item-copy { min-width: 0; }
    .quiz-review-item-copy strong, .quiz-review-item-copy span { display: block; }
    .quiz-review-item-copy span { margin-top: 3px; overflow: hidden; color: #687789; font-size: .78rem; text-overflow: ellipsis; white-space: nowrap; }
    .quiz-results { max-width: 1280px; margin: 2vh auto; padding: clamp(24px, 4vw, 46px); border: 1px solid #dce4ec; border-radius: 20px; background: #fff; text-align: center; box-shadow: 0 15px 45px rgba(0, 48, 87, .1); }
    .quiz-score { width: 110px; height: 110px; margin: 0 auto 22px; display: grid; place-items: center; border: 9px solid #dcecf8; border-radius: 50%; color: #003057; font-size: 1.7rem; font-weight: 850; }
    .quiz-score-summary { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; max-width: 820px; margin: 24px auto 0; }
    .quiz-score-stat { padding: 15px 12px; border: 1px solid #d7e0e9; border-radius: 11px; background: #f8fafc; }
    .quiz-score-stat strong { display: block; color: #003057; font-size: 1.45rem; line-height: 1.2; }
    .quiz-score-stat span { display: block; margin-top: 4px; color: #687789; font-size: .82rem; font-weight: 700; text-transform: uppercase; }
    .quiz-review-wrap { margin: 28px 0; overflow-x: auto; border: 1px solid #d7e0e9; border-radius: 12px; text-align: left; }
    .quiz-review-table { width: 100%; min-width: 900px; border-collapse: collapse; }
    .quiz-review-table th { padding: 13px 15px; background: #003057; color: #fff; font-size: .88rem; letter-spacing: .02em; }
    .quiz-review-table td { padding: 16px 15px; border-top: 1px solid #d7e0e9; vertical-align: top; color: #314457; line-height: 1.5; }
    .quiz-review-table tbody tr:nth-child(even) { background: #f7f9fb; }
    .quiz-review-question { width: 24%; font-weight: 750; color: #172b3d !important; }
    .quiz-review-answer { width: 22%; }
    .quiz-review-rationale { width: 32%; }
    .quiz-result-badge { display: inline-block; margin-top: 8px; padding: 4px 8px; border-radius: 999px; font-size: .75rem; font-weight: 800; }
    .quiz-result-badge.correct { background: #e6f7ee; color: #177048; }
    .quiz-result-badge.incorrect { background: #fdecec; color: #9d3030; }
    body.quiz-modal-open { overflow: hidden; }
    @media (max-width: 700px) {
      .quiz-modal-header { gap: 10px; }
      .quiz-modal-brand { min-width: 0; }
      .quiz-modal-brand span { display: none; }
      .quiz-modal-brand img { width: 38px; height: 38px; }
      .quiz-modal-body { padding: 16px 12px; }
      .quiz-question-card { padding: 20px 15px; }
      .quiz-modal-footer { align-items: stretch; flex-direction: column; }
      .quiz-nav-group { width: 100%; }
      .quiz-btn { flex: 1; }
      .quiz-score-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .quiz-review-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
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
      <p>Try a short nursing readiness quiz featuring multiple-choice and select-all-that-apply questions. Correct answers and rationales appear after the test.</p>
      <div class="quiz-meta" aria-label="Quiz information">
        <span><i class="bi bi-list-check me-1"></i>15 Questions</span>
        <span><i class="bi bi-clock me-1"></i>Untimed</span>
        <span><i class="bi bi-card-checklist me-1"></i>End-of-Test Review</span>
      </div>
      <button id="start-quiz" class="quiz-start-btn" type="button">Start Quiz</button>
    </section>
  </main>

  <section id="quiz-modal" class="quiz-modal" role="dialog" aria-modal="true" aria-labelledby="quiz-question-title" aria-hidden="true">
    <header class="quiz-modal-header">
      <div class="quiz-modal-brand"><img src="assets/img/gra/gra-logo.png" alt=""><span>GRA Practice Quiz</span></div>
      <div class="quiz-progress-wrap">
        <div class="quiz-progress-copy"><span id="quiz-progress-label">Question 1 of 15</span><span id="quiz-progress-percent">7%</span></div>
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
        },
        {
          type: 'multiple',
          label: 'Select All That Apply',
          question: 'A 25-year-old client presents to the urgent care clinic due to painful urination and reported blood in the urine. The nurse is preparing to speak with the physician about the client\'s plan of care. For the column “Indicated,” select all that apply.',
          instruction: 'Choose every indicated intervention.',
          choices: [
            'Vital signs monitoring every 15–30 minutes.',
            'IV hydration.',
            'Antibiotic therapy.',
            'Complete blood count.',
            'Urinalysis.',
            'Ultrasound of the KUB.',
            'Oxygen therapy.',
            'Intermittent catheterization.'
          ],
          correct: [2, 3, 4, 5],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'single',
          label: 'Multiple Choice',
          question: 'The client with chronic renal failure returns to the nursing unit following a hemodialysis treatment. On assessment, the nurse notes that the client\'s temperature is 100.2°F. Which action is appropriate?',
          instruction: 'Select the best answer.',
          choices: [
            'Encourage fluids.',
            'Notify the physician.',
            'Monitor the site of the shunt for infection.',
            'Continue to monitor vital signs.'
          ],
          correct: [3],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'multiple',
          label: 'Select All That Apply',
          question: 'Reviewing the RN notes and laboratory report, the nurse determines the findings that are of immediate concern. For RN notes, select all findings that are of immediate concern.',
          instruction: 'Choose every applicable finding.',
          choices: ['Chest pain.', 'Last medication taken.', 'BMI.', 'Heart rate.'],
          correct: [0, 1, 3],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'single',
          label: 'Multiple Choice',
          question: 'The nurse is planning to auscultate a client\'s heart at the point of maximal impulse. Where should the nurse place the stethoscope?',
          instruction: 'Select the best answer.',
          choices: [
            '1st intercostal space, right midclavicular line.',
            '5th intercostal space, left midclavicular line.',
            '3rd intercostal space, left sternal border.',
            '2nd intercostal space, right sternal border.'
          ],
          correct: [1],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'multiple',
          label: 'Select All That Apply',
          question: 'The client was diagnosed with PTSD, anxiety, and suicidal risk. Which physician orders would the nurse anticipate at this time? Select all that apply.',
          instruction: 'Choose every applicable order.',
          choices: [
            'Begin antidepressant drug therapy.',
            'Admit to an acute psychiatric unit.',
            'Refer to a case manager.',
            'Refer to a spiritual advisor.',
            'Begin intense psychotherapy.',
            'Place on suicide precautions.',
            'Limit visitors to immediate family.'
          ],
          correct: [0, 1, 4, 5, 6],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'single',
          label: 'Multiple Choice',
          question: 'A client tells the nurse that people from Mars are going to invade the Earth. Which response by the nurse would be most therapeutic?',
          instruction: 'Select the best answer.',
          choices: [
            '“That must be frightening to you. Can you tell me how you feel about it?”',
            '“There are no people living on Mars.”',
            '“What do you mean when you say they\'re going to invade the Earth?”',
            '“I know you believe the Earth is going to be invaded, but I don\'t believe that.”'
          ],
          correct: [0],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'multiple',
          label: 'Select All That Apply',
          question: 'The nurse is caring for a hospitalized client with thyrotoxicosis. Which actions can be delegated to unlicensed assistive personnel? Select all that apply.',
          instruction: 'Choose every action that can be delegated.',
          choices: [
            'Administer artificial tears if the client reports eye dryness.',
            'Assist the client to bathe and change the bed linens to maintain comfort.',
            'Lower the room temperature and provide cool cloths on request.',
            'Reinforce to the client that fever is expected with thyrotoxicosis.',
            'Return a call to the client\'s family and tell them the client\'s condition is unchanged.'
          ],
          correct: [1, 2],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'single',
          label: 'Multiple Choice',
          question: 'The nurse receives report for a client at 36 weeks’ gestation who is being transferred for labor induction with an intrauterine fetal demise of unknown duration. Which intervention is most important when receiving care of the client?',
          instruction: 'Select the best answer.',
          choices: [
            'Apply a tocodynamometer and evaluate the current contraction pattern.',
            'Ask about the family\'s desire to speak with a chaplain.',
            'Draw coagulation tests, fibrinogen, and a complete blood count with platelets.',
            'Initiate the oxytocin prescription to begin induction of labor.'
          ],
          correct: [2],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'multiple',
          label: 'Select All That Apply',
          question: 'Which conditions require positioning the client in Semi-Fowler\'s position? Select all that apply.',
          instruction: 'Choose every applicable condition.',
          choices: [
            'Abdominal aneurysm surgery.',
            'Ruptured appendicitis.',
            'Cataract surgery.',
            'Cleft lip.',
            'Infratentorial craniotomy.',
            'Laryngectomy.',
            'Lobectomy.',
            'Thyroidectomy.'
          ],
          correct: [0, 1, 2, 5, 6, 7],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'single',
          label: 'Multiple Choice',
          question: 'A client with untreated diabetes mellitus may lapse into a coma because of acidosis. This acidosis is directly caused by an increased serum concentration of:',
          instruction: 'Select the best answer.',
          choices: ['Ketones.', 'Glucose.', 'Lactic acid.', 'Glutamic acid.'],
          correct: [0],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'single',
          label: 'Multiple Choice',
          question: 'After noticing fetal bradycardia on the external fetal monitor, the labor and delivery nurse performs a vaginal examination and discovers a pulsatile mass outside the vagina. What is the nurse\'s initial action?',
          instruction: 'Select the best answer.',
          choices: [
            'Prepare the client for a Cesarean section.',
            'Tell the client not to push until a contraction arrives.',
            'Escort the client\'s significant other out of the room.',
            'Place the client in Trendelenburg position.'
          ],
          correct: [3],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'single',
          label: 'Multiple Choice',
          question: 'Sheynnis was admitted to the emergency room after fainting during a beauty pageant. She was fasting and following a strict weight-loss diet. Her urine test showed ketones. Which acid-base imbalance is she experiencing?',
          instruction: 'Select the best answer.',
          choices: ['Metabolic acidosis.', 'Metabolic alkalosis.', 'Respiratory alkalosis.', 'Respiratory acidosis.'],
          correct: [0],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
        },
        {
          type: 'multiple',
          label: 'Select All That Apply',
          question: 'A client with Guillain-Barré syndrome\'s respiratory outcomes are being assessed. Which results are deemed acceptable? Select all that apply.',
          instruction: 'Choose every acceptable result.',
          choices: [
            'Spontaneous breathing.',
            '98% oxygen saturation.',
            'Adventitious breath sounds.',
            'Normal arterial blood gas levels.',
            'Vital capacity within normal range.'
          ],
          correct: [0, 1, 3, 4],
          explanation: 'No complete solution or rationale was provided in the source workbook.'
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
      let reviewMode = false;
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
          const disabled = submitted[currentIndex] && !reviewMode ? ' disabled' : '';
          return `<label class="quiz-option${checked ? ' is-selected' : ''}"><input type="${inputType}" name="quiz-answer" value="${index}"${checked}${disabled}><span class="quiz-option-letter">${String.fromCharCode(65 + index)}.</span><span>${choice}</span></label>`;
        }).join('');

        const recordedMessage = submitted[currentIndex] && !reviewMode
          ? '<div class="quiz-answer-recorded" role="status"><i class="bi bi-check-circle me-1"></i>Answer recorded. Correct answers and rationales will be shown after the test.</div>'
          : '';

        modalBody.innerHTML = `<div class="quiz-question-shell"><article class="quiz-question-card"><span class="quiz-type"><i class="bi ${question.type === 'single' ? 'bi-ui-radios' : 'bi-ui-checks'}"></i>${question.label}</span><h2 id="quiz-question-title" class="quiz-question">${currentIndex + 1}. ${question.question}</h2><p class="quiz-instruction">${question.instruction}</p><div class="quiz-options">${options}</div>${recordedMessage}</article></div>`;

        modalBody.querySelectorAll('input[name="quiz-answer"]').forEach((input) => input.addEventListener('change', () => {
          answers[currentIndex] = selectedValues();
          updateSelectedStyles();
          submitButton.disabled = answers[currentIndex].length === 0;
        }));

        previousButton.disabled = !reviewMode && currentIndex === 0;
        previousButton.innerHTML = reviewMode ? '<i class="bi bi-grid-3x3-gap me-1"></i>Back to Review' : '<i class="bi bi-chevron-left me-1"></i>Previous';
        submitButton.hidden = submitted[currentIndex] && !reviewMode;
        submitButton.disabled = answers[currentIndex].length === 0;
        submitButton.textContent = reviewMode ? 'Save Answer' : 'Submit Answer';
        nextButton.hidden = reviewMode || !submitted[currentIndex];
        nextButton.innerHTML = currentIndex === questions.length - 1 ? 'View Results<i class="bi bi-flag ms-1"></i>' : 'Next<i class="bi bi-chevron-right ms-1"></i>';
        modalBody.scrollTop = 0;
      };

      const renderAnswerReview = () => {
        reviewMode = false;
        progressLabel.textContent = 'Review Your Answers';
        progressPercent.textContent = '100%';
        progressBar.style.width = '100%';
        modalFooter.hidden = true;
        const reviewItems = questions.map((question, index) => {
          const answerCount = answers[index].length;
          const answerLabel = answerCount === 1 ? '1 answer selected' : `${answerCount} answers selected`;
          return `<button class="quiz-review-item" type="button" data-review-question="${index}" aria-label="Review question ${index + 1}"><span class="quiz-review-number">${index + 1}</span><span class="quiz-review-item-copy"><strong>${question.label}</strong><span>${answerLabel}</span></span></button>`;
        }).join('');
        modalBody.innerHTML = `<section class="quiz-answer-review"><i class="bi bi-clipboard2-check fs-1 text-primary"></i><h2 class="mt-3">Review Your Answers</h2><p>Select any question below to review or change your response. Your score and the correct answers will remain hidden until you finish the exam.</p><div class="quiz-review-grid">${reviewItems}</div><button id="finish-quiz" class="quiz-start-btn" type="button">Finish and View Results</button></section>`;
        modalBody.querySelectorAll('[data-review-question]').forEach((button) => button.addEventListener('click', () => {
          currentIndex = Number(button.dataset.reviewQuestion);
          reviewMode = true;
          renderQuestion();
        }));
        document.getElementById('finish-quiz').addEventListener('click', renderResults);
        modalBody.scrollTop = 0;
      };

      const renderResults = () => {
        const score = questions.reduce((total, question, index) => total + (sameAnswers(answers[index], question.correct) ? 1 : 0), 0);
        const incorrect = questions.length - score;
        const percentage = Math.round((score / questions.length) * 100);
        const formatAnswers = (question, selected) => selected.length
          ? selected.map((choiceIndex) => `<div><strong>${String.fromCharCode(65 + choiceIndex)}.</strong> ${question.choices[choiceIndex]}</div>`).join('')
          : '<em>No answer selected</em>';
        const reviewRows = questions.map((question, index) => {
          const isCorrect = sameAnswers(answers[index], question.correct);
          return `<tr><td class="quiz-review-question"><div>Question ${index + 1}</div><div class="mt-1">${question.question}</div><span class="quiz-result-badge ${isCorrect ? 'correct' : 'incorrect'}">${isCorrect ? 'Correct' : 'Incorrect'}</span></td><td class="quiz-review-answer">${formatAnswers(question, answers[index])}</td><td class="quiz-review-answer">${formatAnswers(question, question.correct)}</td><td class="quiz-review-rationale">${question.explanation}</td></tr>`;
        }).join('');
        progressLabel.textContent = 'Quiz Complete';
        progressPercent.textContent = '100%';
        progressBar.style.width = '100%';
        modalFooter.hidden = true;
        modalBody.innerHTML = `<section class="quiz-results"><div class="quiz-score">${score}/${questions.length}</div><h2>Practice Quiz Complete</h2><p>You answered ${score} out of ${questions.length} questions correctly. Compare your responses with the correct answers and review the complete rationale for each item.</p><div class="quiz-score-summary" aria-label="Score summary"><div class="quiz-score-stat"><strong>${questions.length}</strong><span>Total Questions</span></div><div class="quiz-score-stat"><strong>${score}</strong><span>Correct</span></div><div class="quiz-score-stat"><strong>${incorrect}</strong><span>Incorrect</span></div><div class="quiz-score-stat"><strong>${percentage}%</strong><span>Score</span></div></div><div class="quiz-review-wrap"><table class="quiz-review-table"><thead><tr><th scope="col">Question</th><th scope="col">Your Answer</th><th scope="col">Correct Answer</th><th scope="col">Complete Solution / Rationale</th></tr></thead><tbody>${reviewRows}</tbody></table></div><button id="restart-quiz" class="quiz-start-btn mt-2" type="button">Try Again</button></section>`;
        document.getElementById('restart-quiz').addEventListener('click', () => {
          currentIndex = 0;
          answers = questions.map(() => []);
          submitted = questions.map(() => false);
          reviewMode = false;
          renderQuestion();
        });
      };

      const enterQuizFullscreen = async () => {
        try {
          if (modal.requestFullscreen) {
            await modal.requestFullscreen();
          } else if (modal.webkitRequestFullscreen) {
            modal.webkitRequestFullscreen();
          }
        } catch (error) {
          // The full-window quiz remains available when a browser blocks fullscreen.
        }
      };

      const leaveQuizFullscreen = async () => {
        try {
          if (document.fullscreenElement && document.exitFullscreen) {
            await document.exitFullscreen();
          } else if (document.webkitFullscreenElement && document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
          }
        } catch (error) {
          // Closing the modal must still work if the browser rejects the request.
        }
      };

      const openQuiz = () => {
        lastFocusedElement = document.activeElement;
        currentIndex = 0;
        answers = questions.map(() => []);
        submitted = questions.map(() => false);
        reviewMode = false;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('quiz-modal-open');
        renderQuestion();
        closeButton.focus();
        enterQuizFullscreen();
      };

      const closeQuiz = async () => {
        await leaveQuizFullscreen();
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('quiz-modal-open');
        if (lastFocusedElement instanceof HTMLElement) lastFocusedElement.focus();
      };

      startButton.addEventListener('click', openQuiz);
      closeButton.addEventListener('click', closeQuiz);
      previousButton.addEventListener('click', () => {
        if (reviewMode) {
          renderAnswerReview();
          return;
        }
        if (currentIndex > 0) {
          currentIndex -= 1;
          renderQuestion();
        }
      });
      submitButton.addEventListener('click', () => {
        answers[currentIndex] = selectedValues();
        if (answers[currentIndex].length === 0) return;
        submitted[currentIndex] = true;
        if (reviewMode) {
          renderAnswerReview();
          return;
        }
        if (currentIndex === questions.length - 1) {
          renderAnswerReview();
          return;
        }
        currentIndex += 1;
        renderQuestion();
      });
      nextButton.addEventListener('click', () => {
        if (!submitted[currentIndex]) return;
        if (currentIndex === questions.length - 1) {
          renderAnswerReview();
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



