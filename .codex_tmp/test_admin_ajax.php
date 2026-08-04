<?php
declare(strict_types=1);

$sessionPath = __DIR__ . DIRECTORY_SEPARATOR . 'sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0775, true);
}
session_save_path($sessionPath);
session_start();
$_SESSION['mini_lessons_admin_logged_in'] = true;
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET = [
    'ajax_table' => (string) ($argv[1] ?? 'lessons'),
    'draw' => '7',
    'start' => '0',
    'length' => '10',
    'search' => ['value' => (string) ($argv[2] ?? '')],
    'order' => [['column' => '0', 'dir' => 'asc']],
];

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'admin-mini-lessons.php';
