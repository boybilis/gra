<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';

function normalize_campus_email(string $email): string
{
    return strtolower(trim($email));
}

function is_booking_email_registered(string $email): bool
{
    $email = normalize_campus_email($email);
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $database = get_database();
    $statement = $database->prepare(
        'SELECT 1
         FROM form_submissions
         WHERE form_type = :form_type
           AND LOWER(TRIM(email)) = :email
         LIMIT 1'
    );
    $statement->execute([
        ':form_type' => 'booking',
        ':email' => $email,
    ]);

    return $statement->fetchColumn() !== false;
}
