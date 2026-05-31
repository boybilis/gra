<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . DIRECTORY_SEPARATOR . 'passer-library.php';

echo json_encode([
    'ok' => true,
    'images' => get_latest_passer_images(
        isset($_GET['limit']) ? max(1, (int) $_GET['limit']) : 8,
        isset($_GET['course']) ? (string) $_GET['course'] : null,
        isset($_GET['offset']) ? max(0, (int) $_GET['offset']) : 0
    ),
]);


