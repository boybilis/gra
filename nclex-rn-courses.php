<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/asset-version.php'; ?>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>NCLEX RN PassEasy Course | Gapuz Review Academy</title>
  <meta name="description" content="Gapuz Review Academy review programs for NCLEX, DHA, HAAD, Prometric, PNLE, SPLE, Civil Service, and online learning.">
  <meta name="keywords" content="Gapuz Review Academy, PassEasy, NCLEX, DHA, HAAD, Prometric, PNLE, SPLE, Civil Service">
  <link href="assets/img/gra/gra-logo.png" rel="icon">
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
    #course-package .package-card-navy h5,
    #course-package .package-card-orange h5 {
      font-weight: 800;
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
    #course-package .inclusion-toggle {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #003057;
      color: #fff;
      border: 1px solid #003057;
      padding: 6px 10px;
      font-size: 13px;
      font-weight: 700;
      line-height: 1;
      cursor: pointer;
      margin-top: auto;
      align-self: flex-start;
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
    #course-package .package-card-orange .inclusion-toggle {
      background: var(--accent-color);
      border-color: var(--accent-color);
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
      padding-left: 18px;
      font-size: 13px;
      line-height: 1.45;
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
        <div class="d-flex align-items-center gap-3"><span><i class="bi bi-telephone me-1"></i> 0285599060 / 85599062</span><span class="d-none d-lg-inline"><i class="bi bi-envelope me-1"></i> Inquire@gratestprepworldwide.com</span></div>
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
            <li><a href="https://artemis360.gapuzreview.com">Artemis360</a></li>
            <li><a href="index.php#testimonials">Passers</a></li>
            <li><a href="index.php#enroll">Contact</a></li>
            <li><a href="test-processing.php">Test Processing</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="cta-btn" href="index.php#enroll">Enroll Now</a>
      </div>
    </div>
  </header>

  <main class="main">

    <section id="course-overview" class="about section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>NCLEX - RN</h2>
        <p>Next Generation NCLEX-RN review preparation for nurses preparing for US and Canadian registered nurse licensure.</p>
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/gra/nclex-course.jpg" class="img-fluid" alt="NCLEX - RN review course">
          </div>
          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <h3>Prepare for the Next Generation NCLEX with focused coaching.</h3>
            <p class="fst-italic">GRA's NCLEX PassEasy course combines expert instruction, flexible learning access, practice support, and review guidance for students preparing for exam day.</p>
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

    <?php
      require_once __DIR__ . DIRECTORY_SEPARATOR . 'passer-library.php';
      $coursePassers = get_latest_passer_images(8, 'nclex');
      if (count($coursePassers) > 0):
    ?>
    <section id="course-passers" class="featured-passers course-passers section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>NCLEX Passer Stories</h2>
        <p>Successful NCLEX passers from the GRA community.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper featured-passers-swiper">
          <script type="application/json" class="swiper-config">{"loop":true,"speed":600,"autoplay":{"delay":4500},"slidesPerView":1,"grid":{"rows":1,"fill":"row"},"pagination":{"el":".swiper-pagination","type":"bullets","clickable":true},"breakpoints":{"320":{"slidesPerView":1,"spaceBetween":18,"grid":{"rows":1}},"768":{"slidesPerView":2,"spaceBetween":20,"grid":{"rows":2}},"1200":{"slidesPerView":4,"spaceBetween":20,"grid":{"rows":2}}}}</script>
          <div class="swiper-wrapper">
            <?php foreach ($coursePassers as $passerImage): $passerAlt = htmlspecialchars(($passerImage['name'] ?? 'GRA passer') . ' testimonial poster', ENT_QUOTES, 'UTF-8'); $passerUrl = htmlspecialchars($passerImage['url'], ENT_QUOTES, 'UTF-8'); ?>
            <div class="swiper-slide">
              <article class="featured-passer-card">
                <a href="<?php echo $passerUrl; ?>" class="glightbox" data-gallery="nclex-passers">
                  <img src="<?php echo $passerUrl; ?>" alt="<?php echo $passerAlt; ?>" loading="lazy" decoding="async">
                </a>
              </article>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
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
                    <button type="button" class="inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
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
                      <li>Live Online Zoom Classes</li>
                      <li>24/7 Recorded Lectures</li>
                      <li>NGN Practice Tests via Artemis360</li>
                      <li>Test-Taking Strategies</li>
                      <li>Clinical Judgment Training</li>
                      <li>Mentoring &amp; Coaching</li>
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
                  <p class="mb-3 small">Best for candidates who want both expert review and guided NCLEX processing support.</p>
                  <button type="button" class="inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
                  <div class="inclusion-panel" data-inclusion-panel>
                    <button type="button" class="inclusion-close" data-inclusion-close aria-label="Close inclusion"><i class="bi bi-x-lg"></i></button>
                    <p class="inclusion-card-title"></p>
                    <p class="inclusion-title">Includes:</p>
                    <ul>
                      <li>1-Year Unlimited NCLEX Review Access</li>
                      <li>Live Zoom Review Sessions</li>
                      <li>Recorded Lectures</li>
                      <li>NGN Practice Tests</li>
                      <li>Exam Readiness Coaching</li>
                      <li>NCLEX Test Processing Assistance</li>
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
              <p class="mb-3 small">Ideal for internationally educated nurses, repeat takers, or those away from nursing practice.</p>
              <button type="button" class="inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
              <div class="inclusion-panel" data-inclusion-panel>
                <button type="button" class="inclusion-close" data-inclusion-close aria-label="Close inclusion"><i class="bi bi-x-lg"></i></button>
                <p class="inclusion-card-title"></p>
                <p class="inclusion-title">Includes:</p>
                <ul>
                  <li>Comprehensive Refresher Lectures</li>
                  <li>Recorded Access</li>
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
                  <button type="button" class="inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
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
                  <button type="button" class="inclusion-toggle" data-inclusion-toggle><i class="bi bi-chevron-down"></i>See inclusion</button>
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
            <div class="p-3 bg-white package-card-orange d-flex flex-column justify-content-center align-items-center text-center">
              <h4 class="mb-2">Powered by Artemis360</h4>
              <img src="assets/img/gra/artemis-platform.jpg" alt="Artemis360" class="img-fluid" style="max-width: 220px;">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="course-details" class="features section light-background">
      <div class="container">
        <div class="row justify-content-around gy-4">
          <div class="features-image col-lg-6" data-aos="fade-up" data-aos-delay="100"><img src="assets/img/gra/artemis-platform.jpg" alt="Artemis360 learning platform"></div>
          <div class="col-lg-5 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <h3>Study support from content to confidence.</h3>
            <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="300"><i class="fa-solid fa-list-check flex-shrink-0"></i><div><h4>Course inclusions</h4><p>Exam pathway orientation, study pacing, high-yield concept review, and question analysis techniques.</p></div></div>
            <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="400"><i class="fa-solid fa-chalkboard-user flex-shrink-0"></i><div><h4>Expert coaching</h4><p>Experienced Testmasters guide students through common exam challenges and readiness planning.</p></div></div>
            <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="500"><i class="fa-solid fa-clock flex-shrink-0"></i><div><h4>Flexible access</h4><p>Recorded lectures and 24/7 review materials help students prepare around work, school, and family schedules.</p></div></div>
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
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100"><div class="team-member"><div class="member-img"><img src="assets/img/gra/mia-gapuz-testmaster.jpg" class="img-fluid" alt="Dr. Mia A. Gapuz"></div><div class="member-info"><h4>Dr. Mia A. Gapuz, ME, MM</h4><span>President & CEO / Curriculum Designer</span></div></div></div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200"><div class="team-member"><div class="member-img"><img src="assets/img/gra/elizabeth-iciano.jpg" class="img-fluid" alt="Prof. Liz Gapuz Iciano"></div><div class="member-info"><h4>Prof. Liz Gapuz Iciano, USRN, MBA, CNOR</h4><span>International NCLEX Testmaster</span></div></div></div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300"><div class="team-member"><div class="member-img"><img src="assets/img/gra/jeni-iciano.jpg" class="img-fluid" alt="Prof. Jeni Gapuz Iciano"></div><div class="member-info"><h4>Prof. Jeni Gapuz Iciano, USRN</h4><span>International Bilingual Testmaster</span></div></div></div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400"><div class="team-member"><div class="member-img"><img src="assets/img/gra/evangeline-gapuz-founder.png" class="img-fluid" alt="Mrs. Evangeline A. Gapuz"></div><div class="member-info"><h4>Mrs. Evangeline A. Gapuz</h4><span>Foundation of GRA</span></div></div></div>
        </div>
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
          <div class="row"><div class="col-md-6 form-group mt-3"><input type="text" name="course" class="form-control" value="NCLEX PassEasy" readonly></div><div class="col-md-6 form-group mt-3"><select name="review_setup" class="form-select"><option>Live online via Zoom</option><option>Recorded lectures and test bank access</option><option>Processing assistance</option></select></div></div>
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
            <p class="mt-3"><strong>Phone:</strong> <span>0285599060 / 85599062</span></p><p><strong>Email:</strong> <span>Inquire@gratestprepworldwide.com</span></p>
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
  </script>
</body>
</html>





