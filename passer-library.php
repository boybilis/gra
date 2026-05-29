<?php
declare(strict_types=1);

function get_latest_passer_images(int $limit = 8, ?string $course = null): array
{
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'gra' . DIRECTORY_SEPARATOR . 'passers';
    $baseUrl = 'assets/img/gra/passers/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $allowedCourses = ['pnle', 'nclex', 'dha', 'haad-doh', 'prometric', 'sple', 'civil-service'];
    $images = [];

    if ($course !== null) {
        $course = strtolower(trim($course));
        if (!in_array($course, $allowedCourses, true)) {
            return [];
        }
        $baseDir .= DIRECTORY_SEPARATOR . $course;
        $baseUrl .= $course . '/';
    }

    if (!is_dir($baseDir)) {
        return [];
    }

    $directory = new RecursiveDirectoryIterator($baseDir, FilesystemIterator::SKIP_DOTS);
    $iterator = new RecursiveIteratorIterator($directory);

    foreach ($iterator as $file) {
        if (!$file instanceof SplFileInfo || !$file->isFile()) {
            continue;
        }

        $extension = strtolower($file->getExtension());
        if (!in_array($extension, $allowedExtensions, true)) {
            continue;
        }

        $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($baseDir) + 1));
        $urlPath = implode('/', array_map('rawurlencode', explode('/', $relativePath)));
        $images[] = [
            'name' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
            'url' => $baseUrl . $urlPath,
            'modified' => $file->getMTime(),
        ];
    }

    usort($images, static fn (array $a, array $b): int => $b['modified'] <=> $a['modified']);

    return array_slice($images, 0, $limit);
}

function get_featured_passer_images_by_course(): array
{
    $courses = ['nclex', 'dha', 'haad-doh', 'prometric', 'sple', 'pnle', 'civil-service'];
    $images = [];

    foreach ($courses as $course) {
        $courseImages = get_latest_passer_images(1, $course);
        if (count($courseImages) === 0) {
            continue;
        }

        $courseImages[0]['course'] = $course;
        $images[] = $courseImages[0];
    }

    return $images;
}


