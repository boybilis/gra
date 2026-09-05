<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';

function get_course_schedule_options(): array
{
    return [
        'nclex' => 'NCLEX',
        'dha' => 'DHA',
        'haad-doh' => 'HAAD / DOH',
        'prometric' => 'Prometric',
        'pnle' => 'PNLE',
        'sple' => 'SPLE',
        'civil-service' => 'Civil Service',
        'lept' => 'LEPT',
    ];
}

function normalize_course_schedule_key(?string $course): string
{
    $course = strtolower(trim((string) $course));
    $options = get_course_schedule_options();

    if (!array_key_exists($course, $options)) {
        throw new InvalidArgumentException('Invalid course selected.');
    }

    return $course;
}

function ensure_course_schedule_images_table(PDO $database): void
{
    $database->exec(
        'CREATE TABLE IF NOT EXISTS course_schedule_images (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            course_key VARCHAR(50) NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY uniq_course_key (course_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
}

function ensure_course_schedule_content_table(PDO $database): void
{
    $database->exec(
        'CREATE TABLE IF NOT EXISTS course_schedule_content (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            course_key VARCHAR(50) NOT NULL,
            custom_text LONGTEXT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY uniq_schedule_content_course (course_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
}

function get_course_schedule_custom_text(string $course): string
{
    $courseKey = normalize_course_schedule_key($course);
    $database = get_database();
    ensure_course_schedule_content_table($database);

    $statement = $database->prepare(
        'SELECT custom_text
         FROM course_schedule_content
         WHERE course_key = :course_key
         LIMIT 1'
    );
    $statement->execute([':course_key' => $courseKey]);
    $row = $statement->fetch();

    return is_array($row) ? trim((string) ($row['custom_text'] ?? '')) : '';
}

function save_course_schedule_custom_text(string $course, string $customText): void
{
    $courseKey = normalize_course_schedule_key($course);
    $customText = trim(str_replace(["\r\n", "\r"], "\n", $customText));
    $database = get_database();
    ensure_course_schedule_content_table($database);

    if ($customText === '') {
        $statement = $database->prepare('DELETE FROM course_schedule_content WHERE course_key = :course_key');
        $statement->execute([':course_key' => $courseKey]);
        return;
    }

    $statement = $database->prepare(
        'INSERT INTO course_schedule_content (course_key, custom_text)
         VALUES (:course_key, :custom_text)
         ON DUPLICATE KEY UPDATE custom_text = VALUES(custom_text)'
    );
    $statement->execute([
        ':course_key' => $courseKey,
        ':custom_text' => $customText,
    ]);
}

function get_default_course_schedule_image(): string
{
    return 'assets/img/gra/artemis-platform.jpg';
}

function get_course_schedule_image(string $course): array
{
    $courseKey = normalize_course_schedule_key($course);
    $database = get_database();
    ensure_course_schedule_images_table($database);

    $statement = $database->prepare(
        'SELECT image_path
         FROM course_schedule_images
         WHERE course_key = :course_key
         LIMIT 1'
    );
    $statement->execute([':course_key' => $courseKey]);
    $row = $statement->fetch();

    $imagePath = get_default_course_schedule_image();
    if (is_array($row) && !empty($row['image_path'])) {
        $candidate = (string) $row['image_path'];
        $absolutePath = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $candidate);
        if (is_file($absolutePath)) {
            $imagePath = $candidate;
        }
    }

    $customText = get_course_schedule_custom_text($courseKey);

    return [
        'course_key' => $courseKey,
        'label' => get_course_schedule_options()[$courseKey],
        'image_path' => $imagePath,
        'is_default' => $imagePath === get_default_course_schedule_image(),
        'custom_text' => $customText,
        'has_custom_text' => $customText !== '',
    ];
}

function get_all_course_schedule_images(): array
{
    $options = get_course_schedule_options();
    $images = [];

    foreach ($options as $courseKey => $_label) {
        $images[] = get_course_schedule_image($courseKey);
    }

    return $images;
}

function save_course_schedule_image(string $course, array $file): void
{
    $courseKey = normalize_course_schedule_key($course);

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $maxFileSizeBytes = 8 * 1024 * 1024;
    $uploadError = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($uploadError !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Please choose a valid image to upload.');
    }

    $tmpPath = (string) ($file['tmp_name'] ?? '');
    $fileSize = (int) ($file['size'] ?? 0);
    if ($tmpPath === '' || !is_uploaded_file($tmpPath) || $fileSize <= 0 || $fileSize > $maxFileSizeBytes) {
        throw new RuntimeException('The uploaded image is invalid or too large.');
    }

    $originalName = (string) ($file['name'] ?? '');
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true)) {
        throw new RuntimeException('Allowed formats: JPG, JPEG, PNG, WEBP, GIF.');
    }

    $relativeDirectory = 'assets/img/gra/upcoming';
    $targetDir = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'gra' . DIRECTORY_SEPARATOR . 'upcoming';
    if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
        throw new RuntimeException('Unable to create upcoming schedule upload folder.');
    }

    $targetFilename = $courseKey . '-schedule.' . $extension;
    $relativePath = $relativeDirectory . '/' . $targetFilename;
    $targetPath = $targetDir . DIRECTORY_SEPARATOR . $targetFilename;

    $database = get_database();
    ensure_course_schedule_images_table($database);

    $existing = get_course_schedule_image($courseKey);
    if (!move_uploaded_file($tmpPath, $targetPath)) {
        throw new RuntimeException('Unable to save the uploaded image.');
    }

    $statement = $database->prepare(
        'INSERT INTO course_schedule_images (course_key, image_path)
         VALUES (:course_key, :image_path)
         ON DUPLICATE KEY UPDATE image_path = VALUES(image_path)'
    );
    $statement->execute([
        ':course_key' => $courseKey,
        ':image_path' => $relativePath,
    ]);

    if (!$existing['is_default'] && $existing['image_path'] !== $relativePath) {
        $oldAbsolutePath = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $existing['image_path']);
        if (is_file($oldAbsolutePath)) {
            @unlink($oldAbsolutePath);
        }
    }
}
