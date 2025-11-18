-- Fix approval_status columns for seeker_profiles and employer_profiles tables
-- Run these queries on your MySQL server

-- 1. Add approval_status column to seeker_profiles table (if not exists)
ALTER TABLE `seeker_profiles` 
ADD COLUMN IF NOT EXISTS `approval_status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' 
AFTER `verification_status`;

-- 2. Add is_featured column to seeker_profiles table (if not exists)
ALTER TABLE `seeker_profiles` 
ADD COLUMN IF NOT EXISTS `is_featured` BOOLEAN DEFAULT FALSE 
AFTER `approval_status`;

-- 3. Add featured_expires_at column to seeker_profiles table (if not exists)
ALTER TABLE `seeker_profiles` 
ADD COLUMN IF NOT EXISTS `featured_expires_at` TIMESTAMP NULL DEFAULT NULL 
AFTER `is_featured`;

-- 4. Add approval_status column to employer_profiles table (if not exists)
ALTER TABLE `employer_profiles` 
ADD COLUMN IF NOT EXISTS `approval_status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' 
AFTER `verification_status`;

-- 5. Update existing records to set default approval_status
-- For seeker_profiles: Set approval_status based on verification_status or default to 'approved'
UPDATE `seeker_profiles` 
SET `approval_status` = CASE 
    WHEN `verification_status` = 'verified' THEN 'approved'
    WHEN `verification_status` = 'rejected' THEN 'rejected'
    ELSE 'pending'
END
WHERE `approval_status` IS NULL OR `approval_status` = '';

-- For employer_profiles: Set approval_status based on verification_status or default to 'approved'
UPDATE `employer_profiles` 
SET `approval_status` = CASE 
    WHEN `verification_status` = 'verified' THEN 'approved'
    WHEN `verification_status` = 'rejected' THEN 'rejected'
    ELSE 'pending'
END
WHERE `approval_status` IS NULL OR `approval_status` = '';

-- Verify the columns were added
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    COLUMN_TYPE,
    COLUMN_DEFAULT,
    IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME IN ('seeker_profiles', 'employer_profiles')
    AND COLUMN_NAME IN ('approval_status', 'is_featured', 'featured_expires_at')
ORDER BY TABLE_NAME, ORDINAL_POSITION;

