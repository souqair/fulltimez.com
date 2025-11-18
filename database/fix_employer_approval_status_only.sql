-- Final query - only for employer_profiles table
-- All columns already exist in seeker_profiles table
-- Run this query:

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

-- Update employer_profiles: Set approval_status based on verification_status (only if NULL)
UPDATE `employer_profiles` 
SET `approval_status` = CASE 
    WHEN `verification_status` = 'verified' THEN 'approved'
    WHEN `verification_status` = 'rejected' THEN 'rejected'
    ELSE 'pending'
END
WHERE `approval_status` IS NULL;

