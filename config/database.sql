-- ============================================================
--  Prompt Vault — database.sql
--  Database: prompt_app
-- ============================================================

CREATE DATABASE IF NOT EXISTS `prompt_app`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `prompt_app`;

-- ------------------------------------------------------------
--  Table: users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(50)      NOT NULL UNIQUE,
  `email`      VARCHAR(100)     NOT NULL UNIQUE,
  `password`   VARCHAR(255)     NOT NULL,
  `role`       ENUM('admin','developer') NOT NULL DEFAULT 'developer',
  `created_at` TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
--  Table: categories
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id`         INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100)     NOT NULL UNIQUE,
  `created_at` TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
--  Table: prompts
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `prompts` (
  `id`          INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(200)     NOT NULL UNIQUE,
  `content`     TEXT             NOT NULL,
  `user_id`     INT UNSIGNED     NOT NULL,
  `category_id` INT UNSIGNED     NOT NULL,
  `created_at`  TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_prompts_user`     FOREIGN KEY (`user_id`)     REFERENCES `users`(`id`)      ON DELETE CASCADE,
  CONSTRAINT `fk_prompts_category` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  Sample data
-- ============================================================

-- Admin account  (password: admin123)
INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Developer accounts  (password: dev123)
INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES
('developer1', 'dev1@example.com', '$2y$10$TKh8H1.PfunCujQL4pZvPuiYlETsGFMGxBfFfRvxMGvGhKbFV5gXi', 'developer'),
('developer2', 'dev2@example.com', '$2y$10$TKh8H1.PfunCujQL4pZvPuiYlETsGFMGxBfFfRvxMGvGhKbFV5gXi', 'developer'),
('developer3', 'dev3@example.com', '$2y$10$TKh8H1.PfunCujQL4pZvPuiYlETsGFMGxBfFfRvxMGvGhKbFV5gXi', 'developer'),
('developer4', 'dev4@example.com', '$2y$10$TKh8H1.PfunCujQL4pZvPuiYlETsGFMGxBfFfRvxMGvGhKbFV5gXi', 'developer');

-- Sample categories
INSERT INTO `categories` (`name`) VALUES
('Code Generation'),
('Debugging'),
('Refactoring'),
('Documentation'),
('Testing');

-- Sample prompts
INSERT INTO `prompts` (`title`, `content`, `user_id`, `category_id`) VALUES
-- developer1 (user_id = 2)
(
  'Generate a REST API endpoint',
  'Write a clean REST API endpoint in [language] that handles [HTTP method] requests for [resource]. Include input validation, error handling, and return proper HTTP status codes.',
  2, 1
),
(
  'Debug this error',
  'I am getting the following error: [paste error]. My code is: [paste code]. Explain why this error occurs and provide a fix.',
  2, 2
),
(
  'Refactor for readability',
  'Refactor the following code to improve readability and maintainability without changing its behavior. Add comments where helpful: [paste code]',
  2, 3
),
-- developer2 (user_id = 3)
(
  'Write unit tests',
  'Write comprehensive unit tests for the following function using [testing framework]. Cover happy path, edge cases, and error scenarios: [paste code]',
  3, 5
),
(
  'Generate database schema',
  'Design a normalized MySQL database schema for a [describe app]. Include table names, columns with data types, primary keys, foreign keys, and indexes.',
  3, 1
),
(
  'Explain this code',
  'Explain the following code step by step in simple terms. Describe what each part does and why: [paste code]',
  3, 4
),
-- developer3 (user_id = 4)
(
  'Fix this bug',
  'The following code is supposed to [describe expected behavior] but instead it [describe actual behavior]. Identify the bug and provide a corrected version: [paste code]',
  4, 2
),
(
  'Write API documentation',
  'Write clear API documentation for the following endpoint. Include description, parameters, request body, response format, and example usage: [paste code]',
  4, 4
),
(
  'Optimize this query',
  'Optimize the following SQL query for better performance. Explain what changes you made and why: [paste query]',
  4, 3
),
-- developer4 (user_id = 5)
(
  'Create a login form',
  'Generate a secure HTML/PHP login form with email and password fields. Include CSRF protection, input sanitization, and proper error messages.',
  5, 1
),
(
  'Review my code',
  'Review the following code for bugs, security issues, performance problems, and best practice violations. Provide specific suggestions for improvement: [paste code]',
  5, 2
),
(
  'Write a README',
  'Write a professional README.md for a project called [project name] that does [describe project]. Include sections: description, features, installation, usage, and contributing.',
  5, 4
);
