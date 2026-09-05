<?php
declare(strict_types=1);

require_once __DIR__ . '/asset-version.php';
require_once __DIR__ . '/mini-lessons-library.php';
require_once __DIR__ . '/mini-lessons-admin-auth.php';
require_once __DIR__ . '/course-schedule-library.php';
require_once __DIR__ . '/course-hero-library.php';

$feedback = (string) ($_SESSION['admin_feedback'] ?? '');
unset($_SESSION['admin_feedback']);
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
$courseHeroOptions = get_course_hero_options();
$testimonialCsrfToken = (string) ($_SESSION['testimonial_csrf_token'] ?? '');
if ($testimonialCsrfToken === '') {
    $testimonialCsrfToken = bin2hex(random_bytes(32));
    $_SESSION['testimonial_csrf_token'] = $testimonialCsrfToken;
}

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

function get_testimonial_gallery_folders(string $baseDir): array
{
    if (!is_dir($baseDir)) {
        return [];
    }

    $folders = [];
    foreach (new DirectoryIterator($baseDir) as $entry) {
        if ($entry->isDot() || !$entry->isDir()) {
            continue;
        }
        $folders[] = $entry->getFilename();
    }
    natcasesort($folders);
    return array_values($folders);
}

function send_admin_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

$testimonialGalleryFolders = get_testimonial_gallery_folders($testimonialBaseDir);

if (isset($_GET['ajax_testimonials'])) {
    if (!is_mini_lessons_admin_logged_in()) {
        send_admin_json_response(['error' => 'Your admin session has expired. Please sign in again.'], 401);
    }

    try {
        $selectedFolder = trim((string) ($_GET['folder'] ?? ''));
        if (!in_array($selectedFolder, $testimonialGalleryFolders, true)) {
            throw new InvalidArgumentException('Please select a valid testimonial folder.');
        }

        $folderPath = $testimonialBaseDir . DIRECTORY_SEPARATOR . $selectedFolder;
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $images = [];
        foreach (new DirectoryIterator($folderPath) as $entry) {
            if ($entry->isDot() || !$entry->isFile()) {
                continue;
            }
            $extension = strtolower($entry->getExtension());
            if (!in_array($extension, $allowedExtensions, true)) {
                continue;
            }
            $images[] = $entry->getFilename();
        }
        natcasesort($images);
        $images = array_values($images);

        $perPage = 12;
        $total = count($images);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = min($totalPages, max(1, (int) ($_GET['page'] ?? 1)));
        $pageImages = array_slice($images, ($page - 1) * $perPage, $perPage);
        $data = array_map(static fn (string $filename): array => [
            'filename' => $filename,
            'url' => 'assets/img/gra/passers/' . rawurlencode($selectedFolder) . '/' . rawurlencode($filename),
        ], $pageImages);

        send_admin_json_response([
            'folder' => $selectedFolder,
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'images' => $data,
        ]);
    } catch (Throwable $exception) {
        send_admin_json_response(['error' => $exception->getMessage()], 400);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (string) ($_POST['ajax_action'] ?? '') === 'delete_testimonial') {
    if (!is_mini_lessons_admin_logged_in()) {
        send_admin_json_response(['error' => 'Your admin session has expired. Please sign in again.'], 401);
    }

    try {
        if (!hash_equals($testimonialCsrfToken, (string) ($_POST['csrf_token'] ?? ''))) {
            throw new RuntimeException('The request could not be verified. Please reload the page and try again.');
        }

        $selectedFolder = trim((string) ($_POST['folder'] ?? ''));
        $filename = basename(trim((string) ($_POST['filename'] ?? '')));
        if (!in_array($selectedFolder, $testimonialGalleryFolders, true) || $filename === '') {
            throw new InvalidArgumentException('Invalid testimonial image selection.');
        }

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            throw new InvalidArgumentException('Only testimonial image files can be deleted.');
        }

        $folderPath = realpath($testimonialBaseDir . DIRECTORY_SEPARATOR . $selectedFolder);
        $imagePath = realpath(($folderPath ?: '') . DIRECTORY_SEPARATOR . $filename);
        $basePath = realpath($testimonialBaseDir);
        if ($basePath === false || $folderPath === false || $imagePath === false
            || !str_starts_with($folderPath, $basePath . DIRECTORY_SEPARATOR)
            || dirname($imagePath) !== $folderPath
            || !is_file($imagePath)) {
            throw new RuntimeException('The selected testimonial image was not found.');
        }

        if (!unlink($imagePath)) {
            throw new RuntimeException('Unable to delete the selected testimonial image.');
        }

        send_admin_json_response(['success' => true, 'message' => 'Testimonial image deleted.']);
    } catch (Throwable $exception) {
        send_admin_json_response(['error' => $exception->getMessage()], 400);
    }
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
            $scheduleOrderColumns = ['label', 'image_path', 'custom_text', 'status'];
            $scheduleOrderColumn = $scheduleOrderColumns[$request['order_column']] ?? 'label';
            usort($rows, static function (array $left, array $right) use ($scheduleOrderColumn, $request): int {
                $leftValue = $scheduleOrderColumn === 'status'
                    ? ($left['is_default'] ? 'Default Artemis image' : 'Uploaded image')
                    : (string) ($left[$scheduleOrderColumn] ?? '');
                $rightValue = $scheduleOrderColumn === 'status'
                    ? ($right['is_default'] ? 'Default Artemis image' : 'Uploaded image')
                    : (string) ($right[$scheduleOrderColumn] ?? '');
                $comparison = strnatcasecmp($leftValue, $rightValue);
                return $request['order_direction'] === 'DESC' ? -$comparison : $comparison;
            });

            $pageRows = array_slice($rows, $request['start'], $request['length']);
            $data = array_map(static fn (array $row): array => [
                'course_key' => (string) $row['course_key'],
                'course' => (string) $row['label'],
                'image_path' => (string) $row['image_path'],
                'image_count' => (int) $row['image_count'],
                'custom_text' => (string) $row['custom_text'],
                'has_custom_text' => (bool) $row['has_custom_text'],
                'is_default' => (bool) $row['is_default'],
                'status' => $row['is_default'] ? 'Default Artemis image' : 'Uploaded image',
            ], $pageRows);

            send_admin_datatable_response([
                'draw' => $request['draw'],
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        }

        if ($table === 'hero-images') {
            $rows = get_all_course_hero_images();
            $recordsTotal = count($rows);
            $searchTerm = strtolower($request['search']);

            if ($searchTerm !== '') {
                $rows = array_values(array_filter($rows, static function (array $row) use ($searchTerm): bool {
                    $haystack = strtolower(implode(' ', [
                        (string) $row['label'],
                        (string) $row['image_path'],
                        $row['is_default'] ? 'Default image' : 'Uploaded image',
                    ]));
                    return str_contains($haystack, $searchTerm);
                }));
            }

            $recordsFiltered = count($rows);
            $heroOrderColumns = ['label', 'image_path', 'status'];
            $heroOrderColumn = $heroOrderColumns[$request['order_column']] ?? 'label';
            usort($rows, static function (array $left, array $right) use ($heroOrderColumn, $request): int {
                $leftValue = $heroOrderColumn === 'status'
                    ? ($left['is_default'] ? 'Default image' : 'Uploaded image')
                    : (string) $left[$heroOrderColumn];
                $rightValue = $heroOrderColumn === 'status'
                    ? ($right['is_default'] ? 'Default image' : 'Uploaded image')
                    : (string) $right[$heroOrderColumn];
                $comparison = strnatcasecmp($leftValue, $rightValue);
                return $request['order_direction'] === 'DESC' ? -$comparison : $comparison;
            });

            $pageRows = array_slice($rows, $request['start'], $request['length']);
            $data = array_map(static fn (array $row): array => [
                'course_key' => (string) $row['course_key'],
                'course' => (string) $row['label'],
                'image_path' => (string) $row['image_path'],
                'image_url' => (string) $row['image_url'],
                'default_image_path' => (string) $row['default_image_path'],
                'status' => $row['is_default'] ? 'Default image' : 'Uploaded image',
                'is_default' => (bool) $row['is_default'],
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
    } elseif ($action === 'upload_schedule' || $action === 'delete_schedule_image') {
        $activeAdminTab = 'schedules';
    } elseif ($action === 'upload_hero' || $action === 'delete_hero') {
        $activeAdminTab = 'hero-images';
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
            if (!array_key_exists($selectedCourse, $courseScheduleOptions)) {
                throw new InvalidArgumentException('Please choose a valid course.');
            }

            $scheduleImage = $_FILES['schedule_images'] ?? null;
            $hasScheduleImage = is_array($scheduleImage)
                && array_filter((array) ($scheduleImage['error'] ?? []), static fn ($error): bool => (int) $error !== UPLOAD_ERR_NO_FILE) !== [];
            if ($hasScheduleImage) {
                save_course_schedule_images($selectedCourse, $scheduleImage);
            }

            $scheduleText = (string) ($_POST['schedule_text'] ?? '');
            save_course_schedule_custom_text($selectedCourse, $scheduleText);
            $feedback = 'Upcoming schedule settings saved for ' . $courseScheduleOptions[$selectedCourse] . '.';

            if (strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest') {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['ok' => true, 'message' => $feedback], JSON_UNESCAPED_SLASHES);
                exit;
            }
        } elseif ($action === 'upload_hero') {
            $selectedCourse = trim((string) ($_POST['hero_course'] ?? ''));
            if (!isset($_FILES['hero_image']) || !is_array($_FILES['hero_image'])) {
                throw new InvalidArgumentException('Please choose a course hero image to upload.');
            }

            save_course_hero_image($selectedCourse, $_FILES['hero_image']);
            $feedback = 'Hero image updated for ' . ($courseHeroOptions[$selectedCourse] ?? strtoupper($selectedCourse)) . '.';
        } elseif ($action === 'delete_schedule_image') {
            $selectedCourse = trim((string) ($_POST['schedule_course'] ?? ''));
            $deleted = delete_course_schedule_image($selectedCourse);
            $feedback = $deleted
                ? 'Uploaded schedule image removed. The default image is active again.'
                : 'The default schedule image is already active.';
        } elseif ($action === 'delete_hero') {
            $selectedCourse = trim((string) ($_POST['hero_course'] ?? ''));
            $deleted = delete_course_hero_image($selectedCourse);
            $feedback = $deleted
                ? 'Uploaded hero image removed. The original course image is active again.'
                : 'The original course hero image is already active.';
        }

        if (in_array($action, ['upload_schedule', 'upload_hero', 'delete_hero', 'delete_schedule_image'], true) && $feedback !== '') {
            $_SESSION['admin_feedback'] = $feedback;
            $redirectTab = in_array($action, ['upload_schedule', 'delete_schedule_image'], true) ? 'schedules' : 'hero-images';
            header('Location: admin-mini-lessons.php#admin-' . $redirectTab, true, 303);
            exit;
        }
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
        if ($action === 'upload_schedule' && strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest') {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(422);
            echo json_encode(['ok' => false, 'message' => $error], JSON_UNESCAPED_SLASHES);
            exit;
        }
    }
}

$testimonialGalleryFolders = get_testimonial_gallery_folders($testimonialBaseDir);

if (!is_mini_lessons_admin_logged_in()):
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin Login | Gapuz Review Academy</title>
  <link href="assets/img/favicon.png" rel="icon" type="image/png">
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
  <link href="assets/img/favicon.png" rel="icon" type="image/png">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo versioned_asset('assets/css/gra-content.css'); ?>" rel="stylesheet">
  <style>
    .admin-data-table-wrap .dt-container .dt-search input,
    .admin-data-table-wrap .dt-container .dt-length select { border: 1px solid #ced4da; border-radius: .375rem; background-color: #fff; }
    .admin-data-table-wrap .dt-container .dt-search input { min-width: min(260px, 60vw); padding: .45rem .7rem; }
    .admin-data-table-wrap .dt-container .dt-length select { padding: .35rem 2rem .35rem .55rem; }
    .admin-data-table-wrap table.dataTable tbody td { vertical-align: middle; }
    #saved-lessons-table tbody td { vertical-align: top; }
    .admin-data-table-wrap .lesson-url { display: inline-block; max-width: 360px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; vertical-align: middle; }
    .admin-data-table-wrap .lesson-title-column { min-width: 420px; width: 52%; }
    .lesson-title-cell strong { display: block; color: #173c59; font-size: 1rem; line-height: 1.45; }
    .lesson-title-cell .lesson-description { margin: .45rem 0 0; color: #343a40; font-size: .92rem; font-weight: 400; line-height: 1.55; white-space: pre-line; }
    .lesson-title-cell hr { margin: .65rem 0; border-color: #d8e1e9; opacity: 1; }
    .lesson-title-cell .lesson-url { max-width: 100%; font-size: .86rem; }
    .lesson-action-buttons { display: flex; flex-wrap: wrap; gap: .4rem; }
    .admin-image-preview { display: block; width: 150px; max-width: 100%; height: 90px; border: 1px solid #d8e1e9; border-radius: .5rem; background: #eef2f5; object-fit: contain; }
    .schedule-text-preview { max-width: 360px; margin: 0; overflow: hidden; color: #343a40; font-size: .86rem; line-height: 1.45; white-space: pre-line; }
    .schedule-rich-editor { min-height: 260px; background: #fff; font-family: var(--default-font); font-size: 1rem; }
    .schedule-rich-editor .ql-editor { min-height: 260px; }
    .schedule-rich-editor + .form-text { margin-top: .5rem; }
    .testimonial-gallery-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1rem; }
    .testimonial-gallery-card { display: flex; min-width: 0; flex-direction: column; overflow: hidden; border: 1px solid #d8e1e9; border-radius: .65rem; background: #fff; }
    .testimonial-gallery-card img { display: block; width: 100%; aspect-ratio: 4 / 3; object-fit: cover; background: #eef2f5; }
    .testimonial-gallery-card-body { display: flex; flex: 1; flex-direction: column; gap: .65rem; padding: .75rem; }
    .testimonial-gallery-filename { margin: 0; overflow-wrap: anywhere; color: #343a40; font-size: .82rem; line-height: 1.4; }
    .testimonial-gallery-card .btn { margin-top: auto; align-self: flex-start; }
    .testimonial-gallery-status { min-height: 1.5rem; }
    .testimonial-gallery-pagination { display: flex; align-items: center; justify-content: center; gap: .75rem; margin-top: 1.25rem; }
    .admin-tabs { display: flex; gap: .5rem; margin-bottom: 1.5rem; padding: .45rem; overflow-x: auto; border: 1px solid #d8e1e9; border-radius: .75rem; background: #fff; }
    .admin-tab-button { flex: 1 0 auto; min-height: 44px; padding: .65rem 1rem; border: 0; border-radius: .5rem; background: transparent; color: #003057; font-weight: 750; white-space: nowrap; }
    .admin-tab-button:hover { background: #eef5fb; }
    .admin-tab-button.active { background: #003057; color: #fff; box-shadow: 0 5px 14px rgba(0, 48, 87, .18); }
    .admin-tab-button:focus-visible { outline: 3px solid rgba(242, 101, 34, .35); outline-offset: 2px; }
    @media (max-width: 767.98px) {
      .admin-data-table-wrap .dt-container .dt-layout-row { gap: .75rem; align-items: stretch; }
      .admin-data-table-wrap .dt-container .dt-search input { min-width: 0; width: 100%; margin: .35rem 0 0; }
      .testimonial-gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 479.98px) { .testimonial-gallery-grid { grid-template-columns: 1fr; } }
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
      <p>Manage mini lessons, testimonials, course hero images, and upcoming schedules.</p>
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
      <button id="admin-tab-hero-images" class="admin-tab-button" type="button" role="tab" aria-selected="false" aria-controls="admin-panel-hero-images" data-admin-tab="hero-images" tabindex="-1">Hero Images</button>
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

      <hr class="my-4">
      <section aria-labelledby="testimonial-gallery-heading">
        <h3 id="testimonial-gallery-heading" class="h5">Manage Uploaded Testimonials</h3>
        <div class="row align-items-end mb-3">
          <div class="col-md-6">
            <label for="testimonial-gallery-folder" class="form-label">Passer Folder</label>
            <select id="testimonial-gallery-folder" class="form-select">
              <option value="">Select folder to view images</option>
              <?php foreach ($testimonialGalleryFolders as $folderName): ?>
                <option value="<?php echo htmlspecialchars($folderName, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($testimonialFolderOptions[$folderName] ?? ucwords(str_replace(['-', '_'], ' ', $folderName)), ENT_QUOTES, 'UTF-8'); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div id="testimonial-gallery-status" class="testimonial-gallery-status text-muted" role="status" aria-live="polite">Select a folder to load its images.</div>
        <div id="testimonial-gallery-grid" class="testimonial-gallery-grid mt-3"></div>
        <nav id="testimonial-gallery-pagination" class="testimonial-gallery-pagination" aria-label="Testimonial image pages" hidden>
          <button id="testimonial-gallery-previous" type="button" class="btn btn-outline-primary">Previous</button>
          <span id="testimonial-gallery-page" aria-live="polite"></span>
          <button id="testimonial-gallery-next" type="button" class="btn btn-outline-primary">Next</button>
        </nav>
      </section>
    </section>

    <section id="admin-panel-hero-images" class="mb-4 p-3 border rounded bg-white" role="tabpanel" aria-labelledby="admin-tab-hero-images" data-admin-panel="hero-images" hidden>
      <h3 class="h5">Upload Course Hero Image</h3>
      <p class="mb-3">Choose a course and upload a replacement for its current hero image. Removing an uploaded image restores the original automatically.</p>
      <form method="post" action="admin-mini-lessons.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload_hero">
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="hero_course" class="form-label">Course</label>
            <select id="hero_course" name="hero_course" class="form-select" required>
              <option value="">Select course</option>
              <?php foreach ($courseHeroOptions as $courseKey => $courseLabel): ?>
                <option value="<?php echo htmlspecialchars($courseKey, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($courseLabel, ENT_QUOTES, 'UTF-8'); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-8 mb-3">
            <label for="hero_image" class="form-label">Hero Image</label>
            <input id="hero_image" name="hero_image" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif" required>
            <div class="form-text">Allowed formats: JPG, JPEG, PNG, WEBP, GIF (max 8MB).</div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Upload Hero Image</button>
      </form>
    </section>

    <section id="admin-panel-schedules" class="mb-4 p-3 border rounded bg-white" role="tabpanel" aria-labelledby="admin-tab-schedules" data-admin-panel="schedules" hidden>
      <h3 class="h5">Upcoming Schedule Settings</h3>
      <p class="mb-3">Upload one or more schedule images for each course. Uploaded images are added to its carousel. Leave the text blank to use the current default content.</p>
      <form id="schedule-settings-form" method="post" action="admin-mini-lessons.php" enctype="multipart/form-data">
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
            <label for="schedule_images" class="form-label">Upcoming Schedule Images</label>
            <input id="schedule_images" name="schedule_images[]" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif" multiple>
            <div class="form-text">Optional. Select multiple images if needed. Each image can be up to 8MB.</div>
          </div>
        </div>
        <div class="mb-3">
          <label for="schedule_text_editor" class="form-label">Right Column Content</label>
          <textarea id="schedule_text" name="schedule_text" class="form-control" rows="10" placeholder="Enter optional schedule content for the selected course..."></textarea>
          <div id="schedule_text_editor" class="schedule-rich-editor" hidden></div>
          <div class="form-text">Format headings, fonts, sizes, links, alignment, and ordered or unordered lists. Clear the editor and save to restore the default content.</div>
        </div>
        <button type="submit" class="btn btn-primary">Save Schedule Settings</button>
      </form>
    </section>

    <section class="mt-4 p-3 border rounded bg-white admin-data-table-wrap" role="tabpanel" aria-labelledby="admin-tab-hero-images" data-admin-panel="hero-images" hidden>
      <h3 class="h5">Current Course Hero Images</h3>
      <div class="table-responsive">
        <table id="hero-images-table" class="table align-middle w-100">
          <thead>
            <tr>
              <th>Course</th>
              <th>Current Image</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <noscript><p class="alert alert-warning mt-3 mb-0">JavaScript is required to view course hero images.</p></noscript>
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
              <th>Right Column Text</th>
              <th>Status</th>
              <th>Action</th>
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
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  <script>
    (() => {
      const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;'
      })[character]);
      const htmlToPlainText = (value) => {
        const container = document.createElement('div');
        container.innerHTML = String(value ?? '');
        return container.textContent || '';
      };

      const testimonialCsrfToken = <?php echo json_encode($testimonialCsrfToken, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
      const testimonialGalleryFolder = document.getElementById('testimonial-gallery-folder');
      const testimonialGalleryStatus = document.getElementById('testimonial-gallery-status');
      const testimonialGalleryGrid = document.getElementById('testimonial-gallery-grid');
      const testimonialGalleryPagination = document.getElementById('testimonial-gallery-pagination');
      const testimonialGalleryPrevious = document.getElementById('testimonial-gallery-previous');
      const testimonialGalleryNext = document.getElementById('testimonial-gallery-next');
      const testimonialGalleryPage = document.getElementById('testimonial-gallery-page');
      const testimonialLightbox = GLightbox({ elements: [] });
      let testimonialCurrentPage = 1;
      let testimonialTotalPages = 1;
      let testimonialGalleryRequest = null;

      const loadTestimonialGallery = async (page = 1) => {
        const folder = testimonialGalleryFolder.value;
        if (!folder) {
          testimonialGalleryGrid.replaceChildren();
          testimonialGalleryPagination.hidden = true;
          testimonialGalleryStatus.textContent = 'Select a folder to load its images.';
          return;
        }

        if (testimonialGalleryRequest) testimonialGalleryRequest.abort();
        testimonialGalleryRequest = new AbortController();
        testimonialGalleryStatus.textContent = 'Loading images…';
        testimonialGalleryGrid.setAttribute('aria-busy', 'true');

        try {
          const parameters = new URLSearchParams({ ajax_testimonials: '1', folder, page: String(page) });
          const response = await fetch(`admin-mini-lessons.php?${parameters}`, {
            credentials: 'same-origin',
            signal: testimonialGalleryRequest.signal
          });
          const result = await response.json();
          if (!response.ok || result.error) throw new Error(result.error || 'Unable to load testimonial images.');

          testimonialCurrentPage = result.page;
          testimonialTotalPages = result.total_pages;
          testimonialGalleryGrid.innerHTML = result.images.map((image) => `
            <article class="testimonial-gallery-card">
              <a href="${escapeHtml(image.url)}" data-testimonial-lightbox data-title="${escapeHtml(image.filename)}">
                <img src="${escapeHtml(image.url)}" alt="${escapeHtml(image.filename)}" loading="lazy" decoding="async">
              </a>
              <div class="testimonial-gallery-card-body">
                <p class="testimonial-gallery-filename">${escapeHtml(image.filename)}</p>
                <button type="button" class="btn btn-sm btn-outline-danger" data-delete-testimonial="${escapeHtml(image.filename)}">Delete</button>
              </div>
            </article>`).join('');

          testimonialGalleryStatus.textContent = result.total === 0
            ? 'No testimonial images found in this folder.'
            : `Showing ${result.images.length} of ${result.total} image${result.total === 1 ? '' : 's'}.`;
          testimonialGalleryPage.textContent = `Page ${result.page} of ${result.total_pages}`;
          testimonialGalleryPrevious.disabled = result.page <= 1;
          testimonialGalleryNext.disabled = result.page >= result.total_pages;
          testimonialGalleryPagination.hidden = result.total === 0;
        } catch (error) {
          if (error.name === 'AbortError') return;
          testimonialGalleryGrid.replaceChildren();
          testimonialGalleryPagination.hidden = true;
          testimonialGalleryStatus.textContent = error.message || 'Unable to load testimonial images.';
        } finally {
          testimonialGalleryGrid.removeAttribute('aria-busy');
        }
      };

      testimonialGalleryFolder.addEventListener('change', () => loadTestimonialGallery(1));
      testimonialGalleryPrevious.addEventListener('click', () => loadTestimonialGallery(Math.max(1, testimonialCurrentPage - 1)));
      testimonialGalleryNext.addEventListener('click', () => loadTestimonialGallery(Math.min(testimonialTotalPages, testimonialCurrentPage + 1)));

      testimonialGalleryGrid.addEventListener('click', async (event) => {
        const imageTrigger = event.target.closest('[data-testimonial-lightbox]');
        if (imageTrigger) {
          event.preventDefault();
          const imageTriggers = Array.from(testimonialGalleryGrid.querySelectorAll('[data-testimonial-lightbox]'));
          testimonialLightbox.setElements(imageTriggers.map((trigger) => ({
            href: trigger.href,
            type: 'image',
            title: trigger.dataset.title || ''
          })));
          testimonialLightbox.openAt(Math.max(0, imageTriggers.indexOf(imageTrigger)));
          return;
        }

        const deleteButton = event.target.closest('[data-delete-testimonial]');
        if (!deleteButton) return;

        const filename = deleteButton.dataset.deleteTestimonial;
        const folder = testimonialGalleryFolder.value;
        if (!window.confirm(`Delete ${filename}? This cannot be undone.`)) return;

        deleteButton.disabled = true;
        deleteButton.textContent = 'Deleting…';
        try {
          const formData = new FormData();
          formData.set('ajax_action', 'delete_testimonial');
          formData.set('csrf_token', testimonialCsrfToken);
          formData.set('folder', folder);
          formData.set('filename', filename);
          const response = await fetch('admin-mini-lessons.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
          });
          const result = await response.json();
          if (!response.ok || result.error) throw new Error(result.error || 'Unable to delete testimonial image.');
          testimonialGalleryStatus.textContent = result.message;
          await loadTestimonialGallery(testimonialCurrentPage);
        } catch (error) {
          testimonialGalleryStatus.textContent = error.message || 'Unable to delete testimonial image.';
          deleteButton.disabled = false;
          deleteButton.textContent = 'Delete';
        }
      });

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
            render: (data, type, row) => type === 'display'
              ? `<a class="lesson-url" href="${escapeHtml(data)}" target="_blank" rel="noopener">${escapeHtml(data)}</a><div class="small text-muted mt-1">${Number(row.image_count)} image${Number(row.image_count) === 1 ? '' : 's'}</div>`
              : data
          },
          {
            data: 'custom_text',
            orderable: false,
            render: (data, type, row) => type === 'display'
              ? (row.has_custom_text
                ? `<p class="schedule-text-preview">${escapeHtml(htmlToPlainText(data))}</p>`
                : '<span class="text-muted small">Using default content</span>')
              : data
          },
          {
            data: 'status',
            render: (data, type, row) => type === 'display'
              ? `<div class="d-flex flex-wrap gap-1"><span class="badge text-bg-secondary">${escapeHtml(data)}</span><span class="badge ${row.has_custom_text ? 'text-bg-success' : 'text-bg-secondary'}">${row.has_custom_text ? 'Custom text' : 'Default text'}</span></div>`
              : data
          },
          {
            data: 'course_key',
            orderable: false,
            searchable: false,
            render: (data, type, row) => {
              if (type !== 'display') return data;
              const editButton = `<button type="button" class="btn btn-sm btn-outline-primary" data-edit-schedule="${escapeHtml(data)}">Edit Settings</button>`;
              if (row.is_default) return editButton;
              const restoreForm = `<form method="post" action="admin-mini-lessons.php" onsubmit="return confirm('Remove all uploaded schedule images and restore the default?');"><input type="hidden" name="action" value="delete_schedule_image"><input type="hidden" name="schedule_course" value="${escapeHtml(data)}"><button type="submit" class="btn btn-sm btn-outline-danger">Remove All Images &amp; Restore Default</button></form>`;
              return `<div class="lesson-action-buttons">${editButton}${restoreForm}</div>`;
            }
          }
        ]
      });

      const heroImagesTable = new DataTable('#hero-images-table', {
        processing: true,
        serverSide: true,
        ajax: 'admin-mini-lessons.php?ajax_table=hero-images',
        pageLength: 10,
        lengthMenu: [10, 25, 50],
        searchDelay: 350,
        order: [[0, 'asc']],
        language: {
          search: 'Quick search:',
          emptyTable: 'No course hero images found.',
          zeroRecords: 'No matching course hero images found.'
        },
        columns: [
          { data: 'course', render: (data) => escapeHtml(data) },
          {
            data: 'image_url',
            orderable: false,
            searchable: false,
            render: (data, type, row) => type === 'display'
              ? `<a href="${escapeHtml(data)}" target="_blank" rel="noopener" title="View ${escapeHtml(row.course)} hero image"><img class="admin-image-preview" src="${escapeHtml(data)}" alt="${escapeHtml(row.course)} hero image" loading="lazy" decoding="async"></a>`
              : data
          },
          {
            data: 'status',
            render: (data, type, row) => type === 'display'
              ? `<span class="badge ${row.is_default ? 'text-bg-secondary' : 'text-bg-success'}">${escapeHtml(data)}</span>`
              : data
          },
          {
            data: 'course_key',
            orderable: false,
            searchable: false,
            render: (data, type, row) => {
              if (type !== 'display') return data;
              if (row.is_default) return '<span class="text-muted small">Original active</span>';
              return `<form method="post" action="admin-mini-lessons.php" onsubmit="return confirm('Remove this uploaded hero image and restore the original?');"><input type="hidden" name="action" value="delete_hero"><input type="hidden" name="hero_course" value="${escapeHtml(data)}"><button type="submit" class="btn btn-sm btn-outline-danger">Remove &amp; Restore Default</button></form>`;
            }
          }
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
      const scheduleCourse = document.getElementById('schedule_course');
      const scheduleText = document.getElementById('schedule_text');
      const scheduleForm = document.getElementById('schedule-settings-form');
      const scheduleEditorElement = document.getElementById('schedule_text_editor');
      let scheduleEditor = null;

      if (typeof Quill !== 'undefined') {
        scheduleEditorElement.hidden = false;
        scheduleText.hidden = true;
        scheduleEditor = new Quill(scheduleEditorElement, {
          theme: 'snow',
          placeholder: 'Enter optional schedule content for the selected course...',
          modules: {
            toolbar: [
              [{ header: [2, 3, 4, false] }, { font: [] }, { size: ['small', false, 'large', 'huge'] }],
              ['bold', 'italic', 'underline', 'strike'],
              [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
              [{ align: [] }],
              ['blockquote', 'link'],
              ['clean']
            ]
          }
        });
      }

      const loadScheduleTextForCourse = (courseKey) => {
        const schedule = scheduleTable.rows().data().toArray().find((row) => row.course_key === courseKey);
        scheduleText.value = schedule?.custom_text || '';
        if (scheduleEditor) {
          scheduleEditor.setText('');
          if (scheduleText.value) scheduleEditor.clipboard.dangerouslyPasteHTML(scheduleText.value);
        }
      };

      scheduleCourse.addEventListener('change', () => loadScheduleTextForCourse(scheduleCourse.value));
      scheduleForm.addEventListener('submit', async (event) => {
        if (scheduleEditor) {
          scheduleText.value = scheduleEditor.getText().trim() === ''
            ? ''
            : (typeof scheduleEditor.getSemanticHTML === 'function'
              ? scheduleEditor.getSemanticHTML()
              : scheduleEditor.root.innerHTML);
        }

        const imageInput = document.getElementById('schedule_images');
        const selectedImages = Array.from(imageInput?.files || []);
        if (selectedImages.length === 0) return;

        event.preventDefault();
        const submitButton = scheduleForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.textContent;
        submitButton.disabled = true;

        try {
          for (let index = 0; index < selectedImages.length; index += 1) {
            submitButton.textContent = `Uploading image ${index + 1} of ${selectedImages.length}...`;
            const uploadData = new FormData(scheduleForm);
            uploadData.delete('schedule_images[]');
            uploadData.append('schedule_images[]', selectedImages[index], selectedImages[index].name);
            const response = await fetch('admin-mini-lessons.php', {
              method: 'POST',
              body: uploadData,
              headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
            });
            const result = await response.json().catch(() => null);
            if (!response.ok || !result?.ok) {
              throw new Error(result?.message || `Image ${index + 1} could not be uploaded.`);
            }
          }
          window.location.href = 'admin-mini-lessons.php?upload_complete=1#admin-schedules';
        } catch (uploadError) {
          submitButton.disabled = false;
          submitButton.textContent = originalButtonText;
          window.alert(uploadError.message || 'The schedule images could not be uploaded.');
          scheduleTable.ajax.reload(null, false);
        }
      });

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
          if (selectedTab === 'hero-images') heroImagesTable.columns.adjust();
        });

        if (updateHash && window.history.replaceState) {
          window.history.replaceState(null, '', `#admin-${selectedTab}`);
        }
      };

      tabButtons.forEach((button) => button.addEventListener('click', () => {
        activateAdminTab(button.dataset.adminTab, true);
      }));

      document.addEventListener('click', (event) => {
        const scheduleButton = event.target.closest('[data-edit-schedule]');
        if (scheduleButton) {
          scheduleCourse.value = scheduleButton.dataset.editSchedule;
          loadScheduleTextForCourse(scheduleCourse.value);
          activateAdminTab('schedules', true);
          document.getElementById('admin-panel-schedules').scrollIntoView({ behavior: 'smooth', block: 'start' });
          if (scheduleEditor) scheduleEditor.focus();
          else scheduleText.focus({ preventScroll: true });
          return;
        }

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


