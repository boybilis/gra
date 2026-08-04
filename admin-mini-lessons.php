<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
require_once __DIR__ . '/mini-lessons-library.php';
require_once __DIR__ . '/mini-lessons-admin-auth.php';
require_once __DIR__ . '/course-schedule-library.php';

$feedback = '';
$error = '';
$loginError = '';
$activeAdminTab = 'free-course';
$miniLessonCourseOptions = get_mini_lesson_course_options();
$miniLessonCourseOptionsForAdmin = $miniLessonCourseOptions;
$testimonialFolderOptions = [
    'nclex' => 'NCLEX',
    'dha' => 'DHA',
    'haad-doh' => 'HAAD / DOH',
    'prometric' => 'Prometric',
    'pnle' => 'PNLE',
    'sple' => 'SPLE',
    'lept' => 'LEPT',
    'civil-service' => 'Civil Service',
];
$testimonialBaseDir = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'gra' . DIRECTORY_SEPARATOR . 'passers';
$courseScheduleOptions = get_course_schedule_options();

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

function admin_datatable_request(): array
{
    $order = isset($_GET['order'][0]) && is_array($_GET['order'][0]) ? $_GET['order'][0] : [];
    $search = isset($_GET['search']) && is_array($_GET['search']) ? $_GET['search'] : [];

    return [
        'draw' => max(0, (int) ($_GET['draw'] ?? 0)),
        'start' => max(0, (int) ($_GET['start'] ?? 0)),
        'length' => min(100, max(10, (int) ($_GET['length'] ?? 10))),
        'search' => trim((string) ($search['value'] ?? '')),
        'order_column' => max(0, (int) ($order['column'] ?? 0)),
        'order_direction' => strtolower((string) ($order['dir'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC',
    ];
}

function send_admin_datatable_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

if (isset($_GET['ajax_table'])) {
    $request = admin_datatable_request();
    if (!is_mini_lessons_admin_logged_in()) {
        send_admin_datatable_response([
            'draw' => $request['draw'],
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
            'error' => 'Your admin session has expired. Please sign in again.',
        ], 401);
    }

    try {
        $table = strtolower(trim((string) $_GET['ajax_table']));

        if ($table === 'lessons') {
            $database = get_database();
            $courseLabels = get_mini_lesson_course_options();
            $orderColumns = ['id', 'title', 'course', 'sort_order'];
            $orderColumn = $orderColumns[$request['order_column']] ?? 'sort_order';
            $where = '';
            $parameters = [];

            if ($request['search'] !== '') {
                $where = ' WHERE title LIKE :search_title
                           OR course LIKE :search_course
                           OR youtube_url LIKE :search_url
                           OR CAST(id AS CHAR) LIKE :search_id';
                $searchValue = '%' . $request['search'] . '%';
                $parameters = [
                    ':search_title' => $searchValue,
                    ':search_course' => $searchValue,
                    ':search_url' => $searchValue,
                    ':search_id' => $searchValue,
                ];
            }

            $recordsTotal = (int) $database->query('SELECT COUNT(*) FROM mini_lessons')->fetchColumn();
            if ($where === '') {
                $recordsFiltered = $recordsTotal;
            } else {
                $countStatement = $database->prepare('SELECT COUNT(*) FROM mini_lessons' . $where);
                $countStatement->execute($parameters);
                $recordsFiltered = (int) $countStatement->fetchColumn();
            }

            $query = 'SELECT id, title, course, description, youtube_url, sort_order
                      FROM mini_lessons' . $where . '
                      ORDER BY ' . $orderColumn . ' ' . $request['order_direction'] . ', id ASC
                      LIMIT :limit OFFSET :offset';
            $statement = $database->prepare($query);
            foreach ($parameters as $name => $value) {
                $statement->bindValue($name, $value, PDO::PARAM_STR);
            }
            $statement->bindValue(':limit', $request['length'], PDO::PARAM_INT);
            $statement->bindValue(':offset', $request['start'], PDO::PARAM_INT);
            $statement->execute();

            $rows = array_map(static function (array $lesson) use ($courseLabels): array {
                $course = (string) $lesson['course'];
                return [
                    'id' => (int) $lesson['id'],
                    'title' => (string) $lesson['title'],
                    'course_key' => $course,
                    'course' => $courseLabels[$course] ?? strtoupper($course),
                    'description' => (string) ($lesson['description'] ?? ''),
                    'youtube_url' => (string) $lesson['youtube_url'],
                    'sort_order' => (int) $lesson['sort_order'],
                ];
            }, $statement->fetchAll());

            send_admin_datatable_response([
                'draw' => $request['draw'],
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $rows,
            ]);
        }

        if ($table === 'schedules') {
            $rows = get_all_course_schedule_images();
            $recordsTotal = count($rows);
            $searchTerm = strtolower($request['search']);

            if ($searchTerm !== '') {
                $rows = array_values(array_filter($rows, static function (array $row) use ($searchTerm): bool {
                    $haystack = strtolower(implode(' ', [
                        (string) $row['label'],
                        (string) $row['image_path'],
                        $row['is_default'] ? 'Default Artemis image' : 'Uploaded image',
                    ]));
                    return str_contains($haystack, $searchTerm);
                }));
            }

            $recordsFiltered = count($rows);
            $scheduleOrderColumns = ['label', 'image_path', 'status'];
            $scheduleOrderColumn = $scheduleOrderColumns[$request['order_column']] ?? 'label';
            usort($rows, static function (array $left, array $right) use ($scheduleOrderColumn, $request): int {
                $leftValue = $scheduleOrderColumn === 'status'
                    ? ($left['is_default'] ? 'Default Artemis image' : 'Uploaded image')
                    : (string) $left[$scheduleOrderColumn];
                $rightValue = $scheduleOrderColumn === 'status'
                    ? ($right['is_default'] ? 'Default Artemis image' : 'Uploaded image')
                    : (string) $right[$scheduleOrderColumn];
                $comparison = strnatcasecmp($leftValue, $rightValue);
                return $request['order_direction'] === 'DESC' ? -$comparison : $comparison;
            });

            $pageRows = array_slice($rows, $request['start'], $request['length']);
            $data = array_map(static fn (array $row): array => [
                'course' => (string) $row['label'],
                'image_path' => (string) $row['image_path'],
                'status' => $row['is_default'] ? 'Default Artemis image' : 'Uploaded image',
            ], $pageRows);

            send_admin_datatable_response([
                'draw' => $request['draw'],
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        }

        throw new InvalidArgumentException('Unknown table requested.');
    } catch (Throwable $exception) {
        send_admin_datatable_response([
            'draw' => $request['draw'],
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
            'error' => 'Unable to load table data.',
        ], 500);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_mini_lessons_admin_logged_in()) {
    $action = trim((string) ($_POST['action'] ?? ''));
    if ($action === 'upload_testimonials') {
        $activeAdminTab = 'testimonials';
    } elseif ($action === 'upload_schedule') {
        $activeAdminTab = 'schedules';
    }

    try {
        if ($action === 'add') {
            $title = trim((string) ($_POST['title'] ?? ''));
            $course = trim((string) ($_POST['course'] ?? ''));
            $description = trim((string) ($_POST['description'] ?? ''));
            $youtubeUrl = trim((string) ($_POST['youtube_url'] ?? ''));
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);

            if ($title === '' || $course === '' || $youtubeUrl === '') {
                throw new InvalidArgumentException('Title, course, and YouTube URL are required.');
            }

            add_mini_lesson($title, $course, $description, $youtubeUrl, $sortOrder);
            $feedback = 'Mini lesson added successfully.';
        } elseif ($action === 'update') {
            $id = (int) ($_POST['id'] ?? 0);
            $title = trim((string) ($_POST['title'] ?? ''));
            $course = trim((string) ($_POST['course'] ?? ''));
            $description = trim((string) ($_POST['description'] ?? ''));
            $youtubeUrl = trim((string) ($_POST['youtube_url'] ?? ''));
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);

            if ($id <= 0 || $title === '' || $course === '' || $youtubeUrl === '') {
                throw new InvalidArgumentException('Lesson ID, title, course, and YouTube URL are required.');
            }

            update_mini_lesson($id, $title, $course, $description, $youtubeUrl, $sortOrder);
            $feedback = 'Mini lesson updated successfully.';
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
        } elseif ($action === 'upload_schedule') {
            $selectedCourse = trim((string) ($_POST['schedule_course'] ?? ''));
            if (!isset($_FILES['schedule_image']) || !is_array($_FILES['schedule_image'])) {
                throw new InvalidArgumentException('Please choose an upcoming schedule image to upload.');
            }

            save_course_schedule_image($selectedCourse, $_FILES['schedule_image']);
            $feedback = 'Upcoming schedule image uploaded for ' . ($courseScheduleOptions[$selectedCourse] ?? strtoupper($selectedCourse)) . '.';
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin Mini Lessons | Gapuz Review Academy</title>
  <link href="assets/img/gra/gra-logo.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    .admin-data-table-wrap .dt-container .dt-search input,
    .admin-data-table-wrap .dt-container .dt-length select { border: 1px solid #ced4da; border-radius: .375rem; background-color: #fff; }
    .admin-data-table-wrap .dt-container .dt-search input { min-width: min(260px, 60vw); padding: .45rem .7rem; }
    .admin-data-table-wrap .dt-container .dt-length select { padding: .35rem 2rem .35rem .55rem; }
    .admin-data-table-wrap table.dataTable tbody td { vertical-align: middle; }
    .admin-data-table-wrap .lesson-url { display: inline-block; max-width: 360px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; vertical-align: middle; }
    .admin-data-table-wrap .lesson-title-column { min-width: 420px; width: 52%; }
    .lesson-title-cell strong { display: block; color: #173c59; font-size: 1rem; line-height: 1.45; }
    .lesson-title-cell .lesson-description { margin: .45rem 0 0; color: #343a40; font-size: .92rem; font-weight: 400; line-height: 1.55; white-space: pre-line; }
    .lesson-title-cell hr { margin: .65rem 0; border-color: #d8e1e9; opacity: 1; }
    .lesson-title-cell .lesson-url { max-width: 100%; font-size: .86rem; }
    .lesson-action-buttons { display: flex; flex-wrap: wrap; gap: .4rem; }
    .admin-tabs { display: flex; gap: .5rem; margin-bottom: 1.5rem; padding: .45rem; overflow-x: auto; border: 1px solid #d8e1e9; border-radius: .75rem; background: #fff; }
    .admin-tab-button { flex: 1 0 auto; min-height: 44px; padding: .65rem 1rem; border: 0; border-radius: .5rem; background: transparent; color: #003057; font-weight: 750; white-space: nowrap; }
    .admin-tab-button:hover { background: #eef5fb; }
    .admin-tab-button.active { background: #003057; color: #fff; box-shadow: 0 5px 14px rgba(0, 48, 87, .18); }
    .admin-tab-button:focus-visible { outline: 3px solid rgba(242, 101, 34, .35); outline-offset: 2px; }
    @media (max-width: 767.98px) {
      .admin-data-table-wrap .dt-container .dt-layout-row { gap: .75rem; align-items: stretch; }
      .admin-data-table-wrap .dt-container .dt-search input { min-width: 0; width: 100%; margin: .35rem 0 0; }
    }
  </style>
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

  <main class="container py-5" data-default-admin-tab="<?php echo htmlspecialchars($activeAdminTab, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="section-title">
      <h2>Admin Dashboard</h2>
      <p>Manage mini lessons, testimonial uploads, and upcoming schedule images.</p>
    </div>

    <?php if ($feedback !== ''): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <nav class="admin-tabs" role="tablist" aria-label="Admin dashboard sections">
      <button id="admin-tab-free-course" class="admin-tab-button active" type="button" role="tab" aria-selected="true" aria-controls="admin-panel-free-course" data-admin-tab="free-course">Free Course</button>
      <button id="admin-tab-testimonials" class="admin-tab-button" type="button" role="tab" aria-selected="false" aria-controls="admin-panel-testimonials" data-admin-tab="testimonials" tabindex="-1">Testimonials</button>
      <button id="admin-tab-schedules" class="admin-tab-button" type="button" role="tab" aria-selected="false" aria-controls="admin-panel-schedules" data-admin-tab="schedules" tabindex="-1">Schedules</button>
    </nav>

    <section id="admin-panel-free-course" class="mb-4 p-3 border rounded bg-white" role="tabpanel" aria-labelledby="admin-tab-free-course" data-admin-panel="free-course">
      <h3 id="lesson-form-heading" class="h5">Add Mini Lesson</h3>
      <form id="lesson-form" method="post" action="admin-mini-lessons.php">
        <input id="lesson-form-action" type="hidden" name="action" value="add">
        <input id="lesson-id" type="hidden" name="id" value="">
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
          <div class="col-md-4 mb-3">
            <label for="course" class="form-label">Course</label>
            <select id="course" name="course" class="form-select" required>
              <option value="">Select course</option>
              <?php foreach ($miniLessonCourseOptionsForAdmin as $courseKey => $courseLabel): ?>
                <option value="<?php echo htmlspecialchars($courseKey, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($courseLabel, ENT_QUOTES, 'UTF-8'); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-5 mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4"></textarea>
          </div>
          <div class="col-md-3 mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input id="sort_order" name="sort_order" type="number" class="form-control" value="0">
          </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <button id="lesson-submit-button" type="submit" class="btn btn-primary">Save Lesson</button>
          <button id="cancel-lesson-edit" type="button" class="btn btn-outline-secondary" hidden>Cancel Edit</button>
        </div>
      </form>
    </section>

    <section id="admin-panel-testimonials" class="mb-4 p-3 border rounded bg-white" role="tabpanel" aria-labelledby="admin-tab-testimonials" data-admin-panel="testimonials" hidden>
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

    <section id="admin-panel-schedules" class="mb-4 p-3 border rounded bg-white" role="tabpanel" aria-labelledby="admin-tab-schedules" data-admin-panel="schedules" hidden>
      <h3 class="h5">Upload Upcoming Schedule</h3>
      <p class="mb-3">Upload one feature image per course. This image replaces the default Artemis image in the course Upcoming Schedules section.</p>
      <form method="post" action="admin-mini-lessons.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload_schedule">
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="schedule_course" class="form-label">Course</label>
            <select id="schedule_course" name="schedule_course" class="form-select" required>
              <option value="">Select course</option>
              <?php foreach ($courseScheduleOptions as $courseKey => $courseLabel): ?>
                <option value="<?php echo htmlspecialchars($courseKey, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($courseLabel, ENT_QUOTES, 'UTF-8'); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-8 mb-3">
            <label for="schedule_image" class="form-label">Upcoming Schedule Image</label>
            <input id="schedule_image" name="schedule_image" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif" required>
            <div class="form-text">Allowed formats: JPG, JPEG, PNG, WEBP, GIF (max 8MB).</div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Upload Schedule Image</button>
      </form>
    </section>

    <section class="p-3 border rounded bg-white admin-data-table-wrap" role="tabpanel" aria-labelledby="admin-tab-free-course" data-admin-panel="free-course">
      <h3 class="h5">Saved Lessons</h3>
      <div class="table-responsive">
          <table id="saved-lessons-table" class="table align-middle w-100">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Course</th>
                <th>Sort</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
      </div>
      <noscript><p class="alert alert-warning mt-3 mb-0">JavaScript is required to view and search saved lessons.</p></noscript>
    </section>

    <section class="mt-4 p-3 border rounded bg-white admin-data-table-wrap" role="tabpanel" aria-labelledby="admin-tab-schedules" data-admin-panel="schedules" hidden>
      <h3 class="h5">Current Upcoming Schedule Images</h3>
      <div class="table-responsive">
        <table id="schedule-images-table" class="table align-middle w-100">
          <thead>
            <tr>
              <th>Course</th>
              <th>Image</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <noscript><p class="alert alert-warning mt-3 mb-0">JavaScript is required to view and search schedule images.</p></noscript>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>
  <script>
    (() => {
      const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;'
      })[character]);

      const lessonsTable = new DataTable('#saved-lessons-table', {
        processing: true,
        serverSide: true,
        ajax: 'admin-mini-lessons.php?ajax_table=lessons',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        searchDelay: 350,
        order: [[3, 'asc']],
        language: {
          search: 'Quick search:',
          emptyTable: 'No lessons saved yet.',
          zeroRecords: 'No matching lessons found.'
        },
        columns: [
          { data: 'id' },
          {
            data: 'title',
            className: 'lesson-title-column',
            render: (data, type, row) => type === 'display'
              ? `<div class="lesson-title-cell"><strong>${escapeHtml(data)}</strong>${row.description ? `<p class="lesson-description">${escapeHtml(row.description)}</p>` : ''}<hr><a class="lesson-url" href="${escapeHtml(row.youtube_url)}" target="_blank" rel="noopener">${escapeHtml(row.youtube_url)}</a></div>`
              : data
          },
          { data: 'course', render: (data) => escapeHtml(data) },
          { data: 'sort_order' },
          {
            data: 'id',
            orderable: false,
            searchable: false,
            render: (data, type) => type === 'display'
              ? `<div class="lesson-action-buttons"><button type="button" class="btn btn-sm btn-outline-primary" data-edit-lesson="${Number(data)}">Edit</button><form method="post" action="admin-mini-lessons.php" onsubmit="return confirm('Delete this lesson?');"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${Number(data)}"><button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form></div>`
              : data
          }
        ]
      });

      const scheduleTable = new DataTable('#schedule-images-table', {
        processing: true,
        serverSide: true,
        ajax: 'admin-mini-lessons.php?ajax_table=schedules',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        searchDelay: 350,
        order: [[0, 'asc']],
        language: {
          search: 'Quick search:',
          emptyTable: 'No schedule images found.',
          zeroRecords: 'No matching schedule images found.'
        },
        columns: [
          { data: 'course', render: (data) => escapeHtml(data) },
          {
            data: 'image_path',
            render: (data, type) => type === 'display'
              ? `<a class="lesson-url" href="${escapeHtml(data)}" target="_blank" rel="noopener">${escapeHtml(data)}</a>`
              : data
          },
          { data: 'status', render: (data) => escapeHtml(data) }
        ]
      });

      const tabButtons = Array.from(document.querySelectorAll('[data-admin-tab]'));
      const tabPanels = Array.from(document.querySelectorAll('[data-admin-panel]'));
      const validTabs = tabButtons.map((button) => button.dataset.adminTab);

      const lessonForm = document.getElementById('lesson-form');
      const lessonFormHeading = document.getElementById('lesson-form-heading');
      const lessonFormAction = document.getElementById('lesson-form-action');
      const lessonIdInput = document.getElementById('lesson-id');
      const lessonSubmitButton = document.getElementById('lesson-submit-button');
      const cancelLessonEdit = document.getElementById('cancel-lesson-edit');

      const resetLessonForm = () => {
        lessonForm.reset();
        lessonFormAction.value = 'add';
        lessonIdInput.value = '';
        lessonFormHeading.textContent = 'Add Mini Lesson';
        lessonSubmitButton.textContent = 'Save Lesson';
        cancelLessonEdit.hidden = true;
      };

      const activateAdminTab = (tabName, updateHash = false) => {
        const selectedTab = validTabs.includes(tabName) ? tabName : 'free-course';
        tabButtons.forEach((button) => {
          const isActive = button.dataset.adminTab === selectedTab;
          button.classList.toggle('active', isActive);
          button.setAttribute('aria-selected', isActive ? 'true' : 'false');
          button.tabIndex = isActive ? 0 : -1;
        });
        tabPanels.forEach((panel) => {
          panel.hidden = panel.dataset.adminPanel !== selectedTab;
        });

        window.requestAnimationFrame(() => {
          if (selectedTab === 'free-course') lessonsTable.columns.adjust();
          if (selectedTab === 'schedules') scheduleTable.columns.adjust();
        });

        if (updateHash && window.history.replaceState) {
          window.history.replaceState(null, '', `#admin-${selectedTab}`);
        }
      };

      tabButtons.forEach((button) => button.addEventListener('click', () => {
        activateAdminTab(button.dataset.adminTab, true);
      }));

      document.addEventListener('click', (event) => {
        const editButton = event.target.closest('[data-edit-lesson]');
        if (!editButton) return;

        const lesson = lessonsTable.row(editButton.closest('tr')).data();
        if (!lesson) return;

        document.getElementById('title').value = lesson.title || '';
        document.getElementById('youtube_url').value = lesson.youtube_url || '';
        document.getElementById('course').value = lesson.course_key || '';
        document.getElementById('description').value = lesson.description || '';
        document.getElementById('sort_order').value = lesson.sort_order ?? 0;
        lessonFormAction.value = 'update';
        lessonIdInput.value = lesson.id;
        lessonFormHeading.textContent = 'Update Lesson';
        lessonSubmitButton.textContent = 'Update Lesson';
        cancelLessonEdit.hidden = false;
        activateAdminTab('free-course', true);
        lessonForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        document.getElementById('title').focus({ preventScroll: true });
      });

      cancelLessonEdit.addEventListener('click', () => {
        resetLessonForm();
        lessonForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });

      const hashTab = window.location.hash.startsWith('#admin-')
        ? window.location.hash.slice('#admin-'.length)
        : '';
      const defaultTab = document.querySelector('main[data-default-admin-tab]')?.dataset.defaultAdminTab || 'free-course';
      activateAdminTab(validTabs.includes(hashTab) ? hashTab : defaultTab);
    })();
  </script>
</body>
</html>


