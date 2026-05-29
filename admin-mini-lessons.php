<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
require_once __DIR__ . '/mini-lessons-library.php';
require_once __DIR__ . '/mini-lessons-admin-auth.php';

$feedback = '';
$error = '';
$loginError = '';
$testimonialFolderOptions = [
    'nclex' => 'NCLEX',
    'dha' => 'DHA',
    'haad-doh' => 'HAAD / DOH',
    'prometric' => 'Prometric',
    'pnle' => 'PNLE',
    'sple' => 'SPLE',
    'civil-service' => 'Civil Service',
];
$testimonialBaseDir = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'gra' . DIRECTORY_SEPARATOR . 'passers';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (string) ($_POST['action'] ?? '') === 'login') {
    $username = (string) ($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    if (!mini_lessons_admin_login($username, $password)) {
        $loginError = 'Invalid username or password.';
    } else {
        header('Location: admin-mini-lessons.php');
        exit;
    }
}

if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    mini_lessons_admin_logout();
    header('Location: admin-mini-lessons.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_mini_lessons_admin_logged_in()) {
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
        } elseif ($action === 'upload_testimonials') {
            $selectedFolder = strtolower(trim((string) ($_POST['testimonial_folder'] ?? '')));
            if (!array_key_exists($selectedFolder, $testimonialFolderOptions)) {
                throw new InvalidArgumentException('Please choose a valid testimonial folder.');
            }
            if (!isset($_FILES['testimonial_images'])) {
                throw new InvalidArgumentException('Please choose image files to upload.');
            }

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $maxFileSizeBytes = 8 * 1024 * 1024;
            $targetDir = $testimonialBaseDir . DIRECTORY_SEPARATOR . $selectedFolder;
            if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
                throw new RuntimeException('Unable to create target upload folder.');
            }

            $names = $_FILES['testimonial_images']['name'] ?? [];
            $tmpNames = $_FILES['testimonial_images']['tmp_name'] ?? [];
            $errors = $_FILES['testimonial_images']['error'] ?? [];
            $sizes = $_FILES['testimonial_images']['size'] ?? [];

            if (!is_array($names) || count($names) === 0) {
                throw new InvalidArgumentException('Please choose image files to upload.');
            }

            $uploadedCount = 0;
            $skippedCount = 0;

            foreach ($names as $index => $originalName) {
                $uploadError = (int) ($errors[$index] ?? UPLOAD_ERR_NO_FILE);
                if ($uploadError === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                if ($uploadError !== UPLOAD_ERR_OK) {
                    $skippedCount++;
                    continue;
                }

                $tmpPath = (string) ($tmpNames[$index] ?? '');
                $fileSize = (int) ($sizes[$index] ?? 0);
                if ($tmpPath === '' || !is_uploaded_file($tmpPath) || $fileSize <= 0 || $fileSize > $maxFileSizeBytes) {
                    $skippedCount++;
                    continue;
                }

                $extension = strtolower(pathinfo((string) $originalName, PATHINFO_EXTENSION));
                if (!in_array($extension, $allowedExtensions, true)) {
                    $skippedCount++;
                    continue;
                }

                $baseName = pathinfo((string) $originalName, PATHINFO_FILENAME);
                $safeBase = preg_replace('/[^A-Za-z0-9._-]+/', '-', $baseName);
                $safeBase = trim((string) $safeBase, '-._');
                if ($safeBase === '') {
                    $safeBase = 'testimonial';
                }

                $targetPath = $targetDir . DIRECTORY_SEPARATOR . $safeBase . '.' . $extension;
                $counter = 1;
                while (file_exists($targetPath)) {
                    $targetPath = $targetDir . DIRECTORY_SEPARATOR . $safeBase . '-' . $counter . '.' . $extension;
                    $counter++;
                }

                if (!move_uploaded_file($tmpPath, $targetPath)) {
                    $skippedCount++;
                    continue;
                }

                $uploadedCount++;
            }

            if ($uploadedCount === 0) {
                throw new RuntimeException('No files were uploaded. Please check your files and try again.');
            }

            $feedback = $uploadedCount . ' testimonial image(s) uploaded to ' . $testimonialFolderOptions[$selectedFolder] . '.';
            if ($skippedCount > 0) {
                $feedback .= ' ' . $skippedCount . ' file(s) were skipped due to invalid format/size or upload error.';
            }
        }
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
    }
}

if (!is_mini_lessons_admin_logged_in()):
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin Login | Gapuz Review Academy</title>
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
</head>
<body class="index-page gra-page">
  <main class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="p-4 border rounded bg-white">
          <h2 class="h4 mb-3">Mini Lessons Admin Login</h2>
          <?php if ($loginError !== ''): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
          <form method="post" action="admin-mini-lessons.php">
            <input type="hidden" name="action" value="login">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input id="username" name="username" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input id="password" name="password" type="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
<?php
exit;
endif;

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
        <div class="d-flex align-items-center gap-2">
          <a class="cta-btn" href="mini-lessons.php">View Mini Lessons</a>
          <a class="btn btn-outline-light btn-sm" href="admin-mini-lessons.php?logout=1">Logout</a>
        </div>
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
            <textarea id="description" name="description" class="form-control" rows="4"></textarea>
          </div>
          <div class="col-md-3 mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input id="sort_order" name="sort_order" type="number" class="form-control" value="0">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Lesson</button>
      </form>
    </section>

    <section class="mb-4 p-3 border rounded bg-white">
      <h3 class="h5">Upload Testimonials (Bulk)</h3>
      <p class="mb-3">Upload multiple images to a course folder under <code>assets/img/gra/passers</code>.</p>
      <form method="post" action="admin-mini-lessons.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload_testimonials">
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="testimonial_folder" class="form-label">Course Folder</label>
            <select id="testimonial_folder" name="testimonial_folder" class="form-select" required>
              <option value="">Select folder</option>
              <?php foreach ($testimonialFolderOptions as $folderKey => $folderLabel): ?>
                <option value="<?php echo htmlspecialchars($folderKey, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($folderLabel, ENT_QUOTES, 'UTF-8'); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-8 mb-3">
            <label for="testimonial_images" class="form-label">Images</label>
            <input id="testimonial_images" name="testimonial_images[]" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif" multiple required>
            <div class="form-text">Allowed formats: JPG, JPEG, PNG, WEBP, GIF (max 8MB each).</div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Upload Images</button>
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


