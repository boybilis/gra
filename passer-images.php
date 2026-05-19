<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . DIRECTORY_SEPARATOR . 'passer-library.php';

echo json_encode([
    'ok' => true,
    'images' => get_latest_passer_images(8, isset($_GET['course']) ? (string) $_GET['course'] : null),
]);
