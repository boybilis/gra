<?php
declare(strict_types=1);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Method not allowed.']);
    exit;
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'campus-access.php';

$email = trim((string) ($_POST['email'] ?? ''));

if ($email === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'registered' => false, 'message' => 'Please enter your email first.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'registered' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

try {
    $registered = is_booking_email_registered($email);
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'registered' => false, 'message' => 'Unable to verify email right now.']);
    exit;
}

if (!$registered) {
    http_response_code(403);
    echo json_encode([
        'ok' => false,
        'registered' => false,
        'message' => 'Email not found in Online Campus registration. Please register first.',
    ]);
    exit;
}

echo json_encode([
    'ok' => true,
    'registered' => true,
    'message' => 'Email verified. Free resources are now unlocked.',
]);


