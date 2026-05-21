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
$phone = clean_value('phone');
$country = clean_value('country');
$licenseCountry = clean_value('license_country');
$targetCountry = clean_value('target_country');
$preferredStateRegion = clean_value('preferred_state_region');
$questions = clean_value('message');
$formType = clean_value('form_type');
$submittedAt = date('c');
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';

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
    $mail->addAddress('processing@gratestprepworldwide.com', 'GRA Processing Team');
    $mail->addReplyTo($email, $name);
    $mail->Subject = 'New Test Processing Consultation Submission';

    $rows = [
        'Submitted At' => $submittedAt,
        'Form Type' => $formType !== '' ? $formType : 'processing_consultation',
        'Name' => $name,
        'Email' => $email,
        'Mobile / WhatsApp' => $phone,
        'Country' => $country,
        'License Country' => $licenseCountry,
        'Target Country' => $targetCountry,
        'Preferred State / Region' => $preferredStateRegion,
        'Questions' => $questions,
        'IP Address' => $ipAddress,
    ];

    $htmlRows = '';
    foreach ($rows as $label => $value) {
        if ($value === '') {
            continue;
        }
        $htmlRows .= '<tr>'
            . '<th style="text-align:left;padding:8px 12px;border:1px solid #d8e1e8;background:#f4f7fb;color:#0a486f;">' . e($label) . '</th>'
            . '<td style="padding:8px 12px;border:1px solid #d8e1e8;">' . nl2br(e($value)) . '</td>'
            . '</tr>';
    }

    $mail->isHTML(true);
    $mail->Body = '<div style="font-family:Arial,sans-serif;color:#1f2d3d;">'
        . '<h2 style="color:#0a486f;">New Test Processing Consultation</h2>'
        . '<table style="border-collapse:collapse;width:100%;max-width:720px;">' . $htmlRows . '</table>'
        . '</div>';

    $plain = "New Test Processing Consultation\n\n";
    foreach ($rows as $label => $value) {
        if ($value === '') {
            continue;
        }
        $plain .= $label . ': ' . $value . "\n";
    }
    $mail->AltBody = $plain;

    $mail->send();
} catch (MailException $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to send your consultation request right now.']);
    exit;
}

echo json_encode(['ok' => true, 'message' => 'Consultation request submitted.']);
