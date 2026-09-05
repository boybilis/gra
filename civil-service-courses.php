<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/asset-version.php'; ?>
  <?php require_once __DIR__ . '/course-schedule-library.php'; ?>
  <?php require_once __DIR__ . '/course-hero-library.php'; $courseHero = get_course_hero_image('civil-service'); ?>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Civil Service PassEasy™ Course | Gapuz Review Academy</title>
  <meta name="description" content="Gapuz Review Academy review programs for NCLEX, DHA, HAAD, Prometric, PNLE, SPLE, Civil Service, and online learning.">
  <meta name="keywords" content="Gapuz Review Academy, PassEasy™, NCLEX, DHA, HAAD, Prometric, PNLE, SPLE, Civil Service">
  <link href="assets/img/favicon.png" rel="icon" type="image/png">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    #course-inclusions { background: #fff; }
    #course-inclusions .section-title h2 .accent { color: var(--accent-color); }
    #course-inclusions .inclusion-card { background: #fff; border: 1px solid #d7e3f2; padding: 20px 18px; height: 100%; }
    #course-inclusions .inclusion-icon { width: 66px; height: 66px; border-radius: 50%; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; flex: 0 0 66px; margin-right: 16px; }
    #course-inclusions .row > div:nth-child(odd) .inclusion-icon { background: #003057; }
    #course-inclusions .row > div:nth-child(even) .inclusion-icon { background: var(--accent-color); }
    #course-inclusions .inclusion-title { margin: 0 0 8px; color: #003057; font-size: 1.05rem; font-weight: 700; line-height: 1.25; text-transform: none; }
    #course-inclusions .inclusion-copy { margin: 0; font-size: .875rem; line-height: 1.45; }
    #course-inclusions .inclusion-strip { margin-top: 18px; background: #e5e7eb; border: 0; padding: 16px 18px; display: flex; align-items: flex-start; text-align: left; }
    #course-inclusions .inclusion-strip .strip-icon { color: #003057; font-size: 40px; margin-right: 14px; line-height: 1; }
    #course-inclusions .inclusion-strip h4 { margin: 0 0 8px; color: #003057; text-transform: none; font-size: 1.15rem; font-weight: 700; line-height: 1.25; font-family: var(--heading-font); }
    #course-inclusions .inclusion-strip h4 .accent { color: var(--accent-color); }
    #course-inclusions .inclusion-strip h4 .teal { color: #00b89c; }
    #course-inclusions .inclusion-strip p { margin: 0; font-size: .875rem; line-height: 1.45; font-family: var(--default-font); }
    #course-details .features-image,
    #course-details .features-image img {
      position: relative;
      z-index: 1 !important;
    }
    #course-details .features-image img {
      border-radius: 12px;
      width: 100%;
      height: auto;
      max-height: 450px;
      object-fit: contain;
      display: block;
    }
    #course-details {
      background: #fff !important;
    }
    #course-details .col-lg-5 .icon-box {
      box-shadow: none !important;
      border: 0 !important;
      background: transparent !important;
      transition: none !important;
      transform: none !important;
    }
    #course-details .col-lg-5 .icon-box:hover,
    #course-details .col-lg-5 .icon-box:focus,
    #course-details .col-lg-5 .icon-box:focus-within {
      box-shadow: none !important;
      border: 0 !important;
      background: transparent !important;
      transform: none !important;
    }
    #course-details .col-lg-5 .icon-box i,
    #course-details .col-lg-5 .icon-box:hover i,
    #course-details .col-lg-5 .icon-box:focus i,
    #course-details .col-lg-5 .icon-box:focus-within i {
      box-shadow: none !important;
      border: 0 !important;
      background: transparent !important;
      transform: none !important;
      transition: none !important;
      color: #003057 !important;
    }
    @media (max-width: 767.98px) {
      #course-inclusions .inclusion-icon { width: 56px; height: 56px; font-size: 22px; margin-right: 12px; }
      #course-inclusions .inclusion-title { font-size: .98rem; }
      #course-inclusions .inclusion-strip h4 { font-size: 1.05rem; }
    }
  </style>
</head>

<body class="index-page gra-page">
  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-between">
        <div class="d-flex align-items-center gap-2"><span class="d-none d-md-inline">Learn With Confidence.</span><a class="online-campus-link" href="online-campus.php">ONLINE CAMPUS</a></div>
        <div class="d-flex align-items-center gap-3"><span><i class="bi bi-telephone me-1"></i> Mobile: +639292135296 / Landline: +63285599060</span><span class="d-none d-lg-inline"><i class="bi bi-envelope me-1"></i> Inquire@gratestprepworldwide.com</span></div>
      </div>
    </div>
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
          <img src="assets/img/gra/gra-logo.png" alt="Gapuz Review Academy logo">
</a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.php#hero" class="active">Home</a></li>
            <li><a href="index.php#about">About</a></li>
            <li class="dropdown"><a href="index.php#courses"><span>Courses</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="nclex-rn-courses.php">NCLEX-RN</a></li>
                <li><a href="dha-rn-courses.php">DHA-RN</a></li>
                <li><a href="doh-haad-rn-courses.php">DOH / HAAD-RN</a></li>
                <li><a href="prometric-rn-courses.php">Prometric-RN</a></li>
                <li><a href="pnle-courses.php">PNLE</a></li>
                <li><a href="sple-courses.php">SPLE</a></li>
                <li><a href="civil-service-courses.php">Civil Service</a></li>
                <li><a href="lept-courses.php">LEPT</a></li>
              </ul>
            </li>
            <li><a href="index.php#free-courses">Free Courses</a></li>
            <li><a href="index.php#testimonials">Passers</a></li>
            <li><a href="index.php#enroll">Contact</a></li>
            <li><a href="test-processing.php">Test Processing</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="cta-btn" href="index.php#enroll">Inquire Now</a>
      </div>
    </div>
  </header>

  <main class="main">

    <section id="course-overview" class="about section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Civil Service</h2>
        <p>Philippine Civil Service Examination review preparation for government eligibility.</p>
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <img src="<?php echo htmlspecialchars($courseHero['image_url'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid" alt="Civil Service review course">
          </div>
          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <h3>Prepare for Philippine Civil Service eligibility.</h3>
            <p class="fst-italic">GRA's Civil Service PassEasy<sup class="gra-trademark">&trade;</sup> course combines expert instruction, flexible learning access, practice support, and review guidance for students preparing for exam day.</p>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Live online classes via Zoom with expert lecturers.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Recorded lessons, review materials, and test bank access.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Artemis360 learning tools for practice, tracking, and self-paced study.</span></li>
            </ul>
            <p><a href="#course-enroll" class="btn course-overview-btn course-overview-btn-primary">Enroll Now</a> <a href="index.php#courses" class="btn course-overview-btn course-overview-btn-secondary ms-2">Back to Courses</a></p>
          </div>
        </div>
      </div>
    </section>

    <section id="course-inclusions" class="section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Inclusions &amp; <span class="accent">Features</span></h2>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-3">
          <div class="col-lg-4 col-md-6"><article class="inclusion-card d-flex"><span class="inclusion-icon"><i class="bi bi-display"></i></span><div><h3 class="inclusion-title">Live Online Classes Via Zoom</h3><p class="inclusion-copy">Interactive sessions with experienced educators covering high-yield topics, clinical reasoning, and test-taking strategies.</p></div></article></div>
          <div class="col-lg-4 col-md-6"><article class="inclusion-card d-flex"><span class="inclusion-icon"><i class="bi bi-book"></i></span><div><h3 class="inclusion-title">Self-Paced Review Via Artemis360</h3><p class="inclusion-copy">Access recorded lectures, review modules, and study materials anytime, anywhere. Learn at your own pace.</p></div></article></div>
          <div class="col-lg-4 col-md-6"><article class="inclusion-card d-flex"><span class="inclusion-icon"><i class="bi bi-people"></i></span><div><h3 class="inclusion-title">Mentoring Via Zoom</h3><p class="inclusion-copy">Get personalized guidance, motivation, and academic support from mentors through each step of your review journey.</p></div></article></div>
          <div class="col-lg-4 col-md-6"><article class="inclusion-card d-flex"><span class="inclusion-icon"><i class="bi bi-journal-check"></i></span><div><h3 class="inclusion-title">Test Bank Access Via Artemis360</h3><p class="inclusion-copy">Practice with exam-style questions designed to strengthen critical thinking, analysis, and decision making.</p></div></article></div>
          <div class="col-lg-4 col-md-6"><article class="inclusion-card d-flex"><span class="inclusion-icon"><i class="bi bi-graph-up-arrow"></i></span><div><h3 class="inclusion-title">Progress Tracking Via Artemis360</h3><p class="inclusion-copy">Monitor your performance, identify improvement areas, and stay on track with built-in progress reports.</p></div></article></div>
          <div class="col-lg-4 col-md-6"><article class="inclusion-card d-flex"><span class="inclusion-icon"><i class="bi bi-clipboard2-check"></i></span><div><h3 class="inclusion-title">Assessments &amp; Practice Tests</h3><p class="inclusion-copy">Take comprehensive assessments and realistic practice tests that simulate the actual Civil Service exam.</p></div></article></div>
        </div>
        <div class="inclusion-strip">
          <span class="strip-icon"><i class="bi bi-shield-check"></i></span>
          <div>
            <h4><span class="teal">Structured Review.</span> Strong Foundation. <span class="accent">Real Results.</span></h4>
            <p>Our program is designed to strengthen foundational skills and build confidence to pass the Civil Service exam.</p>
          </div>
        </div>
      </div>
    </section>

    <?php
      $courseSchedule = get_course_schedule_image('civil-service');
      $courseScheduleAlt = $courseSchedule['label'] . ' upcoming schedules';
      require_once __DIR__ . DIRECTORY_SEPARATOR . 'passer-library.php';
      $coursePassers = get_latest_passer_images(16, 'civil-service');
      if (count($coursePassers) > 0):
    ?>
    <section id="course-passers" class="featured-passers course-passers section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Civil Service Passer Stories</h2>
        <p>Successful Civil Service passers from the GRA community.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper featured-passers-swiper" data-course="civil-service" data-initial-limit="16" data-next-limit="8">
          <script type="application/json" class="swiper-config">{"loop":false,"rewind":false,"speed":500,"autoplay":false,"slidesPerView":1,"slidesPerGroup":1,"grid":{"rows":2,"fill":"row"},"navigation":{"nextEl":".civil-service-passer-next","prevEl":".civil-service-passer-prev"},"pagination":{"el":".swiper-pagination","type":"bullets","clickable":true},"breakpoints":{"320":{"slidesPerView":1,"slidesPerGroup":1,"spaceBetween":14,"grid":{"rows":2,"fill":"row"}},"768":{"slidesPerView":2,"slidesPerGroup":2,"spaceBetween":18,"grid":{"rows":2,"fill":"row"}},"1200":{"slidesPerView":4,"slidesPerGroup":4,"spaceBetween":20,"grid":{"rows":2,"fill":"row"}}}}</script>
          <div class="swiper-wrapper">
            <?php foreach ($coursePassers as $passerImage): $passerAlt = htmlspecialchars(($passerImage['name'] ?? 'GRA passer') . ' testimonial poster', ENT_QUOTES, 'UTF-8'); $passerUrl = htmlspecialchars($passerImage['url'], ENT_QUOTES, 'UTF-8'); ?>
            <div class="swiper-slide">
              <article class="featured-passer-card">
                <a href="<?php echo $passerUrl; ?>" class="glightbox" data-gallery="civil-service-passers">
                  <img src="<?php echo $passerUrl; ?>" alt="<?php echo $passerAlt; ?>" loading="eager" decoding="async">
                </a>
              </article>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="passer-carousel-controls">
            <button type="button" class="swiper-button-prev civil-service-passer-prev" aria-label="Show previous Civil Service passers"></button>
            <div class="swiper-pagination"></div>
            <button type="button" class="swiper-button-next civil-service-passer-next" aria-label="Show next Civil Service passers"></button>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    


    <section id="course-package" class="services section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Course Package</h2>
        <p>Complete Civil Service Exam test preparation in one package.</p>
      </div>
      <div class="container">
        <div class="row justify-content-center gy-4 civil-service-package-grid">
          <div class="col-6 civil-service-package-column" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative h-100 civil-service-package-card">
              <div class="icon"><i class="fas fa-graduation-cap"></i></div>
              <h3>Complete Test Prep Package</h3>
              <h4>Inclusions:</h4>
              <ul class="civil-service-package-list">
                <li><span class="package-list-icon"><i class="fas fa-video" aria-hidden="true"></i></span><span><strong>Lectures:</strong> Live online via Zoom plus 24/7 access to recordings (26 sessions | 104 review hours).</span></li>
                <li><span class="package-list-icon"><i class="fas fa-file-pdf" aria-hidden="true"></i></span><span><strong>Review Materials:</strong> Downloadable handouts and worksheets in PDF in your own Artemis360 dashboard.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-laptop" aria-hidden="true"></i></span><span><strong>Your Own Dashboard:</strong> Access recordings and review materials via the Artemis360 LMS.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-clipboard-question" aria-hidden="true"></i></span><span><strong>Test Bank:</strong> Online practice tests in your Artemis360 dashboard with 24/7 access.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-chart-line" aria-hidden="true"></i></span><span><strong>Mock Test and Assessments:</strong> Online simulations to monitor your progress and readiness to take the CSE.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-chalkboard-user" aria-hidden="true"></i></span><span><strong>Free Tutorials:</strong> For enhancement in your weak areas.</span></li>
              </ul>
              <h2 class="civil-service-package-price"><strong>Price: ₱3,500</strong></h2>
            </div>
          </div>
          <div class="col-6 civil-service-package-column" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative h-100 civil-service-package-card">
              <div class="icon"><i class="fas fa-graduation-cap"></i></div>
              <h3>Final Coaching Test Prep Package</h3>
              <h4>Inclusions:</h4>
              <ul class="civil-service-package-list">
                <li><span class="package-list-icon"><i class="fas fa-video" aria-hidden="true"></i></span><span><strong>Lectures:</strong> Live online via Zoom plus 24/7 access to recordings (5 sessions or 20 hours).</span></li>
                <li><span class="package-list-icon"><i class="fas fa-file-pdf" aria-hidden="true"></i></span><span><strong>Review Materials:</strong> Downloadable handouts and worksheets in PDF in your own Artemis360 dashboard.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-laptop" aria-hidden="true"></i></span><span><strong>Your Own Dashboard:</strong> Access recordings and review materials via the Artemis360 LMS.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-clipboard-question" aria-hidden="true"></i></span><span><strong>Test Bank:</strong> Online practice tests in your Artemis360 dashboard with 24/7 access.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-chart-line" aria-hidden="true"></i></span><span><strong>Mock Test and Assessments:</strong> Online simulations to monitor your progress and readiness to take the CSE.</span></li>
                <li><span class="package-list-icon"><i class="fas fa-chalkboard-user" aria-hidden="true"></i></span><span><strong>Free Tutorials:</strong> For enhancement in your weak areas.</span></li>
              </ul>
              <h2 class="civil-service-package-price"><strong>Price: ₱1,500</strong></h2>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="course-details" class="features section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Upcoming Schedules</h2>
      </div>
      <div class="container">
        <div class="row justify-content-around gy-4">
          <div class="features-image col-lg-7" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper course-schedule-carousel" data-course-schedule-carousel>
              <div class="swiper-wrapper">
                <?php foreach ($courseSchedule['images'] as $scheduleImage): ?>
                  <div class="swiper-slide"><img src="<?php echo htmlspecialchars($scheduleImage, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($courseScheduleAlt, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" decoding="async"></div>
                <?php endforeach; ?>
              </div>
              <?php if ($courseSchedule['image_count'] > 1): ?>
                <button type="button" class="course-schedule-arrow course-schedule-prev" aria-label="Previous schedule image"><i class="bi bi-chevron-left" aria-hidden="true"></i></button>
                <button type="button" class="course-schedule-arrow course-schedule-next" aria-label="Next schedule image"><i class="bi bi-chevron-right" aria-hidden="true"></i></button>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-5 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <?php if ($courseSchedule['has_custom_text']): ?>
            <div class="course-schedule-custom-text"><?php echo $courseSchedule['custom_text']; ?></div>
            <?php else: ?>
            <h4>Study support from content to confidence.</h4>
            <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="300"><i class="fa-solid fa-list-check flex-shrink-0"></i><div><h4>Course inclusions</h4><p>Exam pathway orientation, study pacing, high-yield concept review, and question analysis techniques.</p></div></div>
            <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="400"><i class="fa-solid fa-chalkboard-user flex-shrink-0"></i><div><h4>Expert coaching</h4><p>Experienced Testmasters guide students through common exam challenges and readiness planning.</p></div></div>
            <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="500"><i class="fa-solid fa-clock flex-shrink-0"></i><div><h4>Flexible access</h4><p>Recorded lectures and 24/7 review materials help students prepare around work, school, and family schedules.</p></div></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section><section id="testmasters" class="doctors section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Testmasters</h2>
        <p>Our CSE Test Masters are a team of professional CSE trainers, experienced educators, and CSE topnotchers specializing in Mathematics, English, Filipino, and other key areas of the Civil Service Examination. With extensive teaching experience in some of the Philippines’ leading universities, they combine academic expertise, proven test-taking strategies, and firsthand examination experience to provide high-quality training and mentorship for aspiring civil servants.</p>
      </div>
      <div class="container">
        <article class="cse-lead-profile" data-aos="fade-up" data-aos-delay="100">
          <div class="cse-lead-profile-image"><img src="assets/img/gra/mia_g.png" alt="Dr. Mia A. Gapuz" loading="lazy" decoding="async"></div>
          <div class="cse-lead-profile-content">
            <h3>Dr. Mia A. Gapuz, ME, MM</h3>
            <p class="cse-lead-profile-role">President and CEO, CSE Lead Testmaster and Program Designer</p>
            <p>Dr. Mia has helped many professionals pass the CSE on their first attempt. A business leader and educator, she has over two decades of experience in teaching and running test preparation centers in the Philippines.</p>
            <h4>Credentials and Achievements</h4>
            <ul>
              <li><strong>Education:</strong><br>University of the Philippines – Manila<br>Asian Institute of Management (Makati, Philippines)<br>Instituto de Empresa (Madrid, Spain)<br>WED Technologies, Harvard (ongoing)</li>
              <li><strong>Academic Awards:</strong><br>Board Topnotcher (Rank #2, Nationwide)<br>Most Outstanding Clinician (Endodontics), University of the Philippines – Manila<br>Highest Distinction, Asian Institute of Management</li>
              <li><strong>International Award:</strong><br>Top 10 Asian Institute of Management Philippines Alumni Leaders 2024 (CEO Insights Asia)</li>
              <li><strong>Previous Work:</strong><br>President and CEO, RA Gapuz Review Center, Inc.</li>
            </ul>
          </div>
        </article>
      </div>
    </section>

    <section id="course-enroll" class="appointment section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Enroll or Ask for Schedules</h2>
        <p>Submit your details and a GRA adviser can follow up with schedules and enrollment assistance.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <form action="submit.php" method="post" role="form" class="site-form gra-medicio-form">
          <input type="hidden" name="form_type" value="enrollment">
          <div class="row"><div class="col-md-4 form-group"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div><div class="col-md-4 form-group mt-3 mt-md-0"><input type="email" class="form-control" name="email" placeholder="Email" required></div><div class="col-md-4 form-group mt-3 mt-md-0"><input type="tel" class="form-control" name="phone" placeholder="Mobile / Messaging App" required></div></div>
          <div class="row"><div class="col-md-6 form-group mt-3"><input type="text" name="course" class="form-control" value="Civil Service PassEasy™" readonly></div><div class="col-md-6 form-group mt-3"><select name="review_setup" class="form-select"><option>Live online via Zoom</option><option>Recorded lectures and test bank access</option><option>Processing assistance</option></select></div></div>
          <div class="form-group mt-3"><textarea class="form-control" name="message" rows="5" placeholder="Questions or notes"></textarea></div>
          <div class="mt-3 text-center"><button type="submit">Submit Inquiry</button><p class="form-note mt-3">Your inquiry will be saved for adviser review.</p></div>
        </form>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-6 footer-about">
          <a href="index.php" class="logo d-flex align-items-center"><img src="assets/img/gra/gra-logo.png" alt="Gapuz Review Academy logo"></a>
          <div class="footer-contact pt-3">
            <p>Ground Floor RA Gapuz Bldg., 1128 Alhambra St. corner United Nations Ave.</p>
            <p>Ermita Manila, Philippines</p>
            <p class="mt-3"><strong>Phone:</strong> <span>Mobile: +639292135296 / Landline: +63285599060</span></p><p><strong>Email:</strong> <span>Inquire@gratestprepworldwide.com</span></p>
          </div>
          <div class="social-links d-flex mt-4"><a href="https://www.facebook.com/gapuzreviewacademyofficial"><i class="bi bi-facebook"></i></a></div>
        </div>
        <div class="col-lg-2 col-md-3 footer-links"><h4>Courses</h4><ul><li><a href="nclex-rn-courses.php">NCLEX</a></li><li><a href="dha-rn-courses.php">DHA</a></li><li><a href="doh-haad-rn-courses.php">HAAD / DOH</a></li><li><a href="prometric-rn-courses.php">Prometric</a></li></ul></div>
        <div class="col-lg-2 col-md-3 footer-links"><h4>More Programs</h4><ul><li><a href="pnle-courses.php">PNLE</a></li><li><a href="sple-courses.php">SPLE</a></li><li><a href="civil-service-courses.php">Civil Service</a></li><li><a href="online-campus.php">Online Campus</a></li></ul></div>
        <div class="col-lg-3 col-md-3 footer-links"><h4>Quick Links</h4><ul><li><a href="index.php#about">About GRA</a></li><li><a href="index.php#free-courses">Free Courses</a></li><li><a href="https://artemis360.gapuzreview.com">Artemis360</a></li><li><a href="index.php#enroll">Enroll</a></li></ul></div>
      </div>
    </div>
    <div class="container copyright text-center mt-4"><p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p></div>
  </footer>

  <div class="floating-contact-stack" id="floating-contact-stack" aria-label="Floating contact actions">
    <div class="floating-contact-actions" id="floating-contact-actions">
      <a href="tel:+639292135296" aria-label="Call GRA"><i class="bi bi-telephone"></i></a>
      <a href="https://wa.me/639292135296" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><i class="bi bi-whatsapp"></i></a>
      <a href="https://m.me/gapuzreviewacademyofficial" target="_blank" rel="noopener" aria-label="Open Messenger"><i class="bi bi-messenger"></i></a>
      <a href="test-processing.php#processing-consultation" aria-label="Book consultation"><i class="bi bi-calendar-check"></i></a>
    </div>
    <button type="button" class="floating-contact-toggle" id="floating-contact-toggle" aria-label="Open contact actions" aria-expanded="false">
      <i class="bi bi-three-dots-vertical"></i>
    </button>
  </div>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?php echo versioned_asset('assets/js/main.js'); ?>"></script>
  <script src="<?php echo versioned_asset('assets/js/gra-content.js'); ?>"></script>
</body>
</html>





