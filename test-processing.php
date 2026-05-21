<?php
declare(strict_types=1);
require_once __DIR__ . '/asset-version.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Test Processing | Gapuz Review Academy</title>
  <meta name="description" content="Gapuz Review Academy test processing support and guidance.">
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    /* Fallback: keep content visible even if AOS JS does not initialize. */
    .test-processing-page [data-aos] {
      opacity: 1 !important;
      transform: none !important;
    }
    .test-processing-page .processing-services .service-item {
      border: 0;
      box-shadow: none;
      color: #fff;
      min-height: 100%;
    }
    .test-processing-page .processing-services .service-item:before {
      display: none;
    }
    .test-processing-page .processing-services .row > div:nth-child(odd) .service-item {
      background: #003057;
    }
    .test-processing-page .processing-services .row > div:nth-child(even) .service-item {
      background: #ff6e11;
    }
    .test-processing-page .processing-services .service-item h3,
    .test-processing-page .processing-services .service-item p,
    .test-processing-page .processing-services .service-item .icon i {
      color: #fff;
    }
    .test-processing-page .processing-services .service-item .icon {
      width: auto;
      height: auto;
      margin: 0 0 14px;
      background: transparent;
      border: 0;
      border-radius: 0;
      display: block;
    }
    .test-processing-page .processing-services .service-item .icon i {
      font-size: 28px;
      line-height: 1;
    }
    .test-processing-page .btn.btn-primary {
      background: var(--accent-color);
      border-color: var(--accent-color);
      color: #fff;
    }
    .test-processing-page .btn.btn-primary:hover,
    .test-processing-page .btn.btn-primary:focus {
      background: #f37507;
      border-color: #f37507;
      color: #fff;
    }
    @media (max-width: 575px) {
      .test-processing-page .processing-steps .row > [class*="col-"] {
        width: 50%;
        flex: 0 0 auto;
      }
      .test-processing-page .processing-steps .row {
        --bs-gutter-x: 12px;
        --bs-gutter-y: 12px;
      }
      .test-processing-page .processing-steps .icon-box {
        padding: 12px;
      }
      .test-processing-page .processing-steps .icon-box h4 {
        font-size: 14px;
      }
      .test-processing-page .processing-steps .icon-box p {
        font-size: 12px;
        line-height: 1.35;
      }
    }
  </style>
</head>
<body class="index-page gra-page test-processing-page">
  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="d-none d-md-flex align-items-center">Learn with confidence. Review with support.</div>
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
            <li><a href="index.php#hero">Home</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#courses">Courses</a></li>
            <li><a href="index.php#free-courses">Free Courses</a></li>
            <li><a href="https://artemis360.gapuzreview.com">Artemis360</a></li>
            <li><a href="index.php#testimonials">Passers</a></li>
            <li><a href="index.php#enroll">Contact</a></li>
            <li><a href="test-processing.php" class="active">Test Processing</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="cta-btn" href="index.php#enroll">Enroll Now</a>
      </div>
    </div>
  </header>

  <main class="main">
    <section id="processing-hero" class="hero section">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center text-center">
          <div class="col-lg-10">
            <h2>Your Fast, Reliable Path to NCLEX &amp; International Nursing Licensure</h2>
            <p>From credential evaluation to exam eligibility, GRA Test Processing guides you every step of the way&#8212;so you can focus on passing.</p>
            <div class="d-flex flex-column flex-md-row justify-content-center gap-2 gap-md-3 mt-3">
              <a href="index.php#enroll" class="btn btn-primary">Book a Free Consultation</a>
              <a href="#processing-packages" class="btn btn-primary">View Processing Packages</a>
              <a href="index.php#enroll" class="btn btn-primary">Start My Application</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="about section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Why Choose GRA Test Processing</h2>
        <p>Why Nurses Trust GRA Test Processing</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-6">
            <h3>Trust Badges</h3>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Fast &amp; Reliable Processing</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Expert Guidance</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Trusted by Nurses Worldwide</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Review + Processing in One Place</span></li>
            </ul>
          </div>
          <div class="col-lg-6">
            <h3>Built for Serious Applicants</h3>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Transparent step-by-step updates</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Combined review + processing advantage</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Trusted digital support team</span></li>
            </ul>
            <p><a href="index.php#enroll" class="btn btn-primary">Request Processing Assistance</a></p>
          </div>
        </div>
      </div>
    </section>

    <section id="processing-packages" class="services section processing-services">
      <div class="container section-title" data-aos="fade-up">
        <h2>Processing Coverage</h2>
        <p>Our processing team can assist you with the following services.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>Test Processing</h3>
              <p>End-to-end assistance for test processing requirements and submission flow.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>Licensing Assistance</h3>
              <p>Guidance on licensing requirements and document preparation.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>Reactivation</h3>
              <p>Support for reactivating licenses and completing required steps.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>License By Endorsement</h3>
              <p>Assistance for endorsement pathways and application processing.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>Visa Screen</h3>
              <p>Help with VisaScreen requirements, document flow, and updates.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>Consultancy</h3>
              <p>Professional guidance for exam pathway and processing planning.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>ATT</h3>
              <p>Support for ATT-related processing and timeline follow-up.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <h3>Trouble Shooting</h3>
              <p>Resolution support for common processing blockers and delays.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="features section light-background processing-steps">
      <div class="container section-title" data-aos="fade-up">
        <h2>How It Works</h2>
        <p>A clear processing flow designed to reduce delays and confusion.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <i class="fa-solid fa-circle-info flex-shrink-0"></i>
              <div><h4>1. Initial Assessment</h4><p>Share your target exam and background so we can map your required steps.</p></div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <i class="fa-solid fa-list-check flex-shrink-0"></i>
              <div><h4>2. Checklist Setup</h4><p>Receive a structured checklist and guidance for each document requirement.</p></div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <i class="fa-solid fa-paper-plane flex-shrink-0"></i>
              <div><h4>3. Submission Stage</h4><p>Proceed with filing while our team helps you track status and needed updates.</p></div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <i class="fa-solid fa-flag-checkered flex-shrink-0"></i>
              <div><h4>4. Exam Readiness</h4><p>Finalize scheduling and continue your review path with fewer processing blockers.</p></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="appointment section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Start Your Processing Plan</h2>
        <p>Connect with a GRA adviser for personalized processing guidance.</p>
      </div>
      <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <a href="index.php#enroll" class="btn btn-primary">Talk to a Processing Adviser</a>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container copyright text-center mt-4">
      <p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p>
    </div>
  </footer>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="<?php echo versioned_asset('assets/js/main.js'); ?>"></script>
  <script src="<?php echo versioned_asset('assets/js/gra-content.js'); ?>"></script>
</body>
</html>
