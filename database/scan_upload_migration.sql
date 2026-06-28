USE krishikavach;

ALTER TABLE product_scans
  ADD COLUMN latitude DECIMAL(10, 7) NULL AFTER ai_summary,
  ADD COLUMN longitude DECIMAL(10, 7) NULL AFTER latitude,
  ADD COLUMN location_accuracy DECIMAL(10, 2) NULL AFTER longitude;

ALTER TABLE evidence_files
  ADD COLUMN file_path VARCHAR(255) NULL AFTER file_name,
  ADD COLUMN original_name VARCHAR(180) NULL AFTER file_path,
  ADD COLUMN latitude DECIMAL(10, 7) NULL AFTER notes,
  ADD COLUMN longitude DECIMAL(10, 7) NULL AFTER latitude,
  ADD COLUMN location_accuracy DECIMAL(10, 2) NULL AFTER longitude;

UPDATE evidence_files
SET file_path = CONCAT('uploads/evidence/', file_name),
    original_name = file_name
WHERE file_path IS NULL;
