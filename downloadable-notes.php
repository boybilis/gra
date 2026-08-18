<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';

$downloadableNotes = [
    [
        'id' => 'end-user-agreement',
        'title' => 'End User Agreement',
        'description' => 'Review the terms and conditions for using the learning resources.',
        'file' => 'assets/documents/downloadable-notes/dummy-end-user-agreement.pdf',
    ],
    [
        'id' => 'subject-policy',
        'title' => 'Subject Policy',
        'description' => 'Read the policies and guidelines that apply to your subject materials.',
        'file' => 'assets/documents/downloadable-notes/dummy-subject-policy.pdf',
    ],
    [
        'id' => 'maternal-child-nursing',
        'title' => 'Maternal and Child Nursing Handout',
        'description' => 'Study the Maternal and Child Nursing reference handout.',
        'file' => 'assets/documents/downloadable-notes/maternal-and-child-nursing-handout.pdf',
    ],
];

foreach ($downloadableNotes as &$note) {
    $absolutePath = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $note['file']);
    $fileSize = is_file($absolutePath) ? filesize($absolutePath) : 0;
    $note['size'] = $fileSize >= 1048576
        ? number_format($fileSize / 1048576, 1) . ' MB'
        : number_format($fileSize / 1024, 0) . ' KB';
}
unset($note);

$firstNote = $downloadableNotes[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Downloadable Notes | Gapuz Review Academy</title>
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    .notes-library { padding: 42px 0 56px; background: #f4f7fa; }
    .notes-library-heading { margin-bottom: 24px; }
    .notes-library-heading h1 { margin-bottom: 8px; color: #003057; font-size: clamp(1.8rem, 3vw, 2.45rem); font-weight: 800; }
    .notes-library-heading p { margin: 0; color: #536576; }
    .notes-workspace { display: grid; grid-template-columns: minmax(250px, 310px) minmax(0, 1fr); min-height: 720px; overflow: hidden; border: 1px solid #d9e2ea; border-radius: 16px; background: #fff; box-shadow: 0 16px 42px rgba(0, 48, 87, .09); }
    .notes-sidebar { padding: 22px 18px; border-right: 1px solid #d9e2ea; background: #f9fbfd; }
    .notes-sidebar h2 { margin: 0 0 6px; color: #003057; font-size: 1.05rem; font-weight: 800; }
    .notes-sidebar-intro { margin: 0 0 17px; color: #697987; font-size: .88rem; }
    .notes-list { display: grid; gap: 10px; }
    .notes-list-button { display: grid; grid-template-columns: 38px minmax(0, 1fr); gap: 11px; width: 100%; padding: 13px; border: 1px solid #d9e2ea; border-radius: 11px; background: #fff; color: #243746; text-align: left; transition: border-color .2s ease, background-color .2s ease, box-shadow .2s ease; }
    .notes-list-button:hover { border-color: #8aa5ba; background: #f5f9fc; }
    .notes-list-button.active { border-color: #003057; background: #eaf2f8; box-shadow: inset 4px 0 0 #f26522; }
    .notes-list-icon { display: grid; width: 38px; height: 38px; place-items: center; border-radius: 9px; background: #003057; color: #fff; font-size: 1.1rem; }
    .notes-list-copy { min-width: 0; }
    .notes-list-title { display: block; color: #003057; font-size: .92rem; font-weight: 750; line-height: 1.35; }
    .notes-list-size { display: block; margin-top: 4px; color: #72818d; font-size: .76rem; }
    .notes-viewer { display: flex; min-width: 0; flex-direction: column; background: #e8edf1; }
    .notes-viewer-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 18px; padding: 15px 18px; border-bottom: 1px solid #d4dde5; background: #fff; }
    .notes-viewer-details { min-width: 0; }
    .notes-viewer-details h2 { margin: 0; overflow: hidden; color: #003057; font-size: 1.05rem; font-weight: 800; line-height: 1.35; text-overflow: ellipsis; white-space: nowrap; }
    .notes-viewer-details p { margin: 4px 0 0; color: #687987; font-size: .82rem; line-height: 1.4; }
    .notes-viewer-actions { display: flex; flex: 0 0 auto; flex-wrap: wrap; gap: 8px; }
    .notes-viewer-actions .btn { display: inline-flex; align-items: center; gap: 7px; border-radius: 999px; font-size: .84rem; font-weight: 700; white-space: nowrap; }
    .notes-pdf-frame { width: 100%; min-height: 640px; flex: 1; border: 0; background: #dfe5ea; }
    .notes-mobile-fallback { display: none; padding: 15px; background: #fff; text-align: center; }
    .notes-viewer:fullscreen { width: 100vw; height: 100vh; background: #e8edf1; }
    .notes-viewer:fullscreen .notes-pdf-frame { min-height: 0; }
    @media (max-width: 991.98px) {
      .notes-workspace { grid-template-columns: 1fr; min-height: 0; }
      .notes-sidebar { border-right: 0; border-bottom: 1px solid #d9e2ea; }
      .notes-list { grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .notes-list-button { grid-template-columns: 32px minmax(0, 1fr); padding: 11px; }
      .notes-list-icon { width: 32px; height: 32px; }
      .notes-pdf-frame { min-height: 68vh; }
    }
    @media (max-width: 767.98px) {
      .notes-library { padding-top: 28px; }
      .notes-list { grid-template-columns: 1fr; }
      .notes-viewer-toolbar { align-items: flex-start; flex-direction: column; }
      .notes-viewer-details h2 { white-space: normal; }
      .notes-viewer-actions { width: 100%; }
      .notes-viewer-actions .btn { flex: 1 1 auto; justify-content: center; }
      .notes-pdf-frame { min-height: 62vh; }
      .notes-mobile-fallback { display: block; }
    }
  </style>
</head>
<body class="index-page gra-page footer-stick-page">
  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
          <img src="assets/img/gra/gra-logo.png" alt="Gapuz Review Academy logo">
        </a>
        <a class="cta-btn" href="online-campus.php#campus-access">Back to Online Campus</a>
      </div>
    </div>
  </header>

  <main class="notes-library">
    <div class="container">
      <div class="notes-library-heading">
        <h1>Downloadable Notes</h1>
        <p>Select a learning resource to read online, view full screen, or download for later.</p>
      </div>

      <div class="notes-workspace">
        <aside class="notes-sidebar" aria-label="Downloadable PDF list">
          <h2>Learning Resources</h2>
          <p class="notes-sidebar-intro"><?php echo count($downloadableNotes); ?> PDF documents available</p>
          <div class="notes-list" role="list">
            <?php foreach ($downloadableNotes as $index => $note): ?>
              <button
                type="button"
                class="notes-list-button<?php echo $index === 0 ? ' active' : ''; ?>"
                data-note-id="<?php echo htmlspecialchars($note['id'], ENT_QUOTES, 'UTF-8'); ?>"
                aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                role="listitem"
              >
                <span class="notes-list-icon" aria-hidden="true"><i class="bi bi-file-earmark-pdf"></i></span>
                <span class="notes-list-copy">
                  <span class="notes-list-title"><?php echo htmlspecialchars($note['title'], ENT_QUOTES, 'UTF-8'); ?></span>
                  <span class="notes-list-size">PDF &middot; <?php echo htmlspecialchars($note['size'], ENT_QUOTES, 'UTF-8'); ?></span>
                </span>
              </button>
            <?php endforeach; ?>
          </div>
        </aside>

        <section id="notes-viewer" class="notes-viewer" aria-labelledby="selected-note-title">
          <div class="notes-viewer-toolbar">
            <div class="notes-viewer-details">
              <h2 id="selected-note-title"><?php echo htmlspecialchars($firstNote['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
              <p id="selected-note-description"><?php echo htmlspecialchars($firstNote['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="notes-viewer-actions">
              <a id="open-note" class="btn btn-outline-secondary" href="<?php echo htmlspecialchars($firstNote['file'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> Open PDF
              </a>
              <a id="download-note" class="btn btn-outline-primary" href="<?php echo htmlspecialchars($firstNote['file'], ENT_QUOTES, 'UTF-8'); ?>" download>
                <i class="bi bi-download" aria-hidden="true"></i> Download
              </a>
              <button id="fullscreen-note" type="button" class="btn btn-primary">
                <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i> <span>Full Screen</span>
              </button>
            </div>
          </div>
          <iframe
            id="notes-pdf-frame"
            class="notes-pdf-frame"
            src="<?php echo htmlspecialchars($firstNote['file'], ENT_QUOTES, 'UTF-8'); ?>#toolbar=1&amp;navpanes=0&amp;view=FitH"
            title="<?php echo htmlspecialchars($firstNote['title'], ENT_QUOTES, 'UTF-8'); ?> PDF viewer"
          ></iframe>
          <div class="notes-mobile-fallback">
            If the preview does not appear on your device, use <strong>Open PDF</strong> above.
          </div>
        </section>
      </div>
    </div>
  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container copyright text-center mt-4"><p><span>Copyright</span> <strong class="px-1 sitename">Gapuz Review Academy</strong> <span>All Rights Reserved</span></p></div>
  </footer>

  <script>
    (() => {
      const notes = <?php echo json_encode($downloadableNotes, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
      const noteButtons = Array.from(document.querySelectorAll('[data-note-id]'));
      const viewer = document.getElementById('notes-viewer');
      const frame = document.getElementById('notes-pdf-frame');
      const title = document.getElementById('selected-note-title');
      const description = document.getElementById('selected-note-description');
      const openLink = document.getElementById('open-note');
      const downloadLink = document.getElementById('download-note');
      const fullscreenButton = document.getElementById('fullscreen-note');
      const fullscreenLabel = fullscreenButton.querySelector('span');
      const fullscreenIcon = fullscreenButton.querySelector('i');

      const selectNote = (noteId) => {
        const note = notes.find((item) => item.id === noteId);
        if (!note) return;

        noteButtons.forEach((button) => {
          const isActive = button.dataset.noteId === noteId;
          button.classList.toggle('active', isActive);
          button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });

        title.textContent = note.title;
        description.textContent = note.description;
        frame.title = `${note.title} PDF viewer`;
        frame.src = `${note.file}#toolbar=1&navpanes=0&view=FitH`;
        openLink.href = note.file;
        downloadLink.href = note.file;
        downloadLink.setAttribute('download', note.file.split('/').pop());
      };

      noteButtons.forEach((button) => {
        button.addEventListener('click', () => selectNote(button.dataset.noteId));
      });

      fullscreenButton.addEventListener('click', async () => {
        try {
          if (document.fullscreenElement) {
            await document.exitFullscreen();
          } else if (viewer.requestFullscreen) {
            await viewer.requestFullscreen();
          } else if (viewer.webkitRequestFullscreen) {
            viewer.webkitRequestFullscreen();
          } else {
            window.open(openLink.href, '_blank', 'noopener');
          }
        } catch (error) {
          window.open(openLink.href, '_blank', 'noopener');
        }
      });

      document.addEventListener('fullscreenchange', () => {
        const isFullscreen = document.fullscreenElement === viewer;
        fullscreenLabel.textContent = isFullscreen ? 'Exit Full Screen' : 'Full Screen';
        fullscreenIcon.className = isFullscreen ? 'bi bi-fullscreen-exit' : 'bi bi-arrows-fullscreen';
      });
    })();
  </script>
</body>
</html>
