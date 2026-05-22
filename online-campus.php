<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once __DIR__ . '/asset-version.php'; ?>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Online Campus | Gapuz Review Academy</title>
  <meta name="description" content="Gapuz Review Academy online campus access, support, and free resources.">
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    .campus-page { background: #eef2f7; }
    .campus-wrap { max-width: 1240px; margin: 0 auto; padding: 16px 0 30px; }
    .campus-card { background: #fff; border: 1px solid #e1e7f0; border-radius: 14px; padding: 16px; margin-bottom: 14px; }
    .campus-cover-hero { margin-bottom: 16px; }
    .campus-hero-actions { position: relative; z-index: 3; pointer-events: auto; }
    .campus-hero-actions a { pointer-events: auto; }
    .campus-page #online-campus-hero .passeasy-hero-container {
      background: transparent !important;
      box-shadow: none !important;
      border: 0 !important;
      padding: 0 !important;
      margin-top: 0 !important;
    }
    .campus-page #online-campus-hero .container {
      background: transparent !important;
      border-top: 0 !important;
      margin-bottom: 0 !important;
      box-shadow: none !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }
    .campus-page #online-campus-hero .hero-copy {
      text-align: left !important;
      padding-top: 34px;
    }
    .campus-page #online-campus-hero .campus-hero-actions {
      align-items: flex-start !important;
    }
    .campus-page #online-campus-hero .campus-btn {
      width: 320px;
      max-width: 100%;
      justify-content: center;
    }
    .campus-page #online-campus-hero.section {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }
    .campus-page #online-campus-hero .carousel {
      min-height: 620px;
    }
    .campus-page #online-campus-hero .carousel-item {
      min-height: 620px;
      align-items: flex-start !important;
      padding-top: 0 !important;
    }
    .campus-page #online-campus-hero .carousel-item > img {
      min-height: 620px;
      object-fit: cover;
      object-position: center center;
    }
    .campus-page #online-campus-hero .carousel-item::before {
      content: none !important;
      display: none !important;
    }
    .campus-title { font-size: clamp(2rem, 2.7vw, 3.6rem); line-height: 1.1; color: #003057; font-weight: 800; margin: 10px 0 14px; }
    .campus-title .accent { color: #ff6e11; }
    .campus-sub { font-size: clamp(1rem, 1.05vw, 1.35rem); line-height: 1.45; color: #1f2d3d; margin-bottom: 16px; max-width: 520px; }
    .campus-btn { border-radius: 10px; font-weight: 700; font-size: 1rem; padding: 8px 12px; display: flex; align-items: center; gap: 8px; text-decoration: none; margin-bottom: 8px; justify-content: center; white-space: nowrap; }
    .campus-btn.b1 { background: #ff7a12; color: #fff; }
    .campus-btn.b2 { background: #1d5ed9; color: #fff; }
    .campus-btn.b3 { background: #fff; color: #1d5ed9; border: 1px solid #1d5ed9; }
    .campus-media { min-height: 360px; height: 100%; border-radius: 14px; overflow: hidden; position: relative; }
    .campus-media img { width: 100%; height: 100%; object-fit: cover; }
    .campus-media-tag { position: absolute; right: 14px; bottom: 14px; background: #fff; color: #003057; border-radius: 10px; border: 1px solid #d9e3ef; padding: 8px 12px; font-weight: 700; font-size: 1.35rem; }
    .oc-title { text-align: center; color: #0b1e4b; font-size: 1.55rem; font-weight: 700; margin-bottom: 4px; letter-spacing: 0; text-transform: none; }
    .oc-sub { text-align: center; color: #475569; font-size: 1rem; margin-bottom: 16px; }
    .social-box, .chat-box { border: 1px solid #e1e7f0; border-radius: 12px; background: #fff; text-align: center; padding: 12px 8px; height: 100%; text-decoration: none !important; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .social-box:hover { transform: translateY(-2px); border-color: #cdd9e8; box-shadow: 0 8px 18px rgba(15, 23, 42, .08); }
    .social-icon { width: 46px; height: 46px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 1.9rem; margin-bottom: 6px; }
    .s1{background:#1877f2}.s2{background:#ff0000}.s3{background:#e1306c}.s4{background:#111827}.s5{background:#0a7cff}.s6{background:#1e40af}
    .social-name { display:block; margin-top: 2px; color:#0b1e4b; font-size: .92rem; font-weight: 600; line-height: 1.25; }
    .chat-link { border-radius: 12px; color: #fff; text-decoration: none; padding: 12px; display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 1.05rem; font-weight: 700; }
    .cwa{background:linear-gradient(135deg,#0cae5d,#25d366)} .ctg{background:linear-gradient(135deg,#188bdc,#40a9ff)} .cvb{background:linear-gradient(135deg,#6b3ec9,#8a63e6)}
    .support-left { border: 1px solid #e1e7f0; border-radius: 12px; padding: 16px; height: 100%; }
    .support-icon { width: 70px; height: 70px; border-radius: 50%; background: #eaf1ff; color: #1d4ed8; display: inline-flex; align-items: center; justify-content: center; font-size: 2.6rem; margin-bottom: 8px; }
    .support-left h3 { font-size: 1.45rem; color: #0b1e4b; font-weight: 700; margin-bottom: 8px; }
    .support-left p { font-size: .98rem; color: #334155; }
    .support-hours { margin-top: 10px; border: 1px solid #e1e7f0; border-radius: 10px; padding: 10px 12px; color: #334155; font-size: .9rem; background: #f8fafc; }
    .support-form { border: 1px solid #e1e7f0; border-radius: 12px; padding: 14px; }
    .support-form label { font-size: .9rem; font-weight: 600; color: #0b1e4b; margin-bottom: 4px; line-height: 1.2; }
    .support-form .form-control,
    .support-form .form-select {
      height: auto;
      min-height: 42px;
      font-size: .92rem;
      line-height: 1.35;
      padding: 9px 12px;
      border-color: #d8e1ec;
    }
    .support-form .form-select {
      padding-right: 34px;
      background-position: right 10px center;
    }
    .support-form textarea.form-control {
      height: 96px;
      font-size: .92rem;
      line-height: 1.35;
      padding-top: 10px;
    }
    .support-form button[type=submit] { width: 100%; border: 0; border-radius: 10px; background: #1d5ed9; color: #fff; font-size: .98rem; font-weight: 700; padding: 9px; }
    .oc-note { text-align: center; color: #64748b; font-size: .88rem; margin-top: 10px; }
    .oc-end { border: 1px solid #dfe7f1; background: #f2f6fc; border-radius: 14px; padding: 14px; text-align: center; color: #0b1e4b; font-size: 1.3rem; font-weight: 700; }
    .oc-end small { display: block; margin-top: 4px; font-weight: 500; color: #334155; font-size: .9rem; }
    #free-resources .service-item {
      border: 1px solid #003057 !important;
      box-shadow: none !important;
      transition: none !important;
    }
    #free-resources .campus-resource-card.is-locked {
      opacity: 1 !important;
    }
    #free-resources .service-item:before,
    #free-resources .service-item:after,
    #free-resources .service-item .icon:before,
    #free-resources .service-item .icon:after {
      display: none !important;
      content: none !important;
      background: transparent !important;
      opacity: 0 !important;
    }
    #free-resources .service-item:hover {
      background: #003057 !important;
      border-color: #003057 !important;
      box-shadow: none !important;
      transform: none !important;
    }
    #free-resources .service-item:hover h4,
    #free-resources .service-item:hover h4 a,
    #free-resources .service-item:hover p,
    #free-resources .service-item:hover .icon i {
      color: #ffffff !important;
    }
    #free-resources .campus-resource-link {
      background: #ff6e11 !important;
      border: 1px solid #ff6e11 !important;
      color: #ffffff !important;
      box-shadow: none !important;
      transition: none !important;
    }
    #free-resources .campus-resource-card.is-locked .campus-resource-link {
      background: #9daab6 !important;
      border-color: #9daab6 !important;
      color: #ffffff !important;
      pointer-events: none !important;
      cursor: not-allowed;
    }
    #free-resources .campus-resource-card:not(.is-locked) .campus-resource-link {
      background: #ff6e11 !important;
      border-color: #ff6e11 !important;
      color: #ffffff !important;
      pointer-events: auto !important;
      cursor: pointer;
    }
    @media (max-width: 767px) {
      .campus-wrap { padding: 12px 0 24px; }
      .campus-card { padding: 14px; }
      .campus-title { font-size: 2rem; line-height: 1.15; }
      .campus-sub { font-size: 1.15rem; line-height: 1.4; }
      .campus-btn { font-size: 1.15rem; padding: 8px 12px; }
      .oc-title { font-size: 1.75rem; }
      .oc-sub { font-size: 1.18rem; margin-bottom: 12px; }
      .social-name { font-size: 1.08rem; }
      .social-icon { width: 44px; height: 44px; font-size: 1.9rem; margin-bottom: 6px; }
      .chat-link {
        padding: 12px 8px;
        font-size: 0;
        gap: 0;
      }
      .chat-link i {
        font-size: 2rem;
      }
      .chat-link::after {
        content: "";
      }
      .support-left h3 { font-size: 1.75rem; }
      .support-left p,
      .support-hours,
      .support-form label,
      .support-form .form-control,
      .support-form .form-select,
      .support-form textarea.form-control,
      .oc-note,
      .campus-resource-card p {
        font-size: 1.08rem !important;
        line-height: 1.35;
      }
      .campus-resource-card h4 { font-size: 1.2rem; }
      .campus-resource-link { font-size: 1.05rem; }
      .support-form button[type=submit],
      #campus-access-submit {
        font-size: 1.1rem !important;
        padding-top: 8px !important;
        padding-bottom: 8px !important;
      }
      .campus-page #online-campus-hero .hero-copy { padding-top: 0 !important; }
      .campus-page #online-campus-hero.section {
        padding: 0 !important;
      }
      .campus-page #online-campus-hero .carousel {
        min-height: 520px !important;
      }
      .campus-page #online-campus-hero .carousel-item {
        padding-top: 30px;
        min-height: 520px !important;
        align-items: flex-start !important;
      }
      .campus-page #online-campus-hero .carousel-item > img {
        height: 520px !important;
        object-fit: cover;
        object-position: center top;
      }
      .campus-page #online-campus-hero .container {
        margin-top: 20px !important;
        margin-bottom: 0 !important;
        padding-top: 20px !important;
        padding-bottom: 25px !important;
      }
      .campus-page #online-campus-hero .campus-hero-actions {
        margin-top: 14px !important;
      }
      .campus-card .row.row-cols-1.row-cols-md-3 {
        --bs-columns: 3;
      }
      .campus-card .row.row-cols-1.row-cols-md-3 > .col {
        width: 33.333333%;
        flex: 0 0 auto;
      }
      .campus-media { min-height: 230px; }
    }
  </style>
</head>
<body class="index-page gra-page footer-stick-page campus-page">
  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-between">
        <div class="d-flex align-items-center gap-2"><span class="d-none d-md-inline">Learn With Confidence.</span><a class="online-campus-link" href="online-campus.php">ONLINE CAMPUS</a></div>
        <div class="d-flex align-items-center gap-3"><span><i class="bi bi-telephone me-1"></i> 0285599060 / 85599062</span><span class="d-none d-lg-inline"><i class="bi bi-envelope me-1"></i> Inquire@gratestprepworldwide.com</span></div>
      </div>
    </div>
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="index.php" class="logo d-flex align-items-center me-auto"><img src="assets/img/gra/gra-logo.png" alt="Gapuz Review Academy logo"></a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.php#hero" class="active">Home</a></li>
            <li><a href="index.php#about">About</a></li>
            <li class="dropdown"><a href="index.php#courses"><span>Courses</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="nclex-rn-courses.php">NCLEX-RN</a></li><li><a href="dha-rn-courses.php">DHA-RN</a></li><li><a href="doh-haad-rn-courses.php">DOH / HAAD-RN</a></li><li><a href="prometric-rn-courses.php">Prometric-RN</a></li><li><a href="pnle-courses.php">PNLE</a></li><li><a href="sple-courses.php">SPLE</a></li><li><a href="civil-service-courses.php">Civil Service</a></li><li><a href="lept-courses.php">LEPT</a></li>
              </ul>
            </li>
            <li><a href="index.php#free-courses">Free Courses</a></li><li><a href="https://artemis360.gapuzreview.com">Artemis360</a></li><li><a href="index.php#testimonials">Passers</a></li><li><a href="index.php#enroll">Contact</a></li><li><a href="test-processing.php">Test Processing</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="cta-btn" href="index.php#enroll">Enroll Now</a>
      </div>
    </div>
  </header>

  <main class="main">
    <section id="online-campus-hero" class="hero section" data-aos="fade-up">
      <div id="online-campus-hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-item active">
          <img src="assets/img/gra/ARTEMIS_COVER.png" alt="Online campus hero cover" fetchpriority="high">
          <div class="container col-lg-10">
              <div class="row align-items-center gy-3">
              <div class="hero-copy">
                <span class="eyebrow">ONLINE CAMPUS</span>
                <h2 class="campus-title">Welcome Back,<br><span class="accent">Future Passer!</span></h2>
                <p class="campus-sub">Access your learning tools, live classes, study materials, and stay connected with Gapuz Review Academy.</p>
                <div class="d-flex flex-column gap-2 mt-3 campus-hero-actions">
                  <a class="campus-btn b1 mb-0" href="https://artemis360.gapuzreview.com" target="_blank" rel="noopener"><i class="bi bi-rocket-takeoff-fill"></i>Launch Artemis360</a>
                  <a class="campus-btn b2 mb-0" href="https://zoom.us/" target="_blank" rel="noopener"><i class="bi bi-camera-video-fill"></i>Join Live Zoom Class</a>
                  <a class="campus-btn b3 mb-0" href="#support-form" target="_blank" rel="noopener"><i class="bi bi-headset"></i>Book Student Support</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="container campus-wrap">

      <section class="campus-card" data-aos="fade-up" data-aos-delay="80">
        <h2 class="oc-title">Stay Connected - Follow GRA</h2>
        <p class="oc-sub">Get updates, announcements, tips, and inspiration.</p>
        <div class="row g-3 row-cols-3 row-cols-md-3 row-cols-xl-6">
          <div class="col"><a class="social-box d-block" href="https://www.facebook.com/gapuzreviewacademyofficial"><span class="social-icon s1"><i class="bi bi-facebook"></i></span><span class="social-name">Facebook</span></a></div>
          <div class="col"><a class="social-box d-block" href="https://www.youtube.com/"><span class="social-icon s2"><i class="bi bi-youtube"></i></span><span class="social-name">YouTube</span></a></div>
          <div class="col"><a class="social-box d-block" href="https://www.instagram.com/"><span class="social-icon s3"><i class="bi bi-instagram"></i></span><span class="social-name">Instagram</span></a></div>
          <div class="col"><a class="social-box d-block" href="https://www.tiktok.com/"><span class="social-icon s4"><i class="bi bi-tiktok"></i></span><span class="social-name">TikTok</span></a></div>
          <div class="col"><a class="social-box d-block" href="https://m.me/gapuzreviewacademyofficial"><span class="social-icon s5"><i class="bi bi-messenger"></i></span><span class="social-name">Messenger</span></a></div>
          <div class="col"><a class="social-box d-block" href="https://gratestprepworldwide.com/"><span class="social-icon s6"><i class="bi bi-globe2"></i></span><span class="social-name">Website</span></a></div>
        </div>
      </section>

      <section class="campus-card" data-aos="fade-up" data-aos-delay="120">
        <h2 class="oc-title">MESSAGE US - WE'RE HERE TO HELP!</h2>
        <p class="oc-sub">Chat with us anytime through your preferred app.</p>
        <div class="row g-3 row-cols-1 row-cols-md-3">
          <div class="col"><a class="chat-link cwa" href="https://wa.me/639285599060"><i class="bi bi-whatsapp"></i>WhatsApp</a></div>
          <div class="col"><a class="chat-link ctg" href="https://t.me/"> <i class="bi bi-telegram"></i>Telegram</a></div>
          <div class="col"><a class="chat-link cvb" href="viber://chat?number=%2B639285599060"><i class="bi bi-telephone-inbound"></i>Viber</a></div>
        </div>
      </section>

      <section id="support-form" class="campus-card" data-aos="fade-up" data-aos-delay="160">
        <div class="row g-3">
          <div class="col-xl-4">
            <div class="support-left">
              <div class="support-icon"><i class="bi bi-headset"></i></div>
              <h3>Book Student Support</h3>
              <p>We're here to help you! Fill out the form and our support team will get back to you as soon as possible.</p>
              <div class="support-hours"><i class="bi bi-clock me-2"></i>Support is available<br>Monday - Sunday | 8:00 AM - 8:00 PM</div>
            </div>
          </div>
          <div class="col-xl-8">
            <div class="support-form">
              <form action="submit.php" method="post" class="gra-medicio-form site-form">
                <input type="hidden" name="form_type" value="booking">
                <div class="row g-3">
                  <div class="col-md-6"><label>Full Name *</label><input type="text" class="form-control" name="name" required></div>
                  <div class="col-md-6"><label>Email Address *</label><input type="email" class="form-control" name="email" required></div>
                  <div class="col-md-6"><label>Course / Program *</label><select class="form-select" name="course" required><option value="">Select your course</option><option>NCLEX</option><option>DHA</option><option>HAAD (DOH)</option><option>Prometric</option><option>PNLE</option><option>SPLE</option><option>Civil Service</option><option>LEPT</option></select></div>
                  <div class="col-md-6"><label>Student ID / Registration No. *</label><input type="text" class="form-control" name="student_id" required></div>
                  <div class="col-md-6"><label>Concern / Category *</label><select class="form-select" name="concern" required><option value="">Select concern</option><option>Account Access</option><option>Schedule</option><option>Billing</option><option>Technical Support</option><option>Course Inquiry</option></select></div>
                  <div class="col-md-6"><label>Preferred Contact Method *</label><select class="form-select" name="preferred_contact" required><option value="">Select preferred method</option><option>Email</option><option>Phone</option><option>Messenger</option><option>WhatsApp</option></select></div>
                  <div class="col-12"><label>Message / Details *</label><textarea class="form-control" name="message" required></textarea></div>
                  <div class="col-12"><button type="submit"><i class="bi bi-envelope-check me-2"></i>Submit Request</button></div>
                </div>
              </form>
              <div class="oc-note"><i class="bi bi-shield-lock me-1"></i>Your information is safe with us and will only be used to assist you.</div>
            </div>
          </div>
        </div>
      </section>

      <section id="campus-access" class="campus-card" data-aos="fade-up" data-aos-delay="180">
        <h2 class="oc-title">Unlock Free Resources</h2>
        <p class="oc-sub">Enter the same email you used when you registered your Online Campus interest.</p>
        <form id="campus-access-form" class="gra-medicio-form" action="check-booking-access.php" method="post" novalidate>
          <div class="row justify-content-center g-3">
            <div class="col-lg-7 col-md-8"><input id="campus-access-email" type="email" name="email" class="form-control" placeholder="Registered email address" required></div>
            <div class="col-lg-3 col-md-4"><button id="campus-access-submit" type="submit" class="btn btn-primary w-100">Verify Email</button></div>
          </div>
          <p id="campus-access-status" class="campus-access-status text-center mt-3" role="status" aria-live="polite"></p>
        </form>
        <section id="free-resources" class="featured-services section pt-3 pb-0">
          <div class="container px-0">
            <div class="row gy-4">
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-book-open icon"></i></div><h4>Free Mini Lessons</h4><p>Preview GRA's learning style with focused introductory lessons.</p><a class="campus-resource-link" data-campus-resource data-resource-href="mini-lessons.php" href="mini-lessons.php" aria-disabled="true">Open Mini Lessons</a></div></div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-clipboard-question icon"></i></div><h4>Practice Quizzes</h4><p>Check readiness and reinforce review topics through quick quizzes.</p><a class="campus-resource-link" data-campus-resource data-resource-href="practice-quizzes.php" href="practice-quizzes.php" aria-disabled="true">Open Practice Quizzes</a></div></div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-file-arrow-down icon"></i></div><h4>Download Notes</h4><p>Keep review reminders and topic summaries within reach.</p><a class="campus-resource-link" data-campus-resource data-resource-href="downloadable-notes.php" href="downloadable-notes.php" aria-disabled="true">Open Downloadable Notes</a></div></div>
              <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-display icon"></i></div><h4>Orientation Webinar</h4><p>Learn how to choose the right review program and setup.</p><a class="campus-resource-link" data-campus-resource data-resource-href="orientation-webinar.php" href="orientation-webinar.php" aria-disabled="true">Open Orientation Webinar</a></div></div>
            </div>
          </div>
        </section>
      </section>

      <div class="oc-end"><i class="bi bi-heart-fill me-2" style="color:#1d4ed8;"></i>We're with you every step of the way!<small>Keep going, stay focused, and trust the process. You've got this!</small></div>
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
            <p class="mt-3"><strong>Phone:</strong> <span>0285599060 / 85599062</span></p><p><strong>Email:</strong> <span>Inquire@gratestprepworldwide.com</span></p>
          </div>
          <div class="social-links d-flex mt-4"><a href="https://www.facebook.com/gapuzreviewacademyofficial"><i class="bi bi-facebook"></i></a></div>
        </div>
        <div class="col-lg-2 col-md-3 footer-links"><h4>Courses</h4><ul><li><a href="nclex-rn-courses.php">NCLEX</a></li><li><a href="dha-rn-courses.php">DHA</a></li><li><a href="doh-haad-rn-courses.php">HAAD / DOH</a></li><li><a href="prometric-rn-courses.php">Prometric</a></li></ul></div>
        <div class="col-lg-2 col-md-3 footer-links"><h4>More Programs</h4><ul><li><a href="pnle-courses.php">PNLE</a></li><li><a href="sple-courses.php">SPLE</a></li><li><a href="civil-service-courses.php">Civil Service</a></li><li><a href="free-course.php">Online Campus</a></li></ul></div>
        <div class="col-lg-3 col-md-3 footer-links"><h4>Quick Links</h4><ul><li><a href="index.php#about">About GRA</a></li><li><a href="index.php#free-courses">Free Courses</a></li><li><a href="https://artemis360.gapuzreview.com">Artemis360</a></li><li><a href="index.php#enroll">Enroll</a></li></ul></div>
      </div>
    </div>
    <div class="container copyright text-center mt-4"><p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p></div>
  </footer>

  <div class="floating-contact-stack" id="floating-contact-stack" aria-label="Floating contact actions">
    <div class="floating-contact-actions" id="floating-contact-actions">
      <a href="tel:0285599060" aria-label="Call GRA"><i class="bi bi-telephone"></i></a>
      <a href="https://wa.me/639285599060" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><i class="bi bi-whatsapp"></i></a>
      <a href="https://m.me/gapuzreviewacademyofficial" target="_blank" rel="noopener" aria-label="Open Messenger"><i class="bi bi-messenger"></i></a>
      <a href="#support-form" aria-label="Book consultation"><i class="bi bi-calendar-check"></i></a>
    </div>
    <button type="button" class="floating-contact-toggle" id="floating-contact-toggle" aria-label="Open contact actions" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
  </div>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="<?php echo versioned_asset('assets/js/main.js'); ?>"></script>
  <script src="<?php echo versioned_asset('assets/js/gra-content.js'); ?>"></script>
  <script>
    (function () {
      if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
      }
      function resetTop() {
        if (!window.location.hash) {
          window.scrollTo(0, 0);
        }
      }
      window.addEventListener('DOMContentLoaded', resetTop);
      window.addEventListener('load', resetTop);
      window.addEventListener('pageshow', resetTop);
    })();
  </script>
</body>
</html>
