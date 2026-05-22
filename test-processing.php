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
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    /* Fallback: keep content visible even if AOS JS does not initialize. */
    .test-processing-page [data-aos] {
      opacity: 1 !important;
      transform: none !important;
    }
    .test-processing-page .processing-services .service-item {
      border: 1px solid #f37507;
      border-bottom-width: 5px;
      box-shadow: none;
      color: #1f2d3d;
      min-height: 100%;
      text-align: left;
      background: #fff;
    }
    .test-processing-page .processing-services .row > div:nth-child(even) .service-item {
      border-color: #003057;
    }
    .test-processing-page .processing-services .service-item:before {
      display: none;
    }
    .test-processing-page .processing-services .row > div:nth-child(even) .service-item:after,
    .test-processing-page .processing-services .row > div:nth-child(even) .service-item h3:after {
      background: #003057 !important;
    }
    .test-processing-page .processing-services .service-item h3,
    .test-processing-page .processing-services .service-item p,
    .test-processing-page .processing-services .service-item .icon i {
      color: #1f2d3d;
    }
    .test-processing-page .processing-services .service-item h3 {
      color: #003057;
    }
    .test-processing-page .processing-services .service-item .processing-checklist span,
    .test-processing-page .processing-services .service-item .processing-checklist i,
    .test-processing-page .processing-services .service-item p small {
      color: #1f2d3d;
    }
    .test-processing-page .processing-services .processing-flag {
      display: inline-block;
      font-size: 20px;
      line-height: 1;
      margin-bottom: 10px;
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
    .test-processing-page .processing-checklist {
      list-style: none;
      padding-left: 0;
      margin: 0;
    }
    .test-processing-page .processing-checklist.processing-checklist-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      column-gap: 24px;
      row-gap: 6px;
    }
    .test-processing-page .processing-checklist li {
      margin-bottom: 8px;
      font-size: 14px;
      line-height: 1.35;
    }
    .test-processing-page .processing-checklist li:last-child {
      margin-bottom: 0;
    }
    .test-processing-page .processing-checklist span {
      line-height: 1.5;
    }
    .test-processing-page .trust-stack .learning-mode-card i {
      display: none !important;
    }
    .test-processing-page .trust-stack .learning-mode-card {
      padding: 12px 10px;
      gap: 8px;
      align-items: flex-start;
      border: 1px solid #b6bcc6 !important;
      border-radius: 8px;
      box-shadow: none !important;
    }
    .test-processing-page .trust-stack .learning-mode-card h6 {
      font-size: 16px;
      line-height: 1.2;
      margin: 0;
      font-weight: 700;
    }
    .test-processing-page .trust-stack .learning-mode-card h6::after {
      display: none !important;
      content: none !important;
    }
    .test-processing-page .trust-stack > [class*="col-"]:nth-child(odd) .learning-mode-card h6 {
      color: #ff6e11;
    }
    .test-processing-page .trust-stack > [class*="col-"]:nth-child(even) .learning-mode-card h6 {
      color: #003057;
    }
    .test-processing-page .trust-stack .learning-mode-card p {
      font-size: 13px;
      line-height: 1.25;
      margin: 4px 0 0;
    }
    .test-processing-page .processing-steps .processing-summary-row .icon-box {
      padding: 10px 16px;
      gap: 6px;
      align-items: flex-start;
      justify-content: flex-start;
      border: 1px solid #b6bcc6 !important;
      border-radius: 8px;
      box-shadow: none !important;
      background: #fff;
      border-left-width: 1px;
      min-height: 100% !important;
      height: 100% !important;
    }
    .test-processing-page .processing-steps .processing-summary-row .icon-box:hover,
    .test-processing-page .processing-steps .processing-summary-row .icon-box:focus,
    .test-processing-page .processing-steps .processing-summary-row .icon-box:focus-within {
      box-shadow: none !important;
    }
    .test-processing-page .processing-steps .processing-summary-row .step-icon {
      display: none !important;
    }
    .test-processing-page .processing-steps .processing-summary-row .summary-with-icon .step-icon {
      display: inline-flex !important;
      width: 44px;
      height: 44px;
      min-width: 44px;
      min-height: 44px;
      margin-right: 8px;
      background: #fff;
      color: #003057;
    }
    .test-processing-page .processing-steps .processing-summary-row .summary-with-icon .step-icon i {
      display: block !important;
      font-size: 22px !important;
      color: #003057 !important;
      line-height: 1 !important;
    }
    .test-processing-page .processing-steps .processing-summary-row .summary-logo {
      width: 72px;
      height: 72px;
      min-width: 72px;
      min-height: 72px;
      margin-right: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border-radius: 8px;
      background: #fff;
      border: 1px solid #ff6e11;
    }
    .test-processing-page .processing-steps .processing-summary-row .summary-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
    }
    .test-processing-page .processing-steps .processing-summary-row .step-head {
      margin-bottom: 0;
      line-height: 1.1;
    }
    .test-processing-page .processing-steps .processing-summary-row .icon-box h4 {
      font-size: 15px;
      line-height: 1.15;
      margin: 0;
      font-weight: 700;
      color: #003057;
    }
    .test-processing-page .processing-steps .processing-summary-row > [class*="col-"]:nth-child(even) .icon-box h4 {
      color: #ff6e11;
    }
    .test-processing-page .processing-steps .processing-summary-row .icon-box p {
      font-size: 12px;
      line-height: 1.2;
      margin: 1px 0 0;
    }
    .test-processing-page .processing-steps .processing-summary-row .summary-secondary {
      align-items: center !important;
      justify-content: center !important;
    }
    .test-processing-page .processing-steps .processing-summary-row .summary-primary {
      align-items: center !important;
      justify-content: center !important;
    }
    .test-processing-page .processing-outline-title {
      font-size: 24px;
      line-height: 1.25;
      margin-bottom: 12px;
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
    .test-processing-page .btn.btn-processing-blue {
      background: #003057;
      border-color: #003057;
      color: #fff;
    }
    .test-processing-page .btn.btn-processing-blue:hover,
    .test-processing-page .btn.btn-processing-blue:focus {
      background: #002542;
      border-color: #002542;
      color: #fff;
    }
    .test-processing-page .processing-hero-actions {
      position: relative;
      z-index: 3;
      pointer-events: auto;
    }
    .test-processing-page .processing-hero-actions a {
      pointer-events: auto;
    }
    .test-processing-page .processing-steps .icon-box {
      background: #fff;
      border: 1px solid #dce4ee;
      border-left: 6px solid #003057;
      border-radius: 12px;
      min-height: 0;
      padding: 10px 12px;
      box-shadow: none;
    }
    .test-processing-page .processing-steps .row {
      --bs-gutter-x: 12px;
      --bs-gutter-y: 12px;
    }
    .test-processing-page .processing-steps .section-title {
      padding-bottom: 8px;
      margin-bottom: 0;
    }
    .test-processing-page .processing-steps .container[data-aos][data-aos-delay="100"] {
      margin-top: 6px;
    }
    .test-processing-page .processing-steps .row > div:nth-child(even) .icon-box {
      border-left-color: #ff6e11;
    }
    .test-processing-page .processing-steps .step-icon {
      width: 58px;
      height: 58px;
      min-width: 58px;
      min-height: 58px;
      max-width: 58px;
      max-height: 58px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #fff;
      color: #003057;
      flex: 0 0 58px;
      margin-right: 10px;
      aspect-ratio: 1 / 1;
    }
    .test-processing-page .processing-steps .step-icon i {
      font-size: 28px;
      color: inherit;
      display: block !important;
      width: auto !important;
      height: auto !important;
      margin: 0 !important;
      padding: 0 !important;
      box-shadow: none !important;
      background: transparent !important;
      border-radius: 0 !important;
      line-height: 1 !important;
    }
    .test-processing-page .processing-steps .row > div:nth-child(even) .step-icon {
      background: #fff;
      color: #ff6e11;
    }
    .test-processing-page .processing-steps .step-head {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 3px;
    }
    .test-processing-page .processing-steps .step-no {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #003057;
      color: #fff;
      font-size: 15px;
      font-weight: 700;
      line-height: 1;
      flex: 0 0 36px;
    }
    .test-processing-page .processing-steps .row > div:nth-child(even) .step-no {
      background: #ff6e11;
    }
    .test-processing-page .processing-steps .icon-box h4 {
      font-size: 18px;
      margin: 0;
      line-height: 1.15;
      color: #0d2d66;
    }
    .test-processing-page .processing-steps .icon-box p {
      margin: 0;
      color: #1f2d3d;
      font-size: 14px;
      line-height: 1.25;
    }
    .test-processing-page .processing-consultation-wrap {
      position: relative;
      z-index: 4;
      pointer-events: auto;
    }
    .test-processing-page .processing-consultation-form,
    .test-processing-page .processing-consultation-form input,
    .test-processing-page .processing-consultation-form textarea,
    .test-processing-page .processing-consultation-form button {
      pointer-events: auto;
    }
    .test-processing-page .floating-contact-stack {
      position: fixed;
      right: 12px;
      bottom: 14px;
      z-index: 1100;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .test-processing-page .floating-contact-toggle {
      width: 44px;
      height: 44px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 0;
      border-radius: 50%;
      background: #ff6e11;
      color: #fff;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }
    .test-processing-page .floating-contact-toggle i {
      font-size: 18px;
      line-height: 1;
    }
    .test-processing-page .floating-contact-actions {
      display: none;
      flex-direction: column;
      gap: 8px;
    }
    .test-processing-page .floating-contact-stack.is-open .floating-contact-actions {
      display: flex;
    }
    .test-processing-page .floating-contact-stack a {
      width: 44px;
      height: 44px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      color: #fff;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }
    .test-processing-page .floating-contact-stack a i {
      font-size: 18px;
      line-height: 1;
    }
    .test-processing-page .floating-contact-stack a:nth-child(1) { background: #003057; }
    .test-processing-page .floating-contact-stack a:nth-child(2) { background: #25D366; }
    .test-processing-page .floating-contact-stack a:nth-child(3) { background: #0084ff; }
    .test-processing-page .floating-contact-stack a:nth-child(4) { background: #ff6e11; }
    .test-processing-page #scroll-top {
      right: 12px;
      bottom: 14px;
      border-radius: 50%;
      width: 44px;
      height: 44px;
      background: #003057;
      z-index: 1099;
    }
    .test-processing-page .floating-contact-stack {
      bottom: 66px;
    }
    .test-processing-page .floating-contact-stack.with-scroll-top {
      bottom: 70px;
    }
    @media (max-width: 768px) {
      .test-processing-page #processing-hero.section {
        padding: 0 !important;
      }
      .test-processing-page #processing-hero .carousel {
        min-height: 520px !important;
      }
      .test-processing-page #processing-hero .carousel-item {
        padding-top: 30px;
        min-height: 520px !important;
        align-items: flex-start !important;
      }
      .test-processing-page #processing-hero .carousel-item > img {
        height: 520px !important;
        object-fit: cover;
        object-position: center top;
      }
      .test-processing-page #processing-hero .container {
        margin-top: 20px !important;
        margin-bottom: 0 !important;
        padding-top: 20px !important;
        padding-bottom: 25px !important;
      }
      .test-processing-page #processing-hero .processing-hero-actions {
        margin-top: 14px !important;
      }
    }
    @media (max-width: 575px) {
      .test-processing-page .processing-checklist.processing-checklist-grid {
        grid-template-columns: 1fr;
        row-gap: 4px;
      }
      .test-processing-page #processing-hero h2 {
        font-size: 1.5rem;
        line-height: 1.35;
      }
      .test-processing-page .trust-stack .learning-mode-card {
        padding: 10px;
      }
      .test-processing-page .trust-stack .learning-mode-card h6 {
        font-size: 14px;
        line-height: 1.25;
      }
      .test-processing-page .processing-steps .journey-grid > [class*="col-"] {
        width: 50%;
        flex: 0 0 50%;
      }
      .test-processing-page .processing-steps .processing-summary-row > [class*="col-"] {
        width: 100%;
        flex: 0 0 100%;
      }
      .test-processing-page .processing-steps .journey-grid > .step-nine-col {
        width: 100%;
        flex: 0 0 100%;
      }
      .test-processing-page .processing-steps .row {
        --bs-gutter-x: 12px;
        --bs-gutter-y: 12px;
      }
      .test-processing-page .processing-steps .step-icon {
        display: none !important;
      }
      .test-processing-page .processing-steps .processing-summary-row .summary-with-icon .step-icon {
        display: inline-flex !important;
      }
      .test-processing-page .processing-steps .step-no {
        width: 24px;
        height: 24px;
        font-size: 13px;
      }
      .test-processing-page .processing-steps .icon-box h4 {
        font-size: 14px;
        line-height: 1.2;
      }
      .test-processing-page .processing-steps .icon-box p {
        font-size: 12px;
        line-height: 1.3;
      }
      .test-processing-page .processing-steps .step-head {
        gap: 6px;
        margin-bottom: 2px;
      }
      .test-processing-page .processing-steps .icon-box {
        padding: 9px 10px;
      }
    }
  </style>
</head>
<body class="index-page gra-page test-processing-page">
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
            <li><a href="index.php#hero">Home</a></li>
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
      <div id="processing-hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-item active">
          <img src="assets/img/gra/hero-artemis-cover.jpg" alt="Test processing hero cover" fetchpriority="high">
          <div class="container passeasy-hero-container col-lg-8">
            <div class="row align-items-center gy-3">
              <div class="text-center">
                <span class="eyebrow">GRA TEST PROCESSING</span>
                <h2>Your Fast, Reliable Path to NCLEX &amp; International Nursing Licensure</h2>
                <p>From credential evaluation, to test preparation, to obtaining your license. <b> GRA Test Processing </b>guides you every step of the way&#8212;so you can focus on passing.</p>
                <div class="d-flex flex-column flex-md-row justify-content-center gap-2 gap-md-3 mt-3 processing-hero-actions">
                  <a href="#processing-consultation" class="btn btn-primary">Book a Free Consultation</a>
                  <a href="test-processing.php#processing-packages" class="btn btn-processing-blue">View Processing Packages</a>
                  <a href="#processing-consultation" class="btn btn-primary">Start My Application</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="processing-testimonials" class="featured-passers section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Processing Testimonials</h2>
        <p>Recent licensing milestones from our test processing clients.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <?php
          $processingDir = __DIR__ . '/assets/img/gra/processing';
          $processingImages = [];
          if (is_dir($processingDir)) {
            $processingEntries = scandir($processingDir);
            if (is_array($processingEntries)) {
              natcasesort($processingEntries);
              foreach ($processingEntries as $processingEntry) {
                if ($processingEntry === '.' || $processingEntry === '..') {
                  continue;
                }
                $processingImagePath = $processingDir . '/' . $processingEntry;
                if (!is_file($processingImagePath)) {
                  continue;
                }
                $processingExt = strtolower((string) pathinfo($processingEntry, PATHINFO_EXTENSION));
                if (!in_array($processingExt, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                  continue;
                }
                $processingImageName = pathinfo($processingEntry, PATHINFO_FILENAME);
                $processingImageLabel = ucwords(str_replace(['-', '_'], ' ', $processingImageName));
                $processingImages[] = [
                  'url' => 'assets/img/gra/processing/' . rawurlencode($processingEntry),
                  'label' => $processingImageLabel !== '' ? $processingImageLabel : 'Processing Testimonial',
                ];
              }
            }
          }
          $processingImageCount = count($processingImages);
          $processingDesktopSlides = 4;
          $processingTabletSlides = 2;
          $processingSwiperConfig = [
            'loop' => $processingImageCount > $processingDesktopSlides,
            'speed' => 600,
            'autoplay' => $processingImageCount > 1 ? ['delay' => 4200] : false,
            'slidesPerView' => 1,
            'grid' => ['rows' => 1, 'fill' => 'row'],
            'spaceBetween' => 16,
            'pagination' => [
              'el' => '.swiper-pagination',
              'clickable' => true,
            ],
            'breakpoints' => [
              '320' => ['slidesPerView' => 1, 'spaceBetween' => 18, 'grid' => ['rows' => 1]],
              '768' => ['slidesPerView' => $processingTabletSlides, 'spaceBetween' => 18, 'grid' => ['rows' => 1]],
              '1200' => ['slidesPerView' => $processingDesktopSlides, 'spaceBetween' => 20, 'grid' => ['rows' => 1]],
            ],
          ];
        ?>
        <?php if ($processingImageCount > 0): ?>
        <div class="swiper init-swiper featured-passers-swiper">
          <script type="application/json" class="swiper-config"><?php echo json_encode($processingSwiperConfig, JSON_UNESCAPED_SLASHES); ?></script>
          <div class="swiper-wrapper">
            <?php foreach ($processingImages as $processingImage): ?>
            <div class="swiper-slide">
              <article class="featured-passer-card">
                <a href="<?php echo htmlspecialchars($processingImage['url'], ENT_QUOTES, 'UTF-8'); ?>" class="glightbox" data-gallery="processing-testimonials">
                  <img src="<?php echo htmlspecialchars($processingImage['url'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($processingImage['label'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" decoding="async">
                </a>
              </article>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
        <?php else: ?>
        <p class="text-center mb-0">No processing testimonials uploaded yet.</p>
        <?php endif; ?>
      </div>
    </section>

    

    <section id="processing-packages" class="services section processing-services">
      <div class="container section-title" data-aos="fade-up">
        <h2>What We Process For You</h2>
        <p>Comprehensive support across major nursing licensure pathways.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <div class="processing-flag" aria-label="United States">🇺🇸</div>
              <h3>NCLEX USA</h3>
              <ul class="processing-checklist">
                <li><i class="bi bi-check2-all"></i> <span>State Board Application</span></li>
				<li><i class="bi bi-check2-all"></i> <span>Exam Eligibility</span></li>
                <li><i class="bi bi-check2-all"></i> <span>Trumerit / CGFNS Guidance</span></li>
                <li><i class="bi bi-check2-all"></i> <span>NCSBN Registration</span></li>
                <li><i class="bi bi-check2-all"></i> <span>ATT Assistance</span></li>
                <li><i class="bi bi-check2-all"></i> <span>License Endorsement</span></li>
                <li><i class="bi bi-check2-all"></i> <span>License Renewal</span></li>
                <li><i class="bi bi-check2-all"></i> <span>License Reactivation</span></li>
                <li><i class="bi bi-check2-all"></i> <span>Jurisprudence Exam</span></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <div class="processing-flag" aria-label="Canada">🇨🇦</div>
              <h3>NCLEX Canada</h3>
              <ul class="processing-checklist">
                <li><i class="bi bi-check2-all"></i> <span>NNAS Guidance</span></li>
                <li><i class="bi bi-check2-all"></i> <span>WES Guidance</span></li>
                <li><i class="bi bi-check2-all"></i> <span>Exam Eligibility</span></li>
                <li><i class="bi bi-check2-all"></i> <span>Provincial Licensing Pathways</span></li>
                <li><i class="bi bi-check2-all"></i> <span>Jurisprudence Exam</span></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <div class="processing-flag" aria-label="Middle East">🇦🇪</div>
              <h3>Middle East Licensing</h3>
              <ul class="processing-checklist">
                <li><i class="bi bi-check2-all"></i> <span>by DATAFLOW GROUP</span></li>
              </ul>
			  <BR><hr>
              <p><small>Note:Our Middle East test processing is under our partner for Middle East. The Data Flow Group.</small></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="service-item position-relative">
              <div class="processing-flag" aria-label="Great Britain">🇬🇧</div>
              <h3>UK / Other Pathways</h3>
              <ul class="processing-checklist">
                <li><i class="bi bi-check2-all"></i> <span>NMC Guidance</span></li>
                <li><i class="bi bi-check2-all"></i> <span>CBT / OSCE pathway support</span></li>
              </ul>
			  <br>
			   <div class="processing-flag" aria-label="Philippines">🇵🇭</div>
              <h3>Philippines</h3>
			   <ul class="processing-checklist">
                <li><i class="bi bi-check2-all"></i> <span>PHRN renewal assistance</span></li>
                <li><i class="bi bi-check2-all"></i> <span>School Documents Processing Assistance</span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="features section light-background processing-steps">
      <div class="container section-title" data-aos="fade-up">
        <span class="eyebrow">Processing Journey / Step-by-Step Timeline</span>
        <h2>Your Journey to Exam Eligibility</h2>
        <p>A guided step-by-step path from application to exam readiness.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 mb-4 journey-grid">
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-calendar-check"></i></div>
              <div><div class="step-head"><span class="step-no">1</span><h4>Book Consultation</h4></div><p>Start with a focused consultation to map your best licensure route.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-clipboard2-check"></i></div>
              <div><div class="step-head"><span class="step-no">2</span><h4>Eligibility Assessment</h4></div><p>We review your profile and documents against pathway requirements.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-signpost-split"></i></div>
              <div><div class="step-head"><span class="step-no">3</span><h4>Choose State / Pathway</h4></div><p>Select the state board or licensing track that fits your goals.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-folder2-open"></i></div>
              <div><div class="step-head"><span class="step-no">4</span><h4>Prepare Your Documents</h4></div><p>Complete your requirements using a clear checklist and file guidance.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-send-check"></i></div>
              <div><div class="step-head"><span class="step-no">5</span><h4>Application Submission</h4></div><p>Submit your application accurately with support at every step.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-patch-check"></i></div>
              <div><div class="step-head"><span class="step-no">6</span><h4>Verification and Evaluation</h4></div><p>Track verification and credential evaluation progress with timely updates.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-journal-check"></i></div>
              <div><div class="step-head"><span class="step-no">7</span><h4>Exam Registration</h4></div><p>Register for your exam with proper timing and complete details.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-envelope-check"></i></div>
              <div><div class="step-head"><span class="step-no">8</span><h4>ATT and Exam Booking</h4></div><p>Receive your ATT and book your exam with confidence.</p></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 col-sm-12 step-nine-col">
            <div class="icon-box d-flex position-relative h-100">
              <div class="step-icon"><i class="bi bi-mortarboard"></i></div>
              <div><div class="step-head"><span class="step-no">9</span><h4>Sit for the NCLEX</h4></div><p>The final step. Show your readiness and go for succes!.</p></div>
            </div>
          </div>
       </div>
		<div class="row gy-4 mb-4 processing-summary-row align-items-stretch">
		 <div class="col-12 col-lg-7">
            <div class="icon-box d-flex position-relative h-100 summary-with-icon summary-primary">
               
			    <div class="step-icon"><i class="bi bi-book"></i></div>
				<div><div class="step-head">
                <h4>You can start your review anytime</h4></div>
                <p>You don't have to wait for any step to be completed. Start your GRA review anytime and
				gain the edge you need while we take care of your processing.</p></div>
              
            </div>
          </div>
		   <div class="col-12 col-lg-5">
            <div class="icon-box d-flex position-relative h-100 summary-secondary">
               
			    <div class="summary-logo"><img src="assets/img/gra/gra_test_processing logo.jpg" alt="GRA Test Processing logo" loading="lazy"></div>
					<div><div class="step-head">
                <h4>Processing with Confidence.</h4></div>
                <p>Review with purpose.</p></div>
              
            </div>
          </div>
		</div>
      </div>
    </section>
	
	<section class="about section light-background">
      <div class="container section-title" data-aos="fade-up">
        <span class="eyebrow">GRA Test Processing</span>
        <h2>Why Choose GRA Test Processing</h2>
		<p><b>Why Nurses Trust GRA Test Processing?</b></p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <!--
		<div class="row gy-4">
          <div class="col-12 mb-4">
            <ul class="processing-checklist processing-checklist-grid">
              <li><i class="bi bi-check2-all"></i> <span>End-to-end application assistance</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Fast document checklist and verification guidance</span></li>
              <li><i class="bi bi-check2-all"></i> <span>State-specific expert processing support</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Personalized case handling</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Transparent step-by-step updates</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Combined review + processing advantage</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Trusted digital support team</span></li>
            </ul>
          </div>
		  </div>
		  -->
		  <div class="row g-2 trust-stack">
          <div class="col-6 col-md-4 col-lg-2">
            <div class="learning-mode-card">
              <div>
                <h6>Expert Guidance</h6>
                <p><small>Every step backed by expeerience.</small></p>
              </div>
            </div>
          </div>
		   <div class="col-6 col-md-4 col-lg-2">
            <div class="learning-mode-card">
              <div>
                <h6>Fast and Reliable</h6>
                <p><small>Consistent handling with clear and timely coordination.</small></p>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <div class="learning-mode-card">
              <div>
                <h6>End-to-End Support</h6>
                <p><small>From application to exam readiness.</small></p>
              </div>
            </div>
          </div>
		  
		  <div class="col-6 col-md-4 col-lg-2">
            <div class="learning-mode-card">
              <div>
                <h6>Timely Updates</h6>
                <p><small>Stay informed at every stage of the process.</small></p>
              </div>
            </div>
          </div>
		  
          <div class="col-6 col-md-4 col-lg-2">
            <div class="learning-mode-card">
              <div>
                <h6>One stop shop</h6>
                <p><small>Review + Processing in One Place.</small></p>
              </div>
            </div>
          </div>
		  
		   <div class="col-6 col-md-4 col-lg-2">
            <div class="learning-mode-card">
              <div>
                <h6>Ready to Begin your Journey</h6>
				<p><small>Let's take the first step together.</small></p>
              </div>
            </div>
          </div>
		  
		  
        </div>
      </div>
    </section>

    <section id="processing-consultation" class="appointment section">
      <div class="container section-title" data-aos="fade-up">
        <span class="eyebrow">Book a Consultation</span>
        <h2>Not Sure Which Pathway Is Best?</h2>
        <p>Speak with a GRA processing specialist for personalized guidance based on your country, credentials, and goals.</p>
      </div>
      <div class="container processing-consultation-wrap" data-aos="fade-up" data-aos-delay="100">
        <form action="submit-processing.php" method="post" role="form" class="site-form gra-medicio-form processing-consultation-form">
          <input type="hidden" name="form_type" value="processing_consultation">
          <div class="row">
            <div class="col-md-6 form-group">
              <select name="inquiry_type" class="form-control" required>
                <option value="Consultation" selected>Inquiry Type: Consultation</option>
                <option value="Application">Inquiry Type: Application</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group mt-3">
              <input type="text" name="phone" class="form-control" placeholder="Mobile / WhatsApp" required>
            </div>
            <div class="col-md-6 form-group mt-3">
              <input type="text" name="country" class="form-control" placeholder="Country">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group mt-3">
              <input type="text" name="license_country" class="form-control" placeholder="License Country">
            </div>
            <div class="col-md-6 form-group mt-3">
              <input type="text" name="target_country" class="form-control" placeholder="Target Country">
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" name="preferred_state_region" class="form-control" placeholder="Preferred State / Region">
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Questions"></textarea>
          </div>
          <div class="mt-3 text-center">
            <button type="submit" class="btn btn-primary">Book Consultation</button>
          </div>
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
    <div class="container copyright text-center mt-4">
      <p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p>
    </div>
  </footer>

  <div class="floating-contact-stack" id="floating-contact-stack" aria-label="Floating contact actions">
    <div class="floating-contact-actions" id="floating-contact-actions">
      <a href="tel:0285599060" aria-label="Call GRA"><i class="bi bi-telephone"></i></a>
      <a href="https://wa.me/639285599060" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><i class="bi bi-whatsapp"></i></a>
      <a href="https://m.me/gapuzreviewacademyofficial" target="_blank" rel="noopener" aria-label="Open Messenger"><i class="bi bi-messenger"></i></a>
      <a href="#processing-consultation" aria-label="Book consultation"><i class="bi bi-calendar-check"></i></a>
    </div>
    <button type="button" class="floating-contact-toggle" id="floating-contact-toggle" aria-label="Open contact actions" aria-expanded="false">
      <i class="bi bi-three-dots-vertical"></i>
    </button>
  </div>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Scroll to top"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?php echo versioned_asset('assets/js/main.js'); ?>"></script>
  <script src="<?php echo versioned_asset('assets/js/gra-content.js'); ?>"></script>
  <script>
    (function () {
      function initProcessingLightbox() {
        if (typeof GLightbox === 'undefined') return;
        if (window.__processingLightbox) return;
        window.__processingLightbox = GLightbox({
          selector: '#processing-testimonials .glightbox'
        });
      }

      function initProcessingTestimonials() {
        if (typeof Swiper === 'undefined') return;
        var carousel = document.querySelector('#processing-testimonials .init-swiper');
        if (!carousel || carousel.classList.contains('is-swiper-ready')) return;
        var configNode = carousel.querySelector('.swiper-config');
        if (!configNode) return;
        try {
          var config = JSON.parse(configNode.textContent.trim());
          new Swiper(carousel, config);
          carousel.classList.add('is-swiper-ready');
        } catch (e) {
          console.error('Processing testimonials swiper config error', e);
        }
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
          initProcessingTestimonials();
          initProcessingLightbox();
        });
      } else {
        initProcessingTestimonials();
        initProcessingLightbox();
      }
      window.addEventListener('load', function () {
        initProcessingTestimonials();
        initProcessingLightbox();
      });

    })();
  </script>
</body>
</html>
