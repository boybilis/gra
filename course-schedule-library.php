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

function ensure_course_schedule_gallery_images_table(PDO $database): void
{
    $database->exec(
        'CREATE TABLE IF NOT EXISTS course_schedule_gallery_images (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            course_key VARCHAR(50) NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY uniq_schedule_gallery_path (image_path),
            KEY idx_schedule_gallery_course (course_key, id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
}

function sanitize_course_schedule_html(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }

    if (!preg_match('/<\/?[a-z][^>]*>/i', $html)) {
        $escaped = htmlspecialchars(str_replace(["\r\n", "\r"], "\n", $html), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        return '<p>' . str_replace(["\n\n", "\n"], ['</p><p>', '<br>'], $escaped) . '</p>';
    }

    $document = new DOMDocument('1.0', 'UTF-8');
    $previousErrors = libxml_use_internal_errors(true);
    $document->loadHTML(
        '<?xml encoding="utf-8" ?><div id="course-schedule-content">' . $html . '</div>',
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
    );
    libxml_clear_errors();
    libxml_use_internal_errors($previousErrors);

    $root = $document->getElementById('course-schedule-content');
    if (!$root instanceof DOMElement) {
        return '';
    }

    $allowedTags = ['p', 'br', 'h2', 'h3', 'h4', 'h5', 'h6', 'strong', 'b', 'em', 'i', 'u', 's', 'sub', 'sup', 'blockquote', 'ol', 'ul', 'li', 'a', 'span'];
    $allowedClassPattern = '/^ql-(?:align-(?:center|right|justify)|indent-[1-8]|font-(?:serif|monospace)|size-(?:small|large|huge)|direction-rtl)$/';

    $cleanNode = static function (DOMNode $parent) use (&$cleanNode, $allowedTags, $allowedClassPattern): void {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if (!$node instanceof DOMElement) {
                continue;
            }

            $tag = strtolower($node->tagName);
            if (!in_array($tag, $allowedTags, true)) {
                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed'], true)) {
                    $parent->removeChild($node);
                    continue;
                }
                while ($node->firstChild !== null) {
                    $parent->insertBefore($node->firstChild, $node);
                }
                $parent->removeChild($node);
                continue;
            }

            foreach (iterator_to_array($node->attributes) as $attribute) {
                $name = strtolower($attribute->name);
                $value = trim($attribute->value);
                $keep = false;

                if ($name === 'class') {
                    $classes = array_values(array_filter(
                        preg_split('/\s+/', $value) ?: [],
                        static fn(string $class): bool => preg_match($allowedClassPattern, $class) === 1
                    ));
                    if ($classes !== []) {
                        $node->setAttribute('class', implode(' ', $classes));
                        $keep = true;
                    }
                } elseif ($tag === 'li' && $name === 'data-list' && in_array($value, ['ordered', 'bullet'], true)) {
                    $keep = true;
                } elseif ($tag === 'a' && $name === 'href' && preg_match('/^(?:https?:|mailto:|tel:|\/|#)/i', $value)) {
                    $keep = true;
                }

                if (!$keep) {
                    $node->removeAttribute($attribute->name);
                }
            }

            if ($tag === 'a' && $node->hasAttribute('href')) {
                $node->setAttribute('target', '_blank');
                $node->setAttribute('rel', 'noopener noreferrer');
            }

            $cleanNode($node);
        }
    };

    $cleanNode($root);

    $result = '';
    foreach ($root->childNodes as $child) {
        $result .= $document->saveHTML($child);
    }

    return trim($result);
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

    return is_array($row) ? sanitize_course_schedule_html((string) ($row['custom_text'] ?? '')) : '';
}

function save_course_schedule_custom_text(string $course, string $customText): void
{
    $courseKey = normalize_course_schedule_key($course);
    $customText = sanitize_course_schedule_html($customText);
    if (trim(html_entity_decode(strip_tags($customText), ENT_QUOTES | ENT_HTML5, 'UTF-8')) === '') {
        $customText = '';
    }
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
    ensure_course_schedule_gallery_images_table($database);
    $images = [];

    $statement = $database->prepare('SELECT image_path FROM course_schedule_images WHERE course_key = :course_key LIMIT 1');
    $statement->execute([':course_key' => $courseKey]);
    $legacyRow = $statement->fetch();
    if (is_array($legacyRow)) {
        $candidate = (string) ($legacyRow['image_path'] ?? '');
        if ($candidate !== '' && is_file(__DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $candidate))) {
            $images[] = $candidate;
        }
    }

    $statement = $database->prepare('SELECT image_path FROM course_schedule_gallery_images WHERE course_key = :course_key ORDER BY id ASC');
    $statement->execute([':course_key' => $courseKey]);
    foreach ($statement->fetchAll() as $row) {
        $candidate = (string) ($row['image_path'] ?? '');
        if ($candidate !== '' && !in_array($candidate, $images, true)
            && is_file(__DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $candidate))) {
            $images[] = $candidate;
        }
    }

    $isDefault = $images === [];
    if ($isDefault) $images[] = get_default_course_schedule_image();
    $customText = get_course_schedule_custom_text($courseKey);

    return [
        'course_key' => $courseKey,
        'label' => get_course_schedule_options()[$courseKey],
        'image_path' => $images[0],
        'images' => $images,
        'image_count' => count($images),
        'is_default' => $isDefault,
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

function normalize_course_schedule_uploads(array $files): array
{
    if (!isset($files['name']) || !is_array($files['name'])) return [$files];
    $uploads = [];
    foreach ($files['name'] as $index => $name) {
        $uploads[] = [
            'name' => $name,
            'type' => $files['type'][$index] ?? '',
            'tmp_name' => $files['tmp_name'][$index] ?? '',
            'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
            'size' => $files['size'][$index] ?? 0,
        ];
    }
    return $uploads;
}

function save_course_schedule_images(string $course, array $files): int
{
    $courseKey = normalize_course_schedule_key($course);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $targetDir = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'gra' . DIRECTORY_SEPARATOR . 'upcoming';
    if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
        throw new RuntimeException('Unable to create upcoming schedule upload folder.');
    }
    $database = get_database();
    ensure_course_schedule_gallery_images_table($database);
    $insert = $database->prepare('INSERT INTO course_schedule_gallery_images (course_key, image_path) VALUES (:course_key, :image_path)');
    $savedCount = 0;

    foreach (normalize_course_schedule_uploads($files) as $file) {
        $error = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) continue;
        if ($error !== UPLOAD_ERR_OK) throw new RuntimeException('One of the selected images could not be uploaded.');
        $tmpPath = (string) ($file['tmp_name'] ?? '');
        $size = (int) ($file['size'] ?? 0);
        $extension = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        if ($tmpPath === '' || !is_uploaded_file($tmpPath) || $size <= 0 || $size > 8 * 1024 * 1024) {
            throw new RuntimeException('One of the selected images is invalid or larger than 8MB.');
        }
        if (!in_array($extension, $allowedExtensions, true)) {
            throw new RuntimeException('Allowed formats: JPG, JPEG, PNG, WEBP, GIF.');
        }

        $filename = $courseKey . '-schedule-' . date('YmdHis') . '-' . bin2hex(random_bytes(5)) . '.' . $extension;
        $relativePath = 'assets/img/gra/upcoming/' . $filename;
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $filename;
        if (!move_uploaded_file($tmpPath, $targetPath)) throw new RuntimeException('Unable to save one of the uploaded images.');
        try {
            $insert->execute([':course_key' => $courseKey, ':image_path' => $relativePath]);
            $savedCount++;
        } catch (Throwable $exception) {
            @unlink($targetPath);
            throw $exception;
        }
    }
    return $savedCount;
}

function delete_course_schedule_image(string $course): bool
{
    $courseKey = normalize_course_schedule_key($course);
    $database = get_database();
    ensure_course_schedule_images_table($database);
    ensure_course_schedule_gallery_images_table($database);

    $statement = $database->prepare(
        'SELECT image_path
         FROM course_schedule_images
         WHERE course_key = :course_key'
    );
    $statement->execute([':course_key' => $courseKey]);
    $rows = $statement->fetchAll();
    $gallery = $database->prepare('SELECT image_path FROM course_schedule_gallery_images WHERE course_key = :course_key');
    $gallery->execute([':course_key' => $courseKey]);
    $rows = array_merge($rows, $gallery->fetchAll());
    if ($rows === []) {
        return false;
    }
    $allowedPrefix = 'assets/img/gra/upcoming/';
    foreach ($rows as $row) {
        $imagePath = str_replace('\\', '/', (string) ($row['image_path'] ?? ''));
        if (str_starts_with($imagePath, $allowedPrefix)) {
            $absolutePath = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $imagePath);
            $uploadDirectory = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'gra' . DIRECTORY_SEPARATOR . 'upcoming');
            $resolvedImage = is_file($absolutePath) ? realpath($absolutePath) : false;
            if ($uploadDirectory !== false && $resolvedImage !== false) {
                $directoryPrefix = rtrim($uploadDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
                if (str_starts_with($resolvedImage, $directoryPrefix) && !unlink($resolvedImage)) {
                    throw new RuntimeException('Unable to remove the uploaded schedule image.');
                }
            }
        }
    }

    $delete = $database->prepare('DELETE FROM course_schedule_images WHERE course_key = :course_key');
    $delete->execute([':course_key' => $courseKey]);
    $deleteGallery = $database->prepare('DELETE FROM course_schedule_gallery_images WHERE course_key = :course_key');
    $deleteGallery->execute([':course_key' => $courseKey]);

    return $delete->rowCount() > 0 || $deleteGallery->rowCount() > 0;
}
