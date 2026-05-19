<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/asset-version.php'; ?>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Online Campus | Gapuz Review Academy</title>
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
</head>

<body class="index-page gra-page">
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
            <li><a href="index.php#hero" class="active">Home</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#courses">Courses</a></li>
            <li><a href="index.php#free-courses">Free Courses</a></li>
            <li><a href="https://artemis360.gapuzreview.com">Artemis360</a></li>
            <li><a href="index.php#testimonials">Passers</a></li>
            <li><a href="index.php#enroll">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="cta-btn" href="index.php#enroll">Enroll Now</a>
      </div>
    </div>
  </header>

  <main class="main">

    <section id="online-campus" class="about section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Online Campus</h2>
        <p>Experience the GRA difference with free learning resources and digital review access.</p>
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100"><img src="assets/img/gra/artemis-platform.jpg" class="img-fluid" alt="GRA Online Campus"></div>
          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <h3>Start learning for free.</h3>
            <p class="fst-italic">Use GRA's online campus to explore mini lessons, practice quizzes, downloadable notes, and orientation resources before choosing a full review program.</p>
            <ul><li><i class="bi bi-check2-all"></i> <span>Free mini lessons and practice quizzes.</span></li><li><i class="bi bi-check2-all"></i> <span>Downloadable notes and online orientation support.</span></li><li><i class="bi bi-check2-all"></i> <span>Pathway into Artemis360 and PassEasy review courses.</span></li></ul>
          </div>
        </div>
      </div>
    </section>

    <section id="campus-access" class="appointment section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Unlock Free Resources</h2>
        <p>Enter the same email you used when you registered your Online Campus interest.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <form id="campus-access-form" class="gra-medicio-form" action="check-booking-access.php" method="post" novalidate>
          <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8 form-group">
              <input id="campus-access-email" type="email" name="email" class="form-control" placeholder="Registered email address" required>
            </div>
            <div class="col-lg-3 col-md-4 form-group mt-3 mt-md-0 text-center text-md-start">
              <button id="campus-access-submit" type="submit">Verify Email</button>
            </div>
          </div>
          <p id="campus-access-status" class="campus-access-status" role="status" aria-live="polite"></p>
        </form>
      </div>
    </section>

    <section id="free-resources" class="featured-services section">
      <div class="container"><div class="row gy-4">
        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-book-open icon"></i></div><h4>Free Mini Lessons</h4><p>Preview GRA's learning style with focused introductory lessons.</p><a class="campus-resource-link" data-campus-resource data-resource-href="mini-lessons.php" href="mini-lessons.php" aria-disabled="true">Open Mini Lessons</a></div></div>
        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-clipboard-question icon"></i></div><h4>Practice Quizzes</h4><p>Check readiness and reinforce review topics through quick quizzes.</p><a class="campus-resource-link" data-campus-resource data-resource-href="practice-quizzes.php" href="practice-quizzes.php" aria-disabled="true">Open Practice Quizzes</a></div></div>
        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-file-arrow-down icon"></i></div><h4>Downloadable Notes</h4><p>Keep review reminders and topic summaries within reach.</p><a class="campus-resource-link" data-campus-resource data-resource-href="downloadable-notes.php" href="downloadable-notes.php" aria-disabled="true">Open Downloadable Notes</a></div></div>
        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400"><div class="service-item position-relative campus-resource-card is-locked"><div class="icon"><i class="fas fa-display icon"></i></div><h4>Orientation Webinar</h4><p>Learn how to choose the right review program and setup.</p><a class="campus-resource-link" data-campus-resource data-resource-href="orientation-webinar.php" href="orientation-webinar.php" aria-disabled="true">Open Orientation Webinar</a></div></div>
      </div></div>
    </section>

    <section id="course-enroll" class="appointment section light-background">
      <div class="container section-title" data-aos="fade-up"><h2>Register for Free Course Access</h2><p>A GRA adviser can follow up with free course and enrollment details.</p></div>
      <div class="container" data-aos="fade-up" data-aos-delay="100"><form action="submit.php" method="post" role="form" class="site-form gra-medicio-form"><input type="hidden" name="form_type" value="booking"><div class="row"><div class="col-md-4 form-group"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div><div class="col-md-4 form-group mt-3 mt-md-0"><input type="email" class="form-control" name="email" placeholder="Email" required></div><div class="col-md-4 form-group mt-3 mt-md-0"><input type="tel" class="form-control" name="phone" placeholder="Mobile / Messaging App" required></div></div><div class="form-group mt-3"><textarea class="form-control" name="message" rows="5" placeholder="Questions or notes"></textarea></div><div class="mt-3 text-center"><button type="submit">Submit Registration Interest</button></div></form></div>
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

