-- SQL queries to add remaining columns
-- approval_status already exists, so skip that query
-- Run these queries one by one on your MySQL server
-- If a column already exists, you'll get an error - just skip that query

-- ============================================
-- FOR seeker_profiles TABLE
-- ============================================

-- Skip this if approval_status already exists (you got duplicate error)
-- ALTER TABLE `seeker_profiles` 
-- ADD COLUMN `approval_status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' 
-- AFTER `verification_status`;

-- Add is_featured column (if not exists)
ALTER TABLE `seeker_profiles` 
ADD COLUMN `is_featured` BOOLEAN DEFAULT FALSE 
AFTER `approval_status`;

-- Add featured_expires_at column (if not exists)
ALTER TABLE `seeker_profiles` 
ADD COLUMN `featured_expires_at` TIMESTAMP NULL DEFAULT NULL 
AFTER `is_featured`;

-- ============================================
-- FOR employer_profiles TABLE
-- ============================================

-- Add approval_status column (if not exists)
ALTER TABLE `employer_profiles` 
ADD COLUMN `approval_status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' 
AFTER `verification_status`;

-- ============================================
-- UPDATE EXISTING DATA (Optional - only if needed)
-- ============================================

-- Update seeker_profiles: Set approval_status based on verification_status (only if NULL)
UPDATE `seeker_profiles` 
SET `approval_status` = CASE 
    WHEN `verification_status` = 'verified' THEN 'approved'
    WHEN `verification_status` = 'rejected' THEN 'rejected'
    ELSE 'pending'
END
WHERE `approval_status` IS NULL;

-- Update employer_profiles: Set approval_status based on verification_status (only if NULL)
UPDATE `employer_profiles` 
SET `approval_status` = CASE 
    WHEN `verification_status` = 'verified' THEN 'approved'
    WHEN `verification_status` = 'rejected' THEN 'rejected'
    ELSE 'pending'
END
WHERE `approval_status` IS NULL;

