-- ============================================
-- FULLTIMEZ.COM DATABASE MIGRATIONS & SEEDERS
-- Run these queries in order on your live database
-- ============================================

-- ============================================
-- STEP 1: CREATE NEW TABLES
-- ============================================

-- 1. Create employment_types table
CREATE TABLE IF NOT EXISTS `employment_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employment_types_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Create experience_levels table
CREATE TABLE IF NOT EXISTS `experience_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `experience_levels_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Create experience_years table
CREATE TABLE IF NOT EXISTS `experience_years` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Create education_levels table
CREATE TABLE IF NOT EXISTS `education_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `education_levels_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Create salary_currencies table
CREATE TABLE IF NOT EXISTS `salary_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `salary_currencies_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Create salary_periods table
CREATE TABLE IF NOT EXISTS `salary_periods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `salary_periods_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- STEP 2: INSERT SEED DATA
-- ============================================

-- 1. Insert Employment Types
INSERT INTO `employment_types` (`name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('Full-time', 'full-time', 'Full-time employment with regular working hours', 1, NOW(), NOW()),
('Part-time', 'part-time', 'Part-time employment with reduced working hours', 1, NOW(), NOW()),
('Contract', 'contract', 'Contract-based employment for a specific duration', 1, NOW(), NOW()),
('Freelance', 'freelance', 'Freelance or project-based work', 1, NOW(), NOW()),
('Internship', 'internship', 'Internship position for students or recent graduates', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `description`=VALUES(`description`), `updated_at`=NOW();

-- 2. Insert Experience Levels
INSERT INTO `experience_levels` (`name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('Entry Level', 'entry', 'Entry level positions for beginners', 1, NOW(), NOW()),
('Mid Level', 'mid', 'Mid-level positions with some experience', 1, NOW(), NOW()),
('Senior Level', 'senior', 'Senior positions requiring extensive experience', 1, NOW(), NOW()),
('Executive Level', 'executive', 'Executive and leadership positions', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `description`=VALUES(`description`), `updated_at`=NOW();

-- 3. Insert Experience Years (including Fresh)
INSERT INTO `experience_years` (`name`, `value`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
('Fresh', 'Fresh', 0, 1, NOW(), NOW()),
('1 Year', '1 Year', 1, 1, NOW(), NOW()),
('2 Years', '2 Years', 2, 1, NOW(), NOW()),
('3 Years', '3 Years', 3, 1, NOW(), NOW()),
('4 Years', '4 Years', 4, 1, NOW(), NOW()),
('5 Years', '5 Years', 5, 1, NOW(), NOW()),
('6 Years', '6 Years', 6, 1, NOW(), NOW()),
('7 Years', '7 Years', 7, 1, NOW(), NOW()),
('8 Years', '8 Years', 8, 1, NOW(), NOW()),
('9 Years', '9 Years', 9, 1, NOW(), NOW()),
('10 Years', '10 Years', 10, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `sort_order`=VALUES(`sort_order`), `updated_at`=NOW();

-- 4. Insert Education Levels (including Intermediate)
INSERT INTO `education_levels` (`name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('PhD', 'phd', 'Doctorate degree', 1, NOW(), NOW()),
('Master', 'master', 'Master degree', 1, NOW(), NOW()),
('Bachelor', 'bachelor', 'Bachelor degree', 1, NOW(), NOW()),
('Intermediate', 'intermediate', 'Intermediate education', 1, NOW(), NOW()),
('Higher Secondary', 'higher-secondary', 'Higher secondary education', 1, NOW(), NOW()),
('Diploma', 'diploma', 'Diploma certificate', 1, NOW(), NOW()),
('Primary', 'primary', 'Primary education', 1, NOW(), NOW()),
('Not Required', 'not-required', 'No education requirement', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `description`=VALUES(`description`), `updated_at`=NOW();

-- 5. Insert Salary Currencies
INSERT INTO `salary_currencies` (`code`, `name`, `symbol`, `is_active`, `created_at`, `updated_at`) VALUES
('AED', 'UAE Dirham', 'د.إ', 1, NOW(), NOW()),
('USD', 'US Dollar', '$', 1, NOW(), NOW()),
('EUR', 'Euro', '€', 1, NOW(), NOW()),
('GBP', 'British Pound', '£', 1, NOW(), NOW()),
('SAR', 'Saudi Riyal', '﷼', 1, NOW(), NOW()),
('INR', 'Indian Rupee', '₹', 1, NOW(), NOW()),
('PKR', 'Pakistani Rupee', '₨', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `symbol`=VALUES(`symbol`), `updated_at`=NOW();

-- 6. Insert Salary Periods
INSERT INTO `salary_periods` (`name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('Monthly', 'monthly', 'Monthly salary', 1, NOW(), NOW()),
('Yearly', 'yearly', 'Annual salary', 1, NOW(), NOW()),
('Weekly', 'weekly', 'Weekly salary', 1, NOW(), NOW()),
('Hourly', 'hourly', 'Hourly wage', 1, NOW(), NOW()),
('Daily', 'daily', 'Daily wage', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `description`=VALUES(`description`), `updated_at`=NOW();

-- ============================================
-- STEP 3: ALTER JOB_POSTINGS TABLE
-- ============================================

-- 1. Add employment_type_id column
ALTER TABLE `job_postings` 
ADD COLUMN `employment_type_id` bigint(20) UNSIGNED NULL AFTER `benefits`,
ADD CONSTRAINT `job_postings_employment_type_id_foreign` 
FOREIGN KEY (`employment_type_id`) REFERENCES `employment_types` (`id`) ON DELETE SET NULL;

-- 2. Migrate existing employment_type data to employment_type_id
UPDATE `job_postings` jp
INNER JOIN `employment_types` et ON (
    (jp.employment_type = 'full-time' AND et.slug = 'full-time') OR
    (jp.employment_type = 'part-time' AND et.slug = 'part-time') OR
    (jp.employment_type = 'contract' AND et.slug = 'contract') OR
    (jp.employment_type = 'freelance' AND et.slug = 'freelance') OR
    (jp.employment_type = 'internship' AND et.slug = 'internship')
)
SET jp.employment_type_id = et.id
WHERE jp.employment_type IS NOT NULL;

-- 3. Add experience_level_id, experience_year_id, education_level_id, salary_currency_id, salary_period_id columns
ALTER TABLE `job_postings`
ADD COLUMN `experience_level_id` bigint(20) UNSIGNED NULL AFTER `employment_type_id`,
ADD COLUMN `experience_year_id` bigint(20) UNSIGNED NULL AFTER `experience_level`,
ADD COLUMN `education_level_id` bigint(20) UNSIGNED NULL AFTER `experience_years`,
ADD COLUMN `salary_currency_id` bigint(20) UNSIGNED NULL AFTER `salary_max`,
ADD COLUMN `salary_period_id` bigint(20) UNSIGNED NULL AFTER `salary_currency`;

-- 4. Add foreign key constraints
ALTER TABLE `job_postings`
ADD CONSTRAINT `job_postings_experience_level_id_foreign` 
FOREIGN KEY (`experience_level_id`) REFERENCES `experience_levels` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `job_postings_experience_year_id_foreign` 
FOREIGN KEY (`experience_year_id`) REFERENCES `experience_years` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `job_postings_education_level_id_foreign` 
FOREIGN KEY (`education_level_id`) REFERENCES `education_levels` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `job_postings_salary_currency_id_foreign` 
FOREIGN KEY (`salary_currency_id`) REFERENCES `salary_currencies` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `job_postings_salary_period_id_foreign` 
FOREIGN KEY (`salary_period_id`) REFERENCES `salary_periods` (`id`) ON DELETE SET NULL;

-- 5. Migrate experience_level data
UPDATE `job_postings` jp
INNER JOIN `experience_levels` el ON (
    (jp.experience_level = 'entry' AND el.slug = 'entry') OR
    (jp.experience_level = 'mid' AND el.slug = 'mid') OR
    (jp.experience_level = 'senior' AND el.slug = 'senior') OR
    (jp.experience_level = 'executive' AND el.slug = 'executive')
)
SET jp.experience_level_id = el.id
WHERE jp.experience_level IS NOT NULL;

-- 6. Migrate experience_years data
UPDATE `job_postings` jp
INNER JOIN `experience_years` ey ON jp.experience_years = ey.value
SET jp.experience_year_id = ey.id
WHERE jp.experience_years IS NOT NULL;

-- 7. Migrate education_level data
UPDATE `job_postings` jp
INNER JOIN `education_levels` ed ON (
    jp.education_level = ed.name OR
    (jp.education_level = 'Phd' AND ed.slug = 'phd') OR
    (jp.education_level = 'PhD' AND ed.slug = 'phd')
)
SET jp.education_level_id = ed.id
WHERE jp.education_level IS NOT NULL;

-- 8. Migrate salary_currency data
UPDATE `job_postings` jp
INNER JOIN `salary_currencies` sc ON jp.salary_currency = sc.code
SET jp.salary_currency_id = sc.id
WHERE jp.salary_currency IS NOT NULL;

-- 9. Migrate salary_period data
UPDATE `job_postings` jp
INNER JOIN `salary_periods` sp ON (
    jp.salary_period = sp.slug OR
    LOWER(jp.salary_period) = LOWER(sp.name)
)
SET jp.salary_period_id = sp.id
WHERE jp.salary_period IS NOT NULL;

-- 10. Add new fields: salary_type, gender, age_from, age_to, age_below
ALTER TABLE `job_postings`
ADD COLUMN `salary_type` ENUM('fixed', 'negotiable', 'based_on_experience', 'salary_plus_commission') NULL AFTER `salary_period_id`,
ADD COLUMN `gender` ENUM('male', 'female', 'any') NOT NULL DEFAULT 'any' AFTER `education_level_id`,
ADD COLUMN `age_from` int(11) NULL AFTER `gender`,
ADD COLUMN `age_to` int(11) NULL AFTER `age_from`,
ADD COLUMN `age_below` int(11) NULL AFTER `age_to`;

-- 11. Migrate salary_negotiable to salary_type
UPDATE `job_postings`
SET `salary_type` = 'negotiable'
WHERE `salary_negotiable` = 1;

UPDATE `job_postings`
SET `salary_type` = 'fixed'
WHERE `salary_type` IS NULL;

-- 12. Drop old columns (ONLY AFTER VERIFYING DATA MIGRATION)
-- Uncomment these lines after verifying all data has been migrated correctly:
-- ALTER TABLE `job_postings` DROP COLUMN `employment_type`;
-- ALTER TABLE `job_postings` DROP COLUMN `experience_level`;
-- ALTER TABLE `job_postings` DROP COLUMN `experience_years`;
-- ALTER TABLE `job_postings` DROP COLUMN `education_level`;
-- ALTER TABLE `job_postings` DROP COLUMN `salary_currency`;
-- ALTER TABLE `job_postings` DROP COLUMN `salary_period`;

-- ============================================
-- STEP 4: ALTER COUNTRIES TABLE
-- ============================================

-- Add approved_for_jobs column
ALTER TABLE `countries`
ADD COLUMN `approved_for_jobs` tinyint(1) NOT NULL DEFAULT 1 AFTER `is_active`;

-- Set all existing countries as approved (you can update this later in admin panel)
UPDATE `countries`
SET `approved_for_jobs` = 1
WHERE `is_active` = 1;

-- ============================================
-- VERIFICATION QUERIES
-- ============================================

-- Check if all tables were created
SELECT 'employment_types' as table_name, COUNT(*) as count FROM employment_types
UNION ALL
SELECT 'experience_levels', COUNT(*) FROM experience_levels
UNION ALL
SELECT 'experience_years', COUNT(*) FROM experience_years
UNION ALL
SELECT 'education_levels', COUNT(*) FROM education_levels
UNION ALL
SELECT 'salary_currencies', COUNT(*) FROM salary_currencies
UNION ALL
SELECT 'salary_periods', COUNT(*) FROM salary_periods;

-- Check job_postings migration status
SELECT 
    COUNT(*) as total_jobs,
    COUNT(employment_type_id) as jobs_with_employment_type_id,
    COUNT(experience_level_id) as jobs_with_experience_level_id,
    COUNT(experience_year_id) as jobs_with_experience_year_id,
    COUNT(education_level_id) as jobs_with_education_level_id,
    COUNT(salary_currency_id) as jobs_with_salary_currency_id,
    COUNT(salary_period_id) as jobs_with_salary_period_id
FROM job_postings;

-- ============================================
-- END OF MIGRATIONS
-- ============================================

