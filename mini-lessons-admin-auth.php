<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/*
 * Change these credentials before publishing to production.
 */
const MINI_LESSONS_ADMIN_USERNAME = 'admin';
const MINI_LESSONS_ADMIN_PASSWORD = 'ChangeThisNow_123!';

function is_mini_lessons_admin_logged_in(): bool
{
    return isset($_SESSION['mini_lessons_admin_logged_in']) && $_SESSION['mini_lessons_admin_logged_in'] === true;
}

function mini_lessons_admin_login(string $username, string $password): bool
{
    $valid = hash_equals(MINI_LESSONS_ADMIN_USERNAME, trim($username))
        && hash_equals(MINI_LESSONS_ADMIN_PASSWORD, $password);

    if ($valid) {
        $_SESSION['mini_lessons_admin_logged_in'] = true;
    }

    return $valid;
}

function mini_lessons_admin_logout(): void
{
    unset($_SESSION['mini_lessons_admin_logged_in']);
}


