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
  <title>Mini Lessons | Gapuz Review Academy</title>
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    .campus-video-page { background: #f4f7fb; min-height: 100vh; }
    .campus-video-shell { max-width: 1200px; margin: 0 auto; padding: 28px 16px 48px; }
    .campus-video-grid { display: grid; gap: 18px; grid-template-columns: minmax(0, 1.8fr) minmax(290px, 1fr); }
    .campus-video-player, .campus-video-list { background: #fff; border: 1px solid rgba(0,48,87,.16); border-radius: 8px; }
    .campus-video-player { padding: 16px; }
    .campus-video-player iframe { width: 100%; aspect-ratio: 16 / 9; border: 0; border-radius: 6px; }
    .campus-video-list { padding: 10px; display: grid; gap: 10px; }
    .campus-video-item { display: grid; grid-template-columns: 118px 1fr; gap: 10px; text-decoration: none; color: #1f2d3d; border: 1px solid rgba(0,48,87,.14); border-radius: 6px; padding: 8px; }
    .campus-video-item img { width: 100%; border-radius: 4px; object-fit: cover; }
    .campus-video-item h3 { font-size: 15px; margin: 0 0 4px; color: #003057; }
    .campus-video-item p { font-size: 13px; margin: 0; }
    .campus-gate { max-width: 760px; margin: 48px auto; background: #fff; border: 1px solid rgba(0,48,87,.16); border-radius: 8px; padding: 24px; text-align: center; }
    @media (max-width: 992px) { .campus-video-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body class="index-page gra-page campus-video-page">
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

  <main class="main">
    <?php if (!$accessGranted): ?>
    <section class="campus-gate">
      <h2>Email Verification Needed</h2>
      <p>Please unlock resources from Online Campus first using your registered email.</p>
      <a class="btn btn-primary" href="online-campus.php#campus-access">Go to Email Verification</a>
    </section>
    <?php else: ?>
    <section class="campus-video-shell">
      <div class="section-title">
        <h2>Mini Lessons</h2>
        <p>Watch free lessons from the GRA online campus channel.</p>
      </div>
      <div class="campus-video-grid">
        <article class="campus-video-player">
          <iframe id="campus-main-video" src="https://www.youtube.com/embed/1Q8fG0TtVAY" title="GRA Mini Lesson" allowfullscreen></iframe>
          <h3 id="campus-main-title" class="mt-3 mb-1">NCLEX Pharmacology Basics</h3>
          <p id="campus-main-desc" class="mb-0">Build a solid approach to common medication question types.</p>
        </article>
        <aside class="campus-video-list">
          <a class="campus-video-item" href="#" data-video-id="1Q8fG0TtVAY" data-video-title="NCLEX Pharmacology Basics" data-video-desc="Build a solid approach to common medication question types.">
            <img src="https://img.youtube.com/vi/1Q8fG0TtVAY/hqdefault.jpg" alt="NCLEX Pharmacology Basics">
            <div><h3>NCLEX Pharmacology Basics</h3><p>Medication safety and high-yield recall tips.</p></div>
          </a>
          <a class="campus-video-item" href="#" data-video-id="fVY4nJ1xkR8" data-video-title="PNLE Test-Taking Strategy" data-video-desc="A practical framework for timed PNLE questions.">
            <img src="https://img.youtube.com/vi/fVY4nJ1xkR8/hqdefault.jpg" alt="PNLE Test-Taking Strategy">
            <div><h3>PNLE Test-Taking Strategy</h3><p>How to avoid traps and eliminate wrong options.</p></div>
          </a>
          <a class="campus-video-item" href="#" data-video-id="3fumBcKC6RE" data-video-title="DHA Review Planning" data-video-desc="Plan your weekly DHA review with better retention.">
            <img src="https://img.youtube.com/vi/3fumBcKC6RE/hqdefault.jpg" alt="DHA Review Planning">
            <div><h3>DHA Review Planning</h3><p>Create a focused schedule in under 10 minutes.</p></div>
          </a>
          <a class="campus-video-item" href="#" data-video-id="J---aiyznGQ" data-video-title="Memory Anchoring for Nursing Exams" data-video-desc="Use quick memory anchors for difficult topics.">
            <img src="https://img.youtube.com/vi/J---aiyznGQ/hqdefault.jpg" alt="Memory Anchoring">
            <div><h3>Memory Anchoring</h3><p>Simple techniques to remember core concepts.</p></div>
          </a>
        </aside>
      </div>
    </section>
    <?php endif; ?>
  </main>

  <script>
    (() => {
      const mainVideo = document.getElementById('campus-main-video');
      const mainTitle = document.getElementById('campus-main-title');
      const mainDesc = document.getElementById('campus-main-desc');
      const items = Array.from(document.querySelectorAll('.campus-video-item'));
      items.forEach((item) => {
        item.addEventListener('click', (event) => {
          event.preventDefault();
          const id = item.dataset.videoId || '';
          if (!id || !mainVideo) return;
          mainVideo.src = `https://www.youtube.com/embed/${id}`;
          if (mainTitle) mainTitle.textContent = item.dataset.videoTitle || '';
          if (mainDesc) mainDesc.textContent = item.dataset.videoDesc || '';
        });
      });
    })();
  </script>
</body>
</html>
