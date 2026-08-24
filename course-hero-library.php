<?php
declare(strict_types=1);

function get_course_hero_options(): array
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

function get_default_course_hero_images(): array
{
    return [
        'nclex' => 'assets/img/gra/nclex-course.jpg',
        'dha' => 'assets/img/gra/dha-course.jpg',
        'haad-doh' => 'assets/img/gra/doh-haad-course.png',
        'prometric' => 'assets/img/gra/prometric-course.jpg',
        'pnle' => 'assets/img/gra/pnle-course.jpg',
        'sple' => 'assets/img/gra/sple-course.jpg',
        'civil-service' => 'assets/img/gra/civil-service-course.png',
        'lept' => 'assets/img/gra/civil-service-course.png',
    ];
}

function normalize_course_hero_key(?string $course): string
{
    $courseKey = strtolower(trim((string) $course));
    if (!array_key_exists($courseKey, get_course_hero_options())) {
        throw new InvalidArgumentException('Invalid course selected.');
    }

    return $courseKey;
}

function get_course_hero_upload_directory(): string
{
    return __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'gra' . DIRECTORY_SEPARATOR . 'course-heroes';
}

function get_course_hero_override_paths(string $course): array
{
    $courseKey = normalize_course_hero_key($course);
    $relativeDirectory = 'assets/img/gra/course-heroes';
    $absoluteDirectory = get_course_hero_upload_directory();
    $paths = [];

    foreach (['webp', 'jpg', 'jpeg', 'png', 'gif'] as $extension) {
        $filename = $courseKey . '-hero.' . $extension;
        $paths[] = [
            'relative' => $relativeDirectory . '/' . $filename,
            'absolute' => $absoluteDirectory . DIRECTORY_SEPARATOR . $filename,
        ];
    }

    return $paths;
}

function get_course_hero_image(string $course): array
{
    $courseKey = normalize_course_hero_key($course);
    $defaults = get_default_course_hero_images();
    $imagePath = $defaults[$courseKey];
    $isDefault = true;

    foreach (get_course_hero_override_paths($courseKey) as $candidate) {
        if (is_file($candidate['absolute'])) {
            $imagePath = $candidate['relative'];
            $isDefault = false;
            break;
        }
    }

    $absoluteImagePath = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $imagePath);
    $imageUrl = $imagePath;
    if (is_file($absoluteImagePath)) {
        $imageUrl .= '?v=' . filemtime($absoluteImagePath);
    }

    return [
        'course_key' => $courseKey,
        'label' => get_course_hero_options()[$courseKey],
        'image_path' => $imagePath,
        'image_url' => $imageUrl,
        'default_image_path' => $defaults[$courseKey],
        'is_default' => $isDefault,
    ];
}

function get_all_course_hero_images(): array
{
    $images = [];
    foreach (array_keys(get_course_hero_options()) as $courseKey) {
        $images[] = get_course_hero_image($courseKey);
    }

    return $images;
}

function save_course_hero_image(string $course, array $file): void
{
    $courseKey = normalize_course_hero_key($course);
    $uploadError = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($uploadError !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Please choose a valid hero image to upload.');
    }

    $tmpPath = (string) ($file['tmp_name'] ?? '');
    $fileSize = (int) ($file['size'] ?? 0);
    if ($tmpPath === '' || !is_uploaded_file($tmpPath) || $fileSize <= 0 || $fileSize > 8 * 1024 * 1024) {
        throw new RuntimeException('The uploaded hero image is invalid or larger than 8MB.');
    }

    $imageInfo = @getimagesize($tmpPath);
    $mimeType = is_array($imageInfo) ? (string) ($imageInfo['mime'] ?? '') : '';
    $extensionByMime = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];
    if (!isset($extensionByMime[$mimeType])) {
        throw new RuntimeException('Allowed formats: JPG, JPEG, PNG, WEBP, GIF.');
    }

    $targetDirectory = get_course_hero_upload_directory();
    if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0775, true) && !is_dir($targetDirectory)) {
        throw new RuntimeException('Unable to create the course hero upload folder.');
    }

    $extension = $extensionByMime[$mimeType];
    $targetPath = $targetDirectory . DIRECTORY_SEPARATOR . $courseKey . '-hero.' . $extension;
    if (!move_uploaded_file($tmpPath, $targetPath)) {
        throw new RuntimeException('Unable to save the uploaded hero image.');
    }

    foreach (get_course_hero_override_paths($courseKey) as $candidate) {
        if ($candidate['absolute'] !== $targetPath && is_file($candidate['absolute'])) {
            @unlink($candidate['absolute']);
        }
    }
}

function delete_course_hero_image(string $course): bool
{
    $courseKey = normalize_course_hero_key($course);
    $deleted = false;

    foreach (get_course_hero_override_paths($courseKey) as $candidate) {
        if (is_file($candidate['absolute'])) {
            if (!unlink($candidate['absolute'])) {
                throw new RuntimeException('Unable to remove the uploaded hero image.');
            }
            $deleted = true;
        }
    }

    return $deleted;
}
