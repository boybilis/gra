<?php
declare(strict_types=1);

header('Content-Type: application/json');

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

$name = clean_value('name');
$email = clean_value('email');
$course = clean_value('course');
$studentId = clean_value('student_id');
$concern = clean_value('concern');
$preferredContact = clean_value('preferred_contact');
$message = clean_value('message');
$submittedAt = date('c');
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';

if ($name === '' || $email === '' || $course === '' || $studentId === '' || $concern === '' || $preferredContact === '' || $message === '') {
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
    $mail->addAddress('inquire@gratestprepworldwide.com', 'Gapuz Review Academy');
    $mail->addReplyTo($email, $name);
    $mail->Subject = 'Online Campus - Student Support Request';

    $rows = ''
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Submitted At</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e($submittedAt) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Name</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e($name) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Email</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e($email) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Course / Program</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e($course) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Student ID / Registration No.</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e($studentId) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Concern / Category</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e($concern) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Preferred Contact Method</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e($preferredContact) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">Message / Details</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . nl2br(e($message)) . '</td></tr>'
        . '<tr><th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">IP Address</th><td style="padding:8px 12px;border:1px solid #d8e1e8;">' . e((string) $ipAddress) . '</td></tr>';

    $mail->isHTML(true);
    $mail->Body = '<div style="font-family:Arial,sans-serif;color:#1f2d3d;">'
        . '<h2 style="color:#0a486f;">Online Campus Student Support Request</h2>'
        . '<table style="border-collapse:collapse;width:100%;max-width:720px;">' . $rows . '</table>'
        . '</div>';

    $mail->AltBody =
        "Online Campus Student Support Request\n\n"
        . "Submitted At: {$submittedAt}\n"
        . "Name: {$name}\n"
        . "Email: {$email}\n"
        . "Course / Program: {$course}\n"
        . "Student ID / Registration No.: {$studentId}\n"
        . "Concern / Category: {$concern}\n"
        . "Preferred Contact Method: {$preferredContact}\n"
        . "Message / Details: {$message}\n"
        . "IP Address: {$ipAddress}\n";

    $mail->send();
} catch (MailException $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to send request. Please try again.']);
    exit;
}

echo json_encode(['ok' => true, 'message' => 'Support request sent successfully.']);
