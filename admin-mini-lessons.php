<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
require_once __DIR__ . '/mini-lessons-library.php';

$feedback = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string) ($_POST['action'] ?? ''));

    try {
        if ($action === 'add') {
            $title = trim((string) ($_POST['title'] ?? ''));
            $description = trim((string) ($_POST['description'] ?? ''));
            $youtubeUrl = trim((string) ($_POST['youtube_url'] ?? ''));
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);

            if ($title === '' || $youtubeUrl === '') {
                throw new InvalidArgumentException('Title and YouTube URL are required.');
            }

            add_mini_lesson($title, $description, $youtubeUrl, $sortOrder);
            $feedback = 'Mini lesson added successfully.';
        } elseif ($action === 'delete') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id <= 0) {
                throw new InvalidArgumentException('Invalid lesson ID.');
            }
            delete_mini_lesson($id);
            $feedback = 'Mini lesson deleted.';
        }
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
    }
}

$lessons = [];
try {
    $lessons = get_all_mini_lessons();
} catch (Throwable $exception) {
    $error = $error !== '' ? $error : 'Unable to load lessons.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin Mini Lessons | Gapuz Review Academy</title>
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
</head>
<body class="index-page gra-page">
  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
          <img src="assets/img/gra/gra-logo.png" alt="Gapuz Review Academy logo">
        </a>
        <a class="cta-btn" href="mini-lessons.php">View Mini Lessons</a>
      </div>
    </div>
  </header>

  <main class="container py-5">
    <div class="section-title">
      <h2>Admin Mini Lessons</h2>
      <p>Add YouTube lessons to the Online Campus mini lessons page.</p>
    </div>

    <?php if ($feedback !== ''): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <section class="mb-4 p-3 border rounded bg-white">
      <h3 class="h5">Add Mini Lesson</h3>
      <form method="post" action="admin-mini-lessons.php">
        <input type="hidden" name="action" value="add">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="title" class="form-label">Lesson Title</label>
            <input id="title" name="title" type="text" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="youtube_url" class="form-label">YouTube URL</label>
            <input id="youtube_url" name="youtube_url" type="url" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-9 mb-3">
            <label for="description" class="form-label">Description</label>
            <input id="description" name="description" type="text" class="form-control">
          </div>
          <div class="col-md-3 mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input id="sort_order" name="sort_order" type="number" class="form-control" value="0">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Lesson</button>
      </form>
    </section>

    <section class="p-3 border rounded bg-white">
      <h3 class="h5">Saved Lessons</h3>
      <?php if (count($lessons) === 0): ?>
        <p class="mb-0">No lessons saved yet.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>YouTube URL</th>
                <th>Sort</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($lessons as $lesson): ?>
              <tr>
                <td><?php echo (int) $lesson['id']; ?></td>
                <td><?php echo htmlspecialchars($lesson['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><a href="<?php echo htmlspecialchars($lesson['youtube_url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($lesson['youtube_url'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                <td><?php echo (int) $lesson['sort_order']; ?></td>
                <td>
                  <form method="post" action="admin-mini-lessons.php" onsubmit="return confirm('Delete this lesson?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo (int) $lesson['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
