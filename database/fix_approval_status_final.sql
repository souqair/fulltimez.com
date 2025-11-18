-- Final SQL queries - only for missing columns
-- approval_status and is_featured already exist in seeker_profiles
-- Run these queries one by one

-- ============================================
-- FOR seeker_profiles TABLE
-- ============================================

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

