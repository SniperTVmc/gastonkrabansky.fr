# gastonkrabansky.fr

My personal website, developed with PHP and hosted on a shared hosting platform.
The website showcases my portfolio, skills, and projects, allowing visitors to learn more about my work and background.
It is designed to be responsive and user-friendly, providing visitors with an engaging experience across different devices.

## Features
- Portfolio showcase
- Skills and expertise section
- Projects and case studies
- Contact form for inquiries
- Responsive design for mobile and desktop users

## Installation
To set up the website on your own server, follow these steps:
1. Ensure that your server meets the requirements for running PHP applications.
2. Clone the repository to your local machine:
   ```bash
   git clone https://github.com/gastonkrabansky/gastonkrabansky.fr.git
    ```
3. Upload the files to your web server using FTP or any other preferred method.
4. Prepare the database by creating a new MySQL database, and then run the following SQL command to create the necessary tables:
    ```sql
   CREATE TABLE IF NOT EXISTS `users` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

   CREATE TABLE IF NOT EXISTS `analytics_sessions` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `session_key` CHAR(36) NOT NULL UNIQUE,
        `visitor_key` CHAR(64) NOT NULL,
        `entry_url` VARCHAR(512) DEFAULT NULL,
        `landing_page` VARCHAR(255) DEFAULT NULL,
        `exit_url` VARCHAR(512) DEFAULT NULL,
        `referrer_url` VARCHAR(512) DEFAULT NULL,
        `referrer_host` VARCHAR(191) DEFAULT NULL,
        `utm_source` VARCHAR(100) DEFAULT NULL,
        `utm_medium` VARCHAR(100) DEFAULT NULL,
        `utm_campaign` VARCHAR(150) DEFAULT NULL,
        `utm_term` VARCHAR(150) DEFAULT NULL,
        `utm_content` VARCHAR(150) DEFAULT NULL,
        `country_code` CHAR(2) DEFAULT NULL,
        `region` VARCHAR(100) DEFAULT NULL,
        `city` VARCHAR(100) DEFAULT NULL,
        `language` VARCHAR(16) DEFAULT NULL,
        `timezone` VARCHAR(64) DEFAULT NULL,
        `device_type` ENUM('desktop', 'mobile', 'tablet', 'bot', 'unknown') NOT NULL DEFAULT 'unknown',
        `os_name` VARCHAR(50) DEFAULT NULL,
        `browser_name` VARCHAR(50) DEFAULT NULL,
        `screen_width` SMALLINT UNSIGNED DEFAULT NULL,
        `screen_height` SMALLINT UNSIGNED DEFAULT NULL,
        `is_returning` TINYINT(1) NOT NULL DEFAULT 0,
        `started_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `last_seen_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `ended_at` DATETIME DEFAULT NULL,
        `event_count` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
        `page_view_count` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
        `duration_seconds` INT UNSIGNED DEFAULT NULL,
        `consent_analytics` TINYINT(1) NOT NULL DEFAULT 0,
        INDEX `idx_sessions_started` (`started_at`),
        INDEX `idx_sessions_visitor` (`visitor_key`),
        INDEX `idx_sessions_source` (`utm_source`, `utm_medium`, `utm_campaign`),
        INDEX `idx_sessions_geo` (`country_code`, `region`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

   CREATE TABLE IF NOT EXISTS `analytics_events` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `session_id` BIGINT UNSIGNED DEFAULT NULL,
        `event_key` CHAR(36) NOT NULL UNIQUE,
        `event_type` VARCHAR(50) NOT NULL,
        `page_url` VARCHAR(512) DEFAULT NULL,
        `page_title` VARCHAR(255) DEFAULT NULL,
        `target_type` VARCHAR(50) DEFAULT NULL,
        `target_id` VARCHAR(191) DEFAULT NULL,
        `target_label` VARCHAR(255) DEFAULT NULL,
        `value_number` DECIMAL(12,3) DEFAULT NULL,
        `value_text` VARCHAR(255) DEFAULT NULL,
        `metadata_json` JSON DEFAULT NULL,
        `occurred_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT `fk_events_session`
            FOREIGN KEY (`session_id`) REFERENCES `analytics_sessions` (`id`)
            ON DELETE SET NULL,
        INDEX `idx_events_type_date` (`event_type`, `occurred_at`),
        INDEX `idx_events_page_date` (`page_url`(191), `occurred_at`),
        INDEX `idx_events_target` (`target_type`, `target_id`),
        INDEX `idx_events_session` (`session_id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```
   
   Get your hashed password using the following command:
   ```bash
   php -r "echo password_hash('your_password', PASSWORD_ARGON2ID);"
   ```
   Replace `your_password` with your desired password. Copy the output and insert it into the `password` field of the `users` table for your user.
5. Copy the `.env.example` file to `.env`, update the database credentials, and replace
   `ANALYTICS_SECRET` with a long random value. The analytics collector is optional and
   falls back to `site_visits` until the `analytics_*` tables above are installed; verify
   the installation with `SHOW TABLES LIKE 'analytics_%';`.
6. Configure your web server to point to the public directory of the project.

## Help and Support
If you encounter any issues or need assistance,
please feel free to reach out via the contact form on the website or open an issue in the GitHub repository.
I will do my best to respond promptly and provide the necessary support.
