<?php
declare(strict_types=1);

require_once __DIR__ . '/mini-lessons-admin-auth.php';
require_once __DIR__ . '/course-schedule-library.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['ok' => false, 'message' => 'Only schedule image uploads are accepted here.']);
    exit;
}

if (!is_mini_lessons_admin_logged_in()) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'message' => 'Your admin session has expired. Please sign in again.']);
    exit;
}

try {
    $course = normalize_course_schedule_key((string) ($_POST['schedule_course'] ?? ''));
    $scheduleImage = $_FILES['schedule_images'] ?? null;
    if (!is_array($scheduleImage)) {
        throw new InvalidArgumentException('Please choose an image to upload.');
    }

    $savedCount = save_course_schedule_images($course, $scheduleImage);
    if ($savedCount < 1) {
        throw new RuntimeException('No image was received. Please choose the file again.');
    }

    save_course_schedule_custom_text($course, (string) ($_POST['schedule_text'] ?? ''));
    echo json_encode([
        'ok' => true,
        'message' => 'Schedule image uploaded successfully.',
    ], JSON_UNESCAPED_SLASHES);
} catch (Throwable $exception) {
    http_response_code(422);
    echo json_encode([
        'ok' => false,
        'message' => $exception->getMessage(),
    ], JSON_UNESCAPED_SLASHES);
}
