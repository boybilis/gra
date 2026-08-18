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
        <iframe id="orientation-video" src="https://www.youtube.com/embed/sYEitZ01THI?enablejsapi=1&amp;playsinline=1" title="Orientation Webinar" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
      </div>
      <a class="btn btn-outline-primary" href="online-campus.php">Back to Online Campus</a>
  </main>
  <footer id="footer" class="footer dark-background">
    <div class="container copyright text-center mt-4"><p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p></div>
  </footer>
  <script>
    (() => {
      let player = null;
      let resumeWhenActive = false;
      let automaticPausePending = false;

      const pageIsActive = () => document.visibilityState === 'visible' && document.hasFocus();

      const pauseForInactivity = () => {
        if (!player || typeof player.getPlayerState !== 'function') return;
        const state = player.getPlayerState();
        if (state !== YT.PlayerState.PLAYING && state !== YT.PlayerState.BUFFERING) return;

        resumeWhenActive = true;
        automaticPausePending = true;
        player.pauseVideo();
      };

      const resumeForActivity = () => {
        if (!player || !resumeWhenActive || !pageIsActive()) return;
        resumeWhenActive = false;
        player.playVideo();
      };

      window.onYouTubeIframeAPIReady = () => {
        player = new YT.Player('orientation-video', {
          events: {
            onStateChange: (event) => {
              if (event.data === YT.PlayerState.PAUSED) {
                if (automaticPausePending) {
                  automaticPausePending = false;
                } else if (pageIsActive()) {
                  resumeWhenActive = false;
                }
              }

              if (event.data === YT.PlayerState.PLAYING && !pageIsActive()) {
                pauseForInactivity();
              }

              if (event.data === YT.PlayerState.ENDED) {
                resumeWhenActive = false;
                automaticPausePending = false;
              }
            }
          }
        });
      };

      document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
          pauseForInactivity();
        } else {
          resumeForActivity();
        }
      });

      window.addEventListener('blur', () => {
        window.setTimeout(() => {
          if (!document.hasFocus()) pauseForInactivity();
        }, 100);
      });
      window.addEventListener('focus', resumeForActivity);
      window.addEventListener('pagehide', pauseForInactivity);
      window.addEventListener('pageshow', resumeForActivity);
    })();
  </script>
  <script src="https://www.youtube.com/iframe_api"></script>
</body>
</html>



