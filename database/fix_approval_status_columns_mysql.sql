-- Fix approval_status columns for seeker_profiles and employer_profiles tables
-- MySQL compatible version (without IF NOT EXISTS)
-- Run these queries on your MySQL server

-- Check if columns exist first, then add them
-- For seeker_profiles table

-- 1. Add approval_status column to seeker_profiles table
SET @dbname = DATABASE();
SET @tablename = 'seeker_profiles';
SET @columnname = 'approval_status';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (TABLE_SCHEMA = @dbname)
      AND (TABLE_NAME = @tablename)
      AND (COLUMN_NAME = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' ENUM(\'pending\', \'approved\', \'rejected\') DEFAULT \'pending\' AFTER verification_status')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 2. Add is_featured column to seeker_profiles table
SET @columnname = 'is_featured';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (TABLE_SCHEMA = @dbname)
      AND (TABLE_NAME = @tablename)
      AND (COLUMN_NAME = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' BOOLEAN DEFAULT FALSE AFTER approval_status')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 3. Add featured_expires_at column to seeker_profiles table
SET @columnname = 'featured_expires_at';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (TABLE_SCHEMA = @dbname)
      AND (TABLE_NAME = @tablename)
      AND (COLUMN_NAME = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' TIMESTAMP NULL DEFAULT NULL AFTER is_featured')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- For employer_profiles table
SET @tablename = 'employer_profiles';

-- 4. Add approval_status column to employer_profiles table
SET @columnname = 'approval_status';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (TABLE_SCHEMA = @dbname)
      AND (TABLE_NAME = @tablename)
      AND (COLUMN_NAME = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' ENUM(\'pending\', \'approved\', \'rejected\') DEFAULT \'pending\' AFTER verification_status')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

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

