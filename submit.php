<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'mail_config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Exception.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'PHPMailer.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'SMTP.php';

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Method not allowed.']);
    exit;
}

function clean_value(string $key): string
{
    $value = $_POST[$key] ?? '';
    if (is_array($value)) {
        $value = implode(', ', $value);
    }
    $value = trim((string) $value);
    return preg_replace('/\s+/', ' ', $value);
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function format_label(string $key): string
{
    return ucwords(str_replace('_', ' ', $key));
}

function send_submission_email(array $submission): void
{
    $mail = new PHPMailer(true);

    if (MAIL_USE_SMTP) {
        $mail->isSMTP();
        $mail->Host = MAIL_SMTP_HOST;
        $mail->Port = MAIL_SMTP_PORT;
        $mail->SMTPAuth = MAIL_SMTP_USERNAME !== '';
        $mail->Username = MAIL_SMTP_USERNAME;
        $mail->Password = MAIL_SMTP_PASSWORD;
        if (MAIL_SMTP_SECURE !== '') {
            $mail->SMTPSecure = MAIL_SMTP_SECURE;
        }
    } else {
        $mail->isMail();
    }

    $mail->CharSet = 'UTF-8';
    $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
    $mail->addAddress(MAIL_TO_EMAIL, MAIL_TO_NAME);

    if ($submission['email'] !== '') {
        $mail->addReplyTo($submission['email'], $submission['name']);
    }

    $mail->Subject = 'New GRA Website ' . format_label($submission['form_type']) . ' Submission';

    $rows = '';
    foreach ($submission as $key => $value) {
        if ($value === null || $value === '') {
            continue;
        }
        $rows .= '<tr>'
            . '<th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">' . e(format_label($key)) . '</th>'
            . '<td style="padding:8px 12px;border:1px solid #d8e1e8;">' . nl2br(e((string) $value)) . '</td>'
            . '</tr>';
    }

    $mail->isHTML(true);
    $mail->Body = '<div style="font-family:Arial,sans-serif;color:#1f2d3d;">'
        . '<h2 style="color:#0a486f;">New Website Submission</h2>'
        . '<p>A visitor submitted a form on the GRA website.</p>'
        . '<table style="border-collapse:collapse;width:100%;max-width:720px;">' . $rows . '</table>'
        . '</div>';

    $plain = "New Website Submission\n\n";
    foreach ($submission as $key => $value) {
        if ($value === null || $value === '') {
            continue;
        }
        $plain .= format_label($key) . ': ' . $value . "\n";
    }
    $mail->AltBody = $plain;

    $mail->send();
}

$formType = clean_value('form_type');
$name = clean_value('name');
$email = clean_value('email');
$phone = clean_value('phone');
$course = clean_value('course');
$preferredDate = clean_value('preferred_date');
$reviewSetup = clean_value('review_setup');
$message = clean_value('message');
$submittedAt = date('c');
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? substr((string) $_SERVER['HTTP_USER_AGENT'], 0, 255) : '';

if (!in_array($formType, ['booking', 'enrollment'], true)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Invalid form type.']);
    exit;
}

if ($name === '' || $email === '' || $phone === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please complete the required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

try {
    $database = get_database();

    if ($formType === 'booking') {
        $statement = $database->prepare(
            'INSERT INTO form_submissions
                (form_type, name, email, phone, course, preferred_date, review_setup, message, ip_address, user_agent)
             SELECT
                :form_type_insert, :name, :email_insert, :phone, :course, :preferred_date, :review_setup, :message, :ip_address, :user_agent
             WHERE NOT EXISTS (
                SELECT 1
                FROM form_submissions
                WHERE form_type = :form_type_check
                  AND LOWER(TRIM(email)) = LOWER(TRIM(:email_check))
             )'
        );
    } else {
        $statement = $database->prepare(
            'INSERT INTO form_submissions
                (form_type, name, email, phone, course, preferred_date, review_setup, message, ip_address, user_agent)
             VALUES
                (:form_type, :name, :email, :phone, :course, :preferred_date, :review_setup, :message, :ip_address, :user_agent)'
        );
    }

    if ($formType === 'booking') {
        $statement->execute([
            ':form_type_insert' => $formType,
            ':form_type_check' => $formType,
            ':name' => $name,
            ':email_insert' => $email,
            ':email_check' => $email,
            ':phone' => $phone,
            ':course' => $course !== '' ? $course : null,
            ':preferred_date' => $preferredDate !== '' ? $preferredDate : null,
            ':review_setup' => $reviewSetup !== '' ? $reviewSetup : null,
            ':message' => $message !== '' ? $message : null,
            ':ip_address' => $ipAddress !== '' ? $ipAddress : null,
            ':user_agent' => $userAgent !== '' ? $userAgent : null,
        ]);
    } else {
        $statement->execute([
            ':form_type' => $formType,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':course' => $course !== '' ? $course : null,
            ':preferred_date' => $preferredDate !== '' ? $preferredDate : null,
            ':review_setup' => $reviewSetup !== '' ? $reviewSetup : null,
            ':message' => $message !== '' ? $message : null,
            ':ip_address' => $ipAddress !== '' ? $ipAddress : null,
            ':user_agent' => $userAgent !== '' ? $userAgent : null,
        ]);
    }

    if ($formType === 'booking' && $statement->rowCount() === 0) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'message' => 'This email is already registered.']);
        exit;
    }
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to save submission.']);
    exit;
}

try {
    send_submission_email([
        'submitted_at' => $submittedAt,
        'form_type' => $formType,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'course' => $course,
        'preferred_date' => $preferredDate,
        'review_setup' => $reviewSetup,
        'message' => $message,
        'ip_address' => $ipAddress,
    ]);
} catch (MailException $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Submission was saved, but the email notification could not be sent.']);
    exit;
}

echo json_encode(['ok' => true, 'message' => 'Submission received.']);
