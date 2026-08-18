<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Orientation Webinar | Gapuz Review Academy</title>
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
</head>
<body class="index-page gra-page footer-stick-page">
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
  <main class="container py-5">
      <h2>Orientation Webinar</h2>
      <p>Watch the orientation session to understand the full learning flow.</p>
      <div class="ratio ratio-16x9 mb-3">
        <iframe src="https://www.youtube.com/embed/sYEitZ01THI" title="Orientation Webinar" allowfullscreen></iframe>
      </div>
      <a class="btn btn-outline-primary" href="online-campus.php">Back to Online Campus</a>
  </main>
  <footer id="footer" class="footer dark-background">
    <div class="container copyright text-center mt-4"><p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p></div>
  </footer>
</body>
</html>



