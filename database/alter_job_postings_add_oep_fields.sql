-- Add OEP (Overseas Employment Promoter) fields to job_postings table
-- Run this query to add the new columns

ALTER TABLE `job_postings` 
ADD COLUMN `is_oep_pakistan` TINYINT(1) NULL DEFAULT NULL AFTER `location_country`,
ADD COLUMN `oep_permission_number` VARCHAR(255) NULL DEFAULT NULL AFTER `is_oep_pakistan`;

-- Note: 
-- is_oep_pakistan: 1 = Yes, 0 = No, NULL = Not specified
-- oep_permission_number: Permission number (required when is_oep_pakistan = 1)
