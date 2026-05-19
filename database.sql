CREATE DATABASE IF NOT EXISTS tutummedicus
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tutummedicus;

CREATE TABLE IF NOT EXISTS form_submissions (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  submitted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  form_type VARCHAR(40) NOT NULL,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(80) NOT NULL,
  course VARCHAR(160) DEFAULT NULL,
  preferred_date VARCHAR(80) DEFAULT NULL,
  review_setup VARCHAR(160) DEFAULT NULL,
  message TEXT DEFAULT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  user_agent VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idx_form_submissions_form_type (form_type),
  INDEX idx_form_submissions_submitted_at (submitted_at),
  INDEX idx_form_submissions_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mini_lessons (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
