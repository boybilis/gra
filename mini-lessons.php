<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
require_once __DIR__ . '/campus-access.php';
require_once __DIR__ . '/mini-lessons-library.php';

$email = trim((string) ($_GET['email'] ?? ''));
$accessGranted = is_booking_email_registered($email);
$lessons = [];
$loadError = null;
if ($accessGranted) {
    try {
        $lessons = get_active_mini_lessons();
    } catch (Throwable $exception) {
        $loadError = 'Unable to load mini lessons right now.';
    }
}
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
    .campus-video-item h3 { font-size: 15px; margin: 0; color: #003057; }
    #campus-main-desc { white-space: pre-line; }
    .campus-gate { max-width: 760px; margin: 48px auto; background: #fff; border: 1px solid rgba(0,48,87,.16); border-radius: 8px; padding: 24px; text-align: center; }
    @media (max-width: 992px) { .campus-video-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body class="index-page gra-page campus-video-page">
  <header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="d-none d-md-flex align-items-center">Learn with confidence. Review with support.</div>
        <div class="d-flex align-items-center gap-3"><span><i class="bi bi-telephone me-1"></i> 0285599060 / 85599062</span><span><i class="bi bi-envelope me-1"></i> Inquire@gratestprepworldwide.com</span></div>
      </div>
    </div>
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
      <?php if ($loadError !== null): ?>
      <div class="campus-gate">
        <h3>Mini Lessons</h3>
        <p><?php echo htmlspecialchars($loadError, ENT_QUOTES, 'UTF-8'); ?></p>
      </div>
      <?php elseif (count($lessons) === 0): ?>
      <div class="campus-gate">
        <h3>No Lessons Yet</h3>
        <p>Mini lessons will appear here once added by admin.</p>
      </div>
      <?php else: ?>
      <?php $firstLesson = $lessons[0]; ?>
      <div class="campus-video-grid">
        <article class="campus-video-player">
          <iframe id="campus-main-video" src="https://www.youtube.com/embed/<?php echo htmlspecialchars($firstLesson['youtube_video_id'], ENT_QUOTES, 'UTF-8'); ?>" title="GRA Mini Lesson" allowfullscreen></iframe>
          <h3 id="campus-main-title" class="mt-3 mb-1"><?php echo htmlspecialchars($firstLesson['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
          <p id="campus-main-desc" class="mb-0"><?php echo htmlspecialchars((string) ($firstLesson['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
        </article>
        <aside class="campus-video-list">
          <h3 class="h5 mb-1 px-1">Video Lessons</h3>
          <?php foreach ($lessons as $lesson): ?>
          <a class="campus-video-item" href="#" data-video-id="<?php echo htmlspecialchars($lesson['youtube_video_id'], ENT_QUOTES, 'UTF-8'); ?>" data-video-title="<?php echo htmlspecialchars($lesson['title'], ENT_QUOTES, 'UTF-8'); ?>" data-video-desc="<?php echo htmlspecialchars((string) ($lesson['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <img src="https://img.youtube.com/vi/<?php echo htmlspecialchars($lesson['youtube_video_id'], ENT_QUOTES, 'UTF-8'); ?>/hqdefault.jpg" alt="<?php echo htmlspecialchars($lesson['title'], ENT_QUOTES, 'UTF-8'); ?>">
            <div><h3><?php echo htmlspecialchars($lesson['title'], ENT_QUOTES, 'UTF-8'); ?></h3></div>
          </a>
          <?php endforeach; ?>
        </aside>
      </div>
      <?php endif; ?>
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

