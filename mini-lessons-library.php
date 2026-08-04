<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';

function get_mini_lesson_course_options(): array
{
    return [
        'all' => 'All Courses',
        'nclex' => 'NCLEX',
        'dha' => 'DHA',
        'haad-doh' => 'HAAD / DOH',
        'prometric' => 'Prometric',
        'pnle' => 'PNLE',
        'sple' => 'SPLE',
        'civil-service' => 'Civil Service',
        'lept' => 'LEPT',
    ];
}

function normalize_mini_lesson_course(?string $course): string
{
    $course = strtolower(trim((string) $course));
    $options = get_mini_lesson_course_options();

    return array_key_exists($course, $options) ? $course : 'all';
}

function ensure_mini_lessons_table(PDO $database): void
{
    $database->exec(
        'CREATE TABLE IF NOT EXISTS mini_lessons (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(200) NOT NULL,
            course VARCHAR(50) NOT NULL DEFAULT "all",
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

    $columnStatement = $database->query("SHOW COLUMNS FROM mini_lessons LIKE 'course'");
    if ($columnStatement instanceof PDOStatement && $columnStatement->fetch() === false) {
        $database->exec('ALTER TABLE mini_lessons ADD COLUMN course VARCHAR(50) NOT NULL DEFAULT "all" AFTER title');
    }
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

function get_active_mini_lessons(?string $course = null): array
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $normalizedCourse = normalize_mini_lesson_course($course);

    if ($normalizedCourse === 'all') {
        $statement = $database->query(
            'SELECT id, title, course, description, youtube_url, youtube_video_id
             FROM mini_lessons
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );

        return $statement->fetchAll();
    }

    $statement = $database->prepare(
        'SELECT id, title, course, description, youtube_url, youtube_video_id
         FROM mini_lessons
         WHERE is_active = 1 AND course = :course
         ORDER BY sort_order ASC, id ASC'
    );
    $statement->execute([':course' => $normalizedCourse]);

    return $statement->fetchAll();
}

function get_all_mini_lessons(): array
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $statement = $database->query(
        'SELECT id, title, course, description, youtube_url, youtube_video_id, sort_order, is_active, created_at
         FROM mini_lessons
         ORDER BY sort_order ASC, id ASC'
    );

    return $statement->fetchAll();
}

function add_mini_lesson(string $title, string $course, string $description, string $youtubeUrl, int $sortOrder = 0): void
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $videoId = extract_youtube_video_id($youtubeUrl);
    if ($videoId === null) {
        throw new InvalidArgumentException('Invalid YouTube URL.');
    }

    $normalizedCourse = normalize_mini_lesson_course($course);

    $statement = $database->prepare(
        'INSERT INTO mini_lessons (title, course, description, youtube_url, youtube_video_id, sort_order, is_active)
         VALUES (:title, :course, :description, :youtube_url, :youtube_video_id, :sort_order, 1)'
    );

    $statement->execute([
        ':title' => trim($title),
        ':course' => $normalizedCourse,
        ':description' => trim($description) !== '' ? trim($description) : null,
        ':youtube_url' => trim($youtubeUrl),
        ':youtube_video_id' => $videoId,
        ':sort_order' => $sortOrder,
    ]);
}

function update_mini_lesson(int $id, string $title, string $course, string $description, string $youtubeUrl, int $sortOrder = 0): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('Invalid lesson ID.');
    }

    $database = get_database();
    ensure_mini_lessons_table($database);

    $videoId = extract_youtube_video_id($youtubeUrl);
    if ($videoId === null) {
        throw new InvalidArgumentException('Invalid YouTube URL.');
    }

    $normalizedCourse = normalize_mini_lesson_course($course);
    $statement = $database->prepare(
        'UPDATE mini_lessons
         SET title = :title,
             course = :course,
             description = :description,
             youtube_url = :youtube_url,
             youtube_video_id = :youtube_video_id,
             sort_order = :sort_order
         WHERE id = :id
         LIMIT 1'
    );
    $statement->execute([
        ':id' => $id,
        ':title' => trim($title),
        ':course' => $normalizedCourse,
        ':description' => trim($description) !== '' ? trim($description) : null,
        ':youtube_url' => trim($youtubeUrl),
        ':youtube_video_id' => $videoId,
        ':sort_order' => $sortOrder,
    ]);

    if ($statement->rowCount() === 0) {
        $existsStatement = $database->prepare('SELECT COUNT(*) FROM mini_lessons WHERE id = :id');
        $existsStatement->execute([':id' => $id]);
        if ((int) $existsStatement->fetchColumn() === 0) {
            throw new RuntimeException('The selected mini lesson no longer exists.');
        }
    }
}

function delete_mini_lesson(int $id): void
{
    $database = get_database();
    ensure_mini_lessons_table($database);

    $statement = $database->prepare('DELETE FROM mini_lessons WHERE id = :id LIMIT 1');
    $statement->execute([':id' => $id]);
}


