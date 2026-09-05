<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/asset-version.php'; ?>
  <?php require_once __DIR__ . '/course-schedule-library.php'; ?>
  <?php require_once __DIR__ . '/course-hero-library.php'; $courseHero = get_course_hero_image('nclex'); ?>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>NCLEX RN PassEasy™ Course | Gapuz Review Academy</title>
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
    #nclex-inclusions {
      background: #fff;
    }
    #nclex-inclusions .section-title h2 {
      letter-spacing: .2px;
    }
    #nclex-inclusions .section-title h2 .accent {
      color: var(--accent-color);
    }
    #nclex-inclusions .inclusion-card {
      background: #fff;
      border: 1px solid #d7e3f2;
      padding: 20px 18px;
      height: 100%;
    }
    #nclex-inclusions .inclusion-icon {
      width: 66px;
      height: 66px;
      border-radius: 50%;
      background: #003057;
      color: #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      flex: 0 0 66px;
      margin-right: 16px;
    }
    #nclex-inclusions .row > div:nth-child(odd) .inclusion-icon {
      background: #003057;
    }
    #nclex-inclusions .row > div:nth-child(even) .inclusion-icon {
      background: var(--accent-color);
    }
    #nclex-inclusions .inclusion-title {
      margin: 0 0 8px;
      color: #003057;
      font-size: 1.125rem;
      font-weight: 700;
      line-height: 1.25;
      text-transform: uppercase;
    }
    #nclex-inclusions .inclusion-copy {
      margin: 0;
      font-size: .875rem;
      line-height: 1.45;
    }
    #nclex-inclusions .inclusion-strip {
      margin-top: 18px;
      background: #e5e7eb !important;
      border: 0 !important;
      padding: 16px 18px;
      display: flex;
      align-items: flex-start;
      justify-content: flex-start;
      text-align: left;
    }
    #nclex-inclusions .inclusion-strip .strip-icon {
      color: #003057;
      font-size: 44px;
      margin-right: 14px;
      line-height: 1;
    }
    #nclex-inclusions .inclusion-strip h4 {
      margin: 0 0 8px;
      color: #003057;
      text-transform: none;
      font-size: 1.25rem;
      font-weight: 700;
      line-height: 1.25;
      font-family: var(--heading-font);
    }
    #nclex-inclusions .inclusion-strip h4 .accent {
      color: var(--accent-color);
    }
    #nclex-inclusions .inclusion-strip h4 .teal {
      color: #00b89c;
    }
    #nclex-inclusions .inclusion-strip p {
      margin: 0;
      font-size: .875rem;
      line-height: 1.45;
      font-family: var(--default-font);
    }
    #nclex-inclusions .inclusion-strip > div { text-align: left; }
    @media (max-width: 767.98px) {
      #nclex-inclusions .inclusion-icon {
        width: 56px;
        height: 56px;
        font-size: 22px;
        margin-right: 12px;
      }
      #nclex-inclusions .inclusion-title { font-size: 1rem; }
      #nclex-inclusions .inclusion-strip h4 {
        font-size: 1.1rem;
      }
    }
    @media (min-width: 992px) {
      #course-package .nclex-package-grid > [class*="col-"] {
        width: 50% !important;
        flex: 0 0 auto !important;
      }
    }
    @media (max-width: 991.98px) {
      #course-package .nclex-package-grid > [class*="col-"] {
        width: 100% !important;
        flex: 0 0 100% !important;
      }
    }
    #course-package .nclex-package-grid .service-item,
    #course-package .nclex-package-grid .service-item h2,
    #course-package .nclex-package-grid .service-item h3,
    #course-package .nclex-package-grid .service-item h4,
    #course-package .nclex-package-grid .service-item h5,
    #course-package .nclex-package-grid .service-item p,
    #course-package .nclex-package-grid .service-item ul,
    #course-package .nclex-package-grid .service-item li {
      text-align: left !important;
    }
    #course-package .nclex-package-grid .service-item .row {
      justify-content: flex-start !important;
    }
    #course-package .nclex-package-grid .list-unstyled li {
      font-size: .875em;
      line-height: 2;
    }
    #course-package .nclex-package-grid .col-8.col-md-9.p-3 {
      background: #d9dee4;
    }
    #course-package .package-card-navy {
      border: 1px solid #003057;
      border-bottom: 5px solid #003057;
    }
    #course-package .package-card-orange {
      border: 1px solid var(--accent-color);
      border-bottom: 5px solid var(--accent-color);
    }
    #course-package .package-card-navy,
    #course-package .package-card-orange {
      position: relative;
      z-index: auto;
      display: flex;
      flex-direction: column;
      height: auto !important;
    }
    #course-package .nclex-package-grid > [class*="col-"] {
      display: flex;
      flex-direction: column;
    }
    #course-package,
    #course-package .container,
    #course-package .row,
    #course-package .col-lg-8,
    #course-package .col-lg-4,
    #course-package .col-md-6 {
      overflow: visible !important;
    }
    #course-package h2,
    #course-package h4,
    #course-package h5,
    #course-package .inclusion-title,
    #course-package .inclusion-card-title {
      font-family: var(--heading-font);
    }
    #course-package p,
    #course-package li,
    #course-package button {
      font-family: var(--default-font);
    }
    #course-package .package-card-navy p.fw-semibold,
    #course-package .package-card-orange p.fw-semibold {
      color: var(--accent-color) !important;
    }
    #course-package .card-title-with-icon {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
    }
    #course-package .card-title-icon {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 15px;
      flex: 0 0 34px;
    }
    #course-package .card-title-icon.navy {
      background: #003057;
    }
    #course-package .card-title-icon.orange {
      background: var(--accent-color);
    }
    #course-package .card-title-with-icon h5 {
      margin: 0;
    }
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
    #course-package .inclusion-toggle {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: auto;
      align-self: flex-start;
    }
    #course-package .package-card-navy .inclusion-toggle {
      background: #003057;
      border-color: #003057;
      color: #fff;
    }
    #course-package .package-card-navy .inclusion-toggle:hover,
    #course-package .package-card-navy .inclusion-toggle:focus {
      background: #0b2f52;
      border-color: #0b2f52;
      color: #fff;
    }
    #course-package .package-card-orange .inclusion-toggle {
      background: var(--accent-color);
      border-color: var(--accent-color);
      color: #fff;
    }
    #course-package .package-card-orange .inclusion-toggle:hover,
    #course-package .package-card-orange .inclusion-toggle:focus {
      background: #d96600;
      border-color: #d96600;
      color: #fff;
    }
    #course-package .card-bottom-meta {
      margin-top: auto;
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 12px;
    }
    #course-package .plans-available {
      text-align: right;
      color: #003057;
      line-height: 1.15;
      border: 2px solid var(--accent-color) !important;
      border-radius: 10px;
      padding: 8px 10px;
      background: #fff;
      min-width: 132px;
    }
    #course-package .plans-available .label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .2px;
    }
    #course-package .plans-available .values {
      font-size: 20px;
      font-weight: 800;
    }
    #course-package .plans-available .values span {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      margin-left: 4px;
    }
    #course-package .inclusion-panel {
      position: absolute;
      left: 0;
      right: 0;
      top: 100%;
      margin-top: 0;
      background: #fff;
      border: 1px solid #cfd8e3;
      border-top: 0;
      padding: 12px 14px;
      z-index: 50;
      opacity: 0;
      transform: translateY(-14px);
      pointer-events: none;
      transition: opacity .2s ease, transform .2s ease;
      box-shadow: 0 8px 18px rgba(0, 0, 0, .08);
    }
    #course-package .package-card-orange .inclusion-panel {
      border-color: color-mix(in srgb, var(--accent-color), #fff 65%);
    }
    #course-package .package-card-navy.is-inclusion-open .inclusion-panel,
    #course-package .package-card-orange.is-inclusion-open .inclusion-panel {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }
    #course-package .inclusion-panel .inclusion-title {
      margin: 0 0 8px;
      font-size: 14px;
      font-weight: 700;
      color: #003057;
    }
    #course-package .inclusion-panel .inclusion-card-title {
      margin: 0 0 8px;
      font-size: 15px;
      font-weight: 800;
      color: #003057;
    }
    #course-package .inclusion-close {
      position: absolute;
      top: -34px;
      right: 0;
      width: 28px;
      height: 28px;
      border: 1px solid #cfd8e3;
      background: #fff;
      color: #003057;
      font-size: 16px;
      line-height: 1;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      display: none;
    }
    #course-package .inclusion-panel ul {
      margin: 0;
      padding-left: 0;
      list-style: none;
      font-size: 14px;
      line-height: 1.6;
    }
    #course-package .inclusion-panel ul li {
      position: relative;
      padding-left: 22px;
      margin-bottom: 4px;
    }
    #course-package .inclusion-panel ul li::before {
      content: "\f058";
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      color: #003057;
      position: absolute;
      left: 0;
      top: 0;
    }
    @media (max-width: 767.98px) {
      #course-package .inclusion-close {
        display: inline-flex;
      }
      body.inclusion-modal-open {
        overflow: hidden;
      }
      body.inclusion-modal-open::before {
        content: "";
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1040;
      }
      #course-package .inclusion-panel {
        position: fixed;
        left: 12px;
        right: 12px;
        top: 50%;
        transform: translateY(-45%);
        margin-top: 0;
        z-index: 2000;
        max-height: 72vh;
        overflow: auto;
        border: 1px solid #cfd8e3;
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22);
      }
      #course-package .package-card-navy.is-inclusion-open .inclusion-panel,
      #course-package .package-card-orange.is-inclusion-open .inclusion-panel {
        transform: translateY(-50%);
      }
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
        <h2>NCLEX - <span class="accent"> RN </span></h2>
        <p>Next Generation NCLEX-RN review preparation for nurses preparing for US and Canadian registered nurse licensure.</p>
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <img src="<?php echo htmlspecialchars($courseHero['image_url'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid" alt="NCLEX - RN review course">
          </div>
          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <h4><b>Prepare for the Next Generation NCLEX with focused coaching and practice tests that are closely similar to the real thing.</b></h4>
            <p class="fst-italic">GRA's NCLEX PassEasy<sup class="gra-trademark">&trade;</sup> course combines expert instruction, flexible learning access, NGN test taking skills enhancement and powerful mentoring that prepares each examinies to sit  and pass the NCLEX confidently.</p>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Live online classes via Zoom with expert lecturers.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Recorded lessons, review materials, and test bank access.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Artemis360 learning tools for practice, tracking, and self-paced study.</span></li>
            </ul>
            <p><a href="#course-package" class="btn course-overview-btn course-overview-btn-primary">View Packages</a> <a href="index.php#courses" class="btn course-overview-btn course-overview-btn-secondary ms-2">Back to Courses</a></p>
          </div>
        </div>
      </div>
    </section>

    <section id="nclex-inclusions" class="section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Inclusions &amp; <span class="accent">Features</span></h2>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-3">
          <div class="col-lg-4 col-md-6">
            <article class="inclusion-card d-flex">
              <span class="inclusion-icon"><i class="bi bi-display"></i></span>
              <div>
                <h3 class="inclusion-title">Live Online Classes Via Zoom</h3>
                <p class="inclusion-copy">Interactive sessions with experienced educators covering high-yield topics, clinical reasoning, and test-taking strategies.</p>
              </div>
            </article>
          </div>
          <div class="col-lg-4 col-md-6">
            <article class="inclusion-card d-flex">
              <span class="inclusion-icon"><i class="bi bi-book"></i></span>
              <div>
                <h3 class="inclusion-title">Self-Paced Review Via Artemis360</h3>
                <p class="inclusion-copy">Access recorded lectures, review modules, and study materials anytime, anywhere. Learn at your own pace.</p>
              </div>
            </article>
          </div>
          <div class="col-lg-4 col-md-6">
            <article class="inclusion-card d-flex">
              <span class="inclusion-icon"><i class="bi bi-people"></i></span>
              <div>
                <h3 class="inclusion-title">Mentoring Via Zoom</h3>
                <p class="inclusion-copy">Get personalized guidance, motivation, and academic support from mentors who are with you every step of the way.</p>
              </div>
            </article>
          </div>
          <div class="col-lg-4 col-md-6">
            <article class="inclusion-card d-flex">
              <span class="inclusion-icon"><i class="bi bi-journal-check"></i></span>
              <div>
                <h3 class="inclusion-title">Test Bank Access Via Artemis360</h3>
                <p class="inclusion-copy">Practice with a wide range of NCLEX-style questions designed to strengthen critical thinking and improve accuracy.</p>
              </div>
            </article>
          </div>
          <div class="col-lg-4 col-md-6">
            <article class="inclusion-card d-flex">
              <span class="inclusion-icon"><i class="bi bi-graph-up-arrow"></i></span>
              <div>
                <h3 class="inclusion-title">Progress Tracking Via Artemis360</h3>
                <p class="inclusion-copy">Monitor your performance, identify areas for improvement, and stay on track with built-in progress reports.</p>
              </div>
            </article>
          </div>
          <div class="col-lg-4 col-md-6">
            <article class="inclusion-card d-flex">
              <span class="inclusion-icon"><i class="bi bi-clipboard2-check"></i></span>
              <div>
                <h3 class="inclusion-title">Assessments &amp; Practice Tests Via Artemis360</h3>
                <p class="inclusion-copy">Take comprehensive assessments and realistic practice tests that simulate the real NCLEX exam.</p>
              </div>
            </article>
          </div>
        </div>

        <div class="inclusion-strip d-flex align-items-start">
          <span class="strip-icon"><i class="fas fa-shield-alt"></i></span>
          <div>
            <h4><span class="teal">Structured Review.</span> Strong Foundation. <span class="accent">Real Results.</span></h4>
            <p>Our program is carefully designed to strengthen every learner's nursing foundation and build the confidence you need to pass the NCLEX exam.</p>
          </div>
        </div>
      </div>
    </section>

    <?php
      $courseSchedule = get_course_schedule_image('nclex');
      $courseScheduleAlt = $courseSchedule['label'] . ' upcoming schedules';
      require_once __DIR__ . DIRECTORY_SEPARATOR . 'passer-library.php';
      $coursePassers = get_latest_passer_images(16, 'nclex');
      if (count($coursePassers) > 0):
    ?>
    <section id="course-passers" class="featured-passers course-passers section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2><span class="accent">NCLEX </span> Passer Stories</h2>
        <p>Successful NCLEX passers from the GRA community.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper featured-passers-swiper" data-course="nclex" data-initial-limit="16" data-next-limit="8">
          <script type="application/json" class="swiper-config">{"loop":false,"rewind":false,"speed":500,"autoplay":false,"slidesPerView":1,"slidesPerGroup":1,"grid":{"rows":2,"fill":"row"},"navigation":{"nextEl":".course-passer-next","prevEl":".course-passer-prev"},"pagination":{"el":".swiper-pagination","type":"bullets","clickable":true},"breakpoints":{"320":{"slidesPerView":1,"slidesPerGroup":1,"spaceBetween":14,"grid":{"rows":2,"fill":"row"}},"768":{"slidesPerView":2,"slidesPerGroup":2,"spaceBetween":18,"grid":{"rows":2,"fill":"row"}},"1200":{"slidesPerView":4,"slidesPerGroup":4,"spaceBetween":20,"grid":{"rows":2,"fill":"row"}}}}</script>
          <div class="swiper-wrapper">
            <?php foreach ($coursePassers as $passerImage): $passerAlt = htmlspecialchars(($passerImage['name'] ?? 'GRA passer') . ' testimonial poster', ENT_QUOTES, 'UTF-8'); $passerUrl = htmlspecialchars($passerImage['url'], ENT_QUOTES, 'UTF-8'); ?>
            <div class="swiper-slide">
              <article class="featured-passer-card">
                <a href="<?php echo $passerUrl; ?>" class="glightbox" data-gallery="nclex-passers">
                  <img src="<?php echo $passerUrl; ?>" alt="<?php echo $passerAlt; ?>" loading="eager" decoding="async">
                </a>
              </article>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="passer-carousel-controls">
            <button type="button" class="swiper-button-prev course-passer-prev" aria-label="Show previous NCLEX passers"></button>
            <div class="swiper-pagination"></div>
            <button type="button" class="swiper-button-next course-passer-next" aria-label="Show next NCLEX passers"></button>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    


    <section id="course-package" class="services section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Course Packages</h2>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
          <div class="col-lg-8">
            <h4 class="mb-3">Full Preparation Programs</h4>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="p-3 bg-white package-card-navy">
                  <div class="card-title-with-icon">
                    <span class="card-title-icon navy"><i class="fas fa-book-medical"></i></span>
                    <h5>Complete Test Prep Package</h5>
                  </div>
                  <p class="mb-2 small text-primary fw-semibold">Our flagship comprehensive NCLEX review program.</p>
                  <p class="mb-3 small">Perfect for first-time takers and repeat test takers who want a full structured review.</p>
                  <div class="card-bottom-meta">
                    <button type="button" class="btn btn-sm btn-primary inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
                    <div class="plans-available">
                      <div class="label">Plans Available</div>
                      <div class="values">3 <span>Months</span></div>
                      <div class="values">6 <span>Months</span></div>
                    </div>
                  </div>
                  <div class="inclusion-panel" data-inclusion-panel>
                    <button type="button" class="inclusion-close" data-inclusion-close aria-label="Close inclusion"><i class="bi bi-x-lg"></i></button>
                    <p class="inclusion-card-title"></p>
                    <p class="inclusion-title">Includes:</p>
                    <ul>
                      <li>Live Online Zoom Classes with expert Testmasters</li>
                      <li>24/7 access to recorded lectures</li>
                      <li>NGN Practice Tests and simulation with progress tracking</li>
                      <li>Test-Taking Strategies</li>
                      <li>Clinical Judgment Training</li>
                      <li>Mentoring &amp; Coaching</li>
					  <li>Free access to NGN Test Bank of 2000+ questions</li>
                    </ul>
					
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 bg-white package-card-navy">
                  <div class="card-title-with-icon">
                    <span class="card-title-icon orange"><i class="fas fa-infinity"></i></span>
                    <h5>Unlimited Test Prep + Test Processing Combo</h5>
                  </div>
                  <p class="mb-2 small text-warning fw-semibold">The all-in-one NCLEX solution - from application to exam readiness.</p>
                  <p class="mb-3 small">Best for candidates who want both expert review and Test Processing.</p>
                  <button type="button" class="btn btn-sm btn-primary inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
                  <div class="inclusion-panel" data-inclusion-panel>
                    <button type="button" class="inclusion-close" data-inclusion-close aria-label="Close inclusion"><i class="bi bi-x-lg"></i></button>
                    <p class="inclusion-card-title"></p>
                    <p class="inclusion-title">Includes:</p>
                    <ul>
                      <li>1-Year Unlimited NCLEX Review</li>
                      <li>Live Zoom Review Sessions by expert Testmasters</li>
                      <li>24/7 access to recorded lectures</li>
                      <li>NGN Practice Tests and simulations</li>
                      <li>Exam readiness coaching and mentoring</li>
                      <li>NCLEX Test Processing Assistance</li>
					  <li>Free access to NGN Test Bank of 2000+ questions</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <h4 class="mb-3">Skill Rebuilding Program</h4>
            <div class="p-3 bg-white package-card-orange">
              <div class="card-title-with-icon">
                <span class="card-title-icon navy"><i class="fas fa-arrows-rotate"></i></span>
                <h5>Refresher Course</h5>
              </div>
              <p class="mb-2 small text-success fw-semibold">Rebuild your nursing foundation with confidence.</p>
              <p class="mb-3 small">Ideal for repeat takers, or those away from nursing practice for a long time and plans to sit for the NCLEX in the near future.</p>
              <button type="button" class="btn btn-sm btn-primary inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
              <div class="inclusion-panel" data-inclusion-panel>
                <button type="button" class="inclusion-close" data-inclusion-close aria-label="Close inclusion"><i class="bi bi-x-lg"></i></button>
                <p class="inclusion-card-title"></p>
                <p class="inclusion-title">Includes:</p>
                <ul>
                  <li>Comprehensive Refresher Lectures by expert Testmasters</li>
                  <li>Access to recorded lectures</li>
                  <li>NGN Practice Questions</li>
                  <li>Core Nursing Reinforcement</li>
                  <li>Clinical Review &amp; Rationalization</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 mt-1">
          <div class="col-lg-8">
            <h4 class="mb-3">Fast Track Intensive Programs</h4>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="p-3 bg-white package-card-navy">
                  <div class="card-title-with-icon">
                    <span class="card-title-icon orange"><i class="fas fa-calendar-day"></i></span>
                    <h5>10-Day Crash Course</h5>
                  </div>
                  <p class="mb-2 small fw-semibold">Intensive high-impact preparation for quick exam readiness.</p>
                  <p class="mb-3 small">Designed for candidates preparing to take the NCLEX soon.</p>
                  <button type="button" class="btn btn-sm btn-primary inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
                  <div class="inclusion-panel" data-inclusion-panel>
                    <button type="button" class="inclusion-close" data-inclusion-close aria-label="Close inclusion"><i class="bi bi-x-lg"></i></button>
                    <p class="inclusion-card-title"></p>
                    <p class="inclusion-title">Includes:</p>
                    <ul>
                      <li>High-Yield NCLEX Concepts</li>
                      <li>Intensive Coaching</li>
                      <li>NGN Drills</li>
                      <li>Final Readiness Assessment</li>
                      <li>Exam Strategy Training</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 bg-white package-card-navy">
                  <div class="card-title-with-icon">
                    <span class="card-title-icon navy"><i class="fas fa-bullseye"></i></span>
                    <h5>3-Day Mentoring Course</h5>
                  </div>
                  <p class="mb-2 small fw-semibold">Focused final coaching to sharpen your test-taking skills.</p>
                  <p class="mb-3 small">Best for final-stage candidates needing targeted mentoring before exam day.</p>
                  <button type="button" class="btn btn-sm btn-primary inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
                  <div class="inclusion-panel" data-inclusion-panel>
                    <button type="button" class="inclusion-close" data-inclusion-close aria-label="Close inclusion"><i class="bi bi-x-lg"></i></button>
                    <p class="inclusion-card-title"></p>
                    <p class="inclusion-title">Includes:</p>
                    <ul>
                      <li>Intensive Mentoring</li>
                      <li>Question Analysis</li>
                      <li>Clinical Judgment Coaching</li>
                      <li>Confidence-Building Strategies</li>
                      <li>Last-Minute Exam Techniques</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <h4 class="mb-3">Inquire / Enroll</h4>
            <div class="d-flex justify-content-center align-items-center text-center h-100 bg-white p-4 package-card-orange">
              <div>
                <div class="mb-3"><i class="fa-solid fa-file-signature" style="font-size: 32px; color: #003057;"></i></div>
                <p class="mb-3 small">Please select your preferred package before submitting the inquiry form.</p>
                <button type="button" class="btn course-overview-btn course-overview-btn-primary" data-bs-toggle="modal" data-bs-target="#nclexInquireEnrollModal">Inquire / Enroll</button>
              </div>
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
        <p>Lead Testmasters for NCLEX preparation.</p>
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"><div class="team-member"><div class="member-img"><img src="assets/img/gra/mia_g.png" class="img-fluid" alt="Dr. Mia A. Gapuz"></div><div class="member-info"><h4>Dr. Mia A. Gapuz, ME, MM</h4><span>President & CEO / Curriculum Designer</span></div></div></div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200"><div class="team-member"><div class="member-img"><img src="assets/img/gra/liz_1.png" class="img-fluid" alt="Prof. Liz Gapuz Iciano"></div><div class="member-info"><h4>Prof. Liz Gapuz Iciano, USRN, MBA, CNOR</h4><span>International NCLEX Testmaster</span></div></div></div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300"><div class="team-member"><div class="member-img"><img src="assets/img/gra/jeni-iciano.jpg" class="img-fluid" alt="Prof. Jeni Gapuz Iciano"></div><div class="member-info"><h4>Prof. Jeni Gapuz Iciano, USRN</h4><span>International Bilingual Testmaster</span></div></div></div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400"><div class="team-member"><div class="member-img"><img src="assets/img/gra/belviz_1.png" class="img-fluid" alt="Prof. Clement C. Belvis, USRN, RM, MPH"></div><div class="member-info"><h4>Prof. Clement C. Belvis, USRN, RM, MPH</h4><span>SENIOR TEST MASTER/ ADVISER</span></div></div></div>
        </div>
      </div>
    </section>

    <section id="course-enroll" class="appointment section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Enroll or Ask for Schedules</h2>
        <p>Submit your details and a GRA adviser can follow up with schedules and enrollment assistance.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <form id="nclex-support-form" action="submit.php" method="post" role="form" class="site-form gra-medicio-form">
          <input type="hidden" name="form_type" value="enrollment">
          <div class="row"><div class="col-md-4 form-group"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div><div class="col-md-4 form-group mt-3 mt-md-0"><input type="email" class="form-control" name="email" placeholder="Email" required></div><div class="col-md-4 form-group mt-3 mt-md-0"><input type="tel" class="form-control" name="phone" placeholder="Mobile / Messaging App" required></div></div>
          <div class="row"><div class="col-md-6 form-group mt-3"><input type="text" name="course" class="form-control" value="NCLEX PassEasy™" readonly></div><div class="col-md-6 form-group mt-3"><select name="review_setup" class="form-select"><option>Live online via Zoom</option><option>Recorded lectures and test bank access</option><option>Processing assistance</option></select></div></div>
          <div class="row">
            <div class="col-md-6 form-group mt-3">
              <select name="inquiry_type" class="form-select" required>
                <option value="">Select Request Type</option>
                <option value="Inquire">Inquire</option>
                <option value="Enroll">Enroll</option>
              </select>
            </div>
            <div class="col-md-6 form-group mt-3">
              <select name="package_interest" class="form-select" required>
                <option value="">Select NCLEX Package to Inquire / Enroll</option>
                <option value="Complete Test Prep Package">Complete Test Prep Package</option>
                <option value="Unlimited Test Prep + Test Processing Combo">Unlimited Test Prep + Test Processing Combo</option>
                <option value="Refresher Course">Refresher Course</option>
                <option value="10-Day Crash Course">10-Day Crash Course</option>
                <option value="3-Day Mentoring Course">3-Day Mentoring Course</option>
              </select>
            </div>
          </div>
          <div class="form-group mt-3"><textarea class="form-control" name="message" rows="5" placeholder="Questions or notes"></textarea></div>
          <div class="mt-3 text-center"><button type="submit">Submit Inquiry</button><p class="form-note mt-3">Your inquiry will be saved for adviser review.</p></div>
        </form>
      </div>
    </section>

    <div class="modal fade" id="nclexInquireEnrollModal" tabindex="-1" aria-labelledby="nclexInquireEnrollModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="nclexInquireEnrollModalLabel">Inquire / Enroll</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="nclex-inquire-enroll-form" action="submit.php" method="post" role="form" class="site-form gra-medicio-form">
              <input type="hidden" name="form_type" value="enrollment">
              <div class="row">
                <div class="col-md-4 form-group"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
                <div class="col-md-4 form-group mt-3 mt-md-0"><input type="email" class="form-control" name="email" placeholder="Email" required></div>
                <div class="col-md-4 form-group mt-3 mt-md-0"><input type="tel" class="form-control" name="phone" placeholder="Mobile / Messaging App" required></div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group mt-3"><input type="text" name="course" class="form-control" value="NCLEX PassEasy™" readonly></div>
                <div class="col-md-6 form-group mt-3">
                  <select name="review_setup" class="form-select">
                    <option>Live online via Zoom</option>
                    <option>Recorded lectures and test bank access</option>
                    <option>Processing assistance</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group mt-3">
                  <select name="inquiry_type" class="form-select" required>
                    <option value="">Select Request Type</option>
                    <option value="Inquire">Inquire</option>
                    <option value="Enroll">Enroll</option>
                  </select>
                </div>
                <div class="col-md-6 form-group mt-3">
                  <select name="package_interest" class="form-select" required>
                    <option value="">Select NCLEX Package to Inquire / Enroll</option>
                    <option value="Complete Test Prep Package">Complete Test Prep Package</option>
                    <option value="Unlimited Test Prep + Test Processing Combo">Unlimited Test Prep + Test Processing Combo</option>
                    <option value="Refresher Course">Refresher Course</option>
                    <option value="10-Day Crash Course">10-Day Crash Course</option>
                    <option value="3-Day Mentoring Course">3-Day Mentoring Course</option>
                  </select>
                </div>
              </div>
              <div class="form-group mt-3"><textarea class="form-control" name="message" rows="5" placeholder="Questions or notes"></textarea></div>
              <div class="mt-3 text-center">
                <button type="submit">Submit Inquiry</button>
                <p class="form-note mt-3">Your inquiry will be saved for adviser review.</p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="nclexInquireEnrollResultModal" tabindex="-1" aria-labelledby="nclexInquireEnrollResultModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="nclexInquireEnrollResultModalLabel">Inquiry / Enrollment Status</h5>
          </div>
          <div class="modal-body">
            <p id="nclexInquireEnrollResultMessage" class="mb-0" style="white-space: pre-line;"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn course-overview-btn course-overview-btn-primary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
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
  <script>
    (function () {
      const toggles = document.querySelectorAll('#course-package [data-inclusion-toggle]');
      const cards = Array.from(document.querySelectorAll('#course-package .package-card-navy, #course-package .package-card-orange'));

      function equalizePackageCards() {
        if (!cards.length) return;
        cards.forEach((card) => {
          card.style.minHeight = '';
        });
        let maxHeight = 0;
        cards.forEach((card) => {
          const h = card.offsetHeight;
          if (h > maxHeight) maxHeight = h;
        });
        cards.forEach((card) => {
          card.style.minHeight = maxHeight + 'px';
        });
      }

      toggles.forEach((btn) => {
        const card = btn.closest('.package-card-navy, .package-card-orange');
        if (!card) return;

        btn.addEventListener('click', function () {
          const panel = card.querySelector('[data-inclusion-panel]');
          const title = card.querySelector('h5');
          const titleSlot = panel ? panel.querySelector('.inclusion-card-title') : null;
          if (titleSlot && title) {
            titleSlot.textContent = title.textContent.trim();
          }
          cards.forEach((c) => {
            if (c !== card) c.classList.remove('is-inclusion-open');
          });
          card.classList.toggle('is-inclusion-open');
          const hasOpen = cards.some((c) => c.classList.contains('is-inclusion-open'));
          document.body.classList.toggle('inclusion-modal-open', hasOpen);
        });

        btn.addEventListener('mouseleave', function () {
          card.classList.remove('is-inclusion-open');
          const hasOpen = cards.some((c) => c.classList.contains('is-inclusion-open'));
          document.body.classList.toggle('inclusion-modal-open', hasOpen);
        });
      });

      document.addEventListener('click', function (event) {
        if (window.matchMedia('(max-width: 767.98px)').matches && document.body.classList.contains('inclusion-modal-open')) {
          const clickedInsidePanel = event.target.closest('#course-package .inclusion-panel');
          const clickedToggle = event.target.closest('#course-package [data-inclusion-toggle]');
          if (!clickedInsidePanel && !clickedToggle) {
            cards.forEach((c) => c.classList.remove('is-inclusion-open'));
            document.body.classList.remove('inclusion-modal-open');
          }
        }
      });

      document.querySelectorAll('#course-package [data-inclusion-close]').forEach((closeBtn) => {
        closeBtn.addEventListener('click', function (event) {
          event.stopPropagation();
          const panel = closeBtn.closest('[data-inclusion-panel]');
          const card = panel ? panel.closest('.package-card-navy, .package-card-orange') : null;
          if (card) {
            card.classList.remove('is-inclusion-open');
          }
          const hasOpen = cards.some((c) => c.classList.contains('is-inclusion-open'));
          document.body.classList.toggle('inclusion-modal-open', hasOpen);
        });
      });

      window.addEventListener('load', equalizePackageCards);
      window.addEventListener('resize', equalizePackageCards);
      equalizePackageCards();
    })();

    (function () {
      const modalForm = document.getElementById('nclex-inquire-enroll-form');
      const supportForm = document.getElementById('nclex-support-form');
      const messageEl = document.getElementById('nclexInquireEnrollResultMessage');
      const sourceModalEl = document.getElementById('nclexInquireEnrollModal');
      const resultModalEl = document.getElementById('nclexInquireEnrollResultModal');

      if ((!modalForm && !supportForm) || !messageEl || !resultModalEl || typeof bootstrap === 'undefined') return;

      const sourceModal = sourceModalEl ? bootstrap.Modal.getOrCreateInstance(sourceModalEl) : null;
      const resultModal = bootstrap.Modal.getOrCreateInstance(resultModalEl);

      const successMessage = [
        'We have successfully received your message.',
        '',
        'Our team from Gapuz Review Academy will review your inquiry and get back to you as soon as possible.',
        '',
        'Please keep an eye on your email or mobile number for our response. We usually reply within 24 hours.',
        '',
        'We appreciate your interest and look forward to helping you with your review journey!',
        '',
        '— Gapuz Review Academy Team'
      ].join('\n');

      document.addEventListener('gra:form-submit-result', function (event) {
        const detail = event && event.detail ? event.detail : null;
        if (!detail || !detail.form) return;
        const isModalForm = modalForm && detail.form === modalForm;
        const isSupportForm = supportForm && detail.form === supportForm;
        if (!isModalForm && !isSupportForm) return;

        if (detail.ok) {
          messageEl.textContent = successMessage;
        } else {
          messageEl.textContent = detail.message || 'Unable to submit inquiry. Please try again.';
        }

        if (isModalForm && sourceModal) {
          sourceModal.hide();
        }
        resultModal.show();
      });
    })();
  </script>
</body>
</html>








