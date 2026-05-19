<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
require_once __DIR__ . '/campus-access.php';

$email = trim((string) ($_GET['email'] ?? ''));
$accessGranted = is_booking_email_registered($email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Downloadable Notes | Gapuz Review Academy</title>
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
    <?php if (!$accessGranted): ?>
      <h2>Email Verification Needed</h2>
      <p>Please unlock resources from Online Campus first.</p>
      <a class="btn btn-primary" href="online-campus.php#campus-access">Go to Online Campus</a>
    <?php else: ?>
      <h2>Downloadable Notes</h2>
      <p>Access your quick-reference notes below.</p>
      <ul>
        <li><a href="assets/img/gra/passeasy-poster.jpg" target="_blank" rel="noopener">Exam Strategy Quick Notes</a></li>
        <li><a href="assets/img/gra/artemis-platform.jpg" target="_blank" rel="noopener">Online Campus Guide</a></li>
        <li><a href="assets/img/gra/nclex-course.jpg" target="_blank" rel="noopener">NCLEX Checklist Snapshot</a></li>
      </ul>
      <a class="btn btn-outline-primary" href="online-campus.php">Back to Online Campus</a>
    <?php endif; ?>
  </main>
  <footer id="footer" class="footer dark-background">
    <div class="container copyright text-center mt-4"><p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p></div>
  </footer>
</body>
</html>

