<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';

function ensure_mini_lessons_table(PDO $database): void
{
    $database->exec(
        'CREATE TABLE IF NOT EXISTS mini_lessons (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(200) NOT NULL,
            description TEXT DEFAULT NULL,
            youtube_url VARCHAR(500) NOT NULL,
            youtube_video_id VARCHAR(32) NOT NULL,
            sort_order INT NOT NULL DEFAULT 0,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX idx_mini_lessons_active_sort (is_active, sort_order, id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
}

function extract_youtube_video_id(string $url): ?string
{
    $url = trim($url);
    if ($url === '') {
        return null;
    }

    $pattern = '#(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})#i';
    if (preg_match($pattern, $url, $matches) === 1) {
        return $matches[1];
    }

    return null;
}

function get_active_mini_lessons(): array
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $statement = $database->query(
        'SELECT id, title, description, youtube_url, youtube_video_id
         FROM mini_lessons
         WHERE is_active = 1
         ORDER BY sort_order ASC, id ASC'
    );

    return $statement->fetchAll();
}

function get_all_mini_lessons(): array
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $statement = $database->query(
        'SELECT id, title, description, youtube_url, youtube_video_id, sort_order, is_active, created_at
         FROM mini_lessons
         ORDER BY sort_order ASC, id ASC'
    );

    return $statement->fetchAll();
}

function add_mini_lesson(string $title, string $description, string $youtubeUrl, int $sortOrder = 0): void
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $videoId = extract_youtube_video_id($youtubeUrl);
    if ($videoId === null) {
        throw new InvalidArgumentException('Invalid YouTube URL.');
    }

    $statement = $database->prepare(
        'INSERT INTO mini_lessons (title, description, youtube_url, youtube_video_id, sort_order, is_active)
         VALUES (:title, :description, :youtube_url, :youtube_video_id, :sort_order, 1)'
    );

    $statement->execute([
        ':title' => trim($title),
        ':description' => trim($description) !== '' ? trim($description) : null,
        ':youtube_url' => trim($youtubeUrl),
        ':youtube_video_id' => $videoId,
        ':sort_order' => $sortOrder,
    ]);
}

function delete_mini_lesson(int $id): void
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $statement = $database->prepare('DELETE FROM mini_lessons WHERE id = :id LIMIT 1');
    $statement->execute([':id' => $id]);
}
