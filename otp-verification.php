<?php
declare(strict_types=1);

function ensure_email_otp_table(PDO $database): void
{
    $database->exec(
        'CREATE TABLE IF NOT EXISTS email_otp_verifications (
            email VARCHAR(190) NOT NULL,
            otp_hash CHAR(64) DEFAULT NULL,
            otp_expires_at DATETIME DEFAULT NULL,
            otp_used_at DATETIME DEFAULT NULL,
            verification_token CHAR(64) DEFAULT NULL,
            verification_expires_at DATETIME DEFAULT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (email),
            INDEX idx_email_otp_expires (otp_expires_at),
            INDEX idx_email_verification_expires (verification_expires_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
}

function normalize_otp_email(string $email): string
{
    return strtolower(trim($email));
}

function generate_otp_code(): string
{
    return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
}

function hash_otp_code(string $otpCode): string
{
    return hash('sha256', $otpCode);
}

function generate_verification_token(): string
{
    return bin2hex(random_bytes(32));
}

function issue_email_otp(PDO $database, string $email): string
{
    ensure_email_otp_table($database);
    $normalizedEmail = normalize_otp_email($email);
    $otpCode = generate_otp_code();
    $otpHash = hash_otp_code($otpCode);

    $statement = $database->prepare(
        'INSERT INTO email_otp_verifications
            (email, otp_hash, otp_expires_at, otp_used_at, verification_token, verification_expires_at)
         VALUES
            (:email, :otp_hash, DATE_ADD(UTC_TIMESTAMP(), INTERVAL 2 MINUTE), NULL, NULL, NULL)
         ON DUPLICATE KEY UPDATE
            otp_hash = VALUES(otp_hash),
            otp_expires_at = VALUES(otp_expires_at),
            otp_used_at = NULL,
            verification_token = NULL,
            verification_expires_at = NULL'
    );
    $statement->execute([
        ':email' => $normalizedEmail,
        ':otp_hash' => $otpHash,
    ]);

    return $otpCode;
}

function verify_email_otp(PDO $database, string $email, string $otpCode): ?string
{
    ensure_email_otp_table($database);
    $normalizedEmail = normalize_otp_email($email);
    $statement = $database->prepare(
        'SELECT otp_hash, otp_expires_at, otp_used_at
         FROM email_otp_verifications
         WHERE email = :email
         LIMIT 1'
    );
    $statement->execute([':email' => $normalizedEmail]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        return null;
    }

    if (!empty($row['otp_used_at']) || empty($row['otp_hash']) || empty($row['otp_expires_at'])) {
        return null;
    }

    $expiresAt = strtotime((string) $row['otp_expires_at'] . ' UTC');
    if ($expiresAt === false || $expiresAt < time()) {
        return null;
    }

    if (!hash_equals((string) $row['otp_hash'], hash_otp_code($otpCode))) {
        return null;
    }

    $verificationToken = generate_verification_token();
    $update = $database->prepare(
        'UPDATE email_otp_verifications
         SET otp_used_at = UTC_TIMESTAMP(),
             verification_token = :verification_token,
             verification_expires_at = DATE_ADD(UTC_TIMESTAMP(), INTERVAL 10 MINUTE)
         WHERE email = :email'
    );
    $update->execute([
        ':verification_token' => $verificationToken,
        ':email' => $normalizedEmail,
    ]);

    return $verificationToken;
}

function consume_email_verification_token(PDO $database, string $email, string $token): bool
{
    ensure_email_otp_table($database);
    $normalizedEmail = normalize_otp_email($email);

    $statement = $database->prepare(
        'UPDATE email_otp_verifications
         SET verification_token = NULL,
             verification_expires_at = NULL
         WHERE email = :email
           AND verification_token = :token
           AND verification_expires_at IS NOT NULL
           AND verification_expires_at >= UTC_TIMESTAMP()'
    );
    $statement->execute([
        ':email' => $normalizedEmail,
        ':token' => trim($token),
    ]);

    return $statement->rowCount() > 0;
}
