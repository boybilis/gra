<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'mail_config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'otp-verification.php';
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

function clean_otp_input(string $key): string
{
    $value = $_POST[$key] ?? '';
    if (is_array($value)) {
        $value = '';
    }
    return trim((string) $value);
}

function send_otp_email(string $email, string $otpCode): void
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
    $mail->addAddress($email);
    $mail->Subject = 'Your GRA Registration OTP';
    $mail->isHTML(true);
    $mail->Body = '<div style="font-family:Arial,sans-serif;color:#1f2d3d;">'
        . '<h2 style="margin:0 0 12px;color:#0a486f;">Email Verification Code</h2>'
        . '<p style="margin:0 0 8px;">Use this OTP to verify your registration form:</p>'
        . '<p style="margin:0 0 8px;font-size:28px;letter-spacing:2px;font-weight:700;color:#003057;">' . htmlspecialchars($otpCode, ENT_QUOTES, 'UTF-8') . '</p>'
        . '<p style="margin:0;">This code expires in 2 minutes.</p>'
        . '</div>';
    $mail->AltBody = "Your GRA verification code is: {$otpCode}\nThis code expires in 2 minutes.";
    $mail->send();
}

$action = strtolower(clean_otp_input('action'));
$email = clean_otp_input('email');

if (!in_array($action, ['send', 'verify'], true)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Invalid OTP action.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

try {
    $database = get_database();
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to initialize verification.']);
    exit;
}

if ($action === 'send') {
    try {
        $otpCode = issue_email_otp($database, $email);
        send_otp_email($email, $otpCode);
        echo json_encode(['ok' => true, 'message' => 'OTP sent to your email.']);
    } catch (MailException $exception) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'Unable to send OTP email right now.']);
    } catch (Throwable $exception) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'Unable to generate OTP right now.']);
    }
    exit;
}

$otpCode = preg_replace('/\D+/', '', clean_otp_input('otp'));
if ($otpCode === '' || strlen($otpCode) !== 6) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter the 6-digit OTP.']);
    exit;
}

try {
    $token = verify_email_otp($database, $email, $otpCode);
    if ($token === null) {
        http_response_code(422);
        echo json_encode(['ok' => false, 'message' => 'OTP is invalid, used, or expired.']);
        exit;
    }
    echo json_encode([
        'ok' => true,
        'message' => 'Email verified.',
        'verification_token' => $token,
    ]);
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to verify OTP right now.']);
}
