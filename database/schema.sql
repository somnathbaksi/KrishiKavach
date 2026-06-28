CREATE DATABASE IF NOT EXISTS krishikavach CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE krishikavach;

DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS case_events;
DROP TABLE IF EXISTS evidence_files;
DROP TABLE IF EXISTS product_scans;
DROP TABLE IF EXISTS cases;
DROP TABLE IF EXISTS crop_profiles;
DROP TABLE IF EXISTS officers;
DROP TABLE IF EXISTS farmer_profiles;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  mobile VARCHAR(20) NOT NULL UNIQUE,
  email VARCHAR(160) NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('farmer','officer','ngo','admin') NOT NULL DEFAULT 'farmer',
  status ENUM('active','blocked') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE farmer_profiles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  village VARCHAR(120) NOT NULL,
  taluka VARCHAR(120) NOT NULL,
  district VARCHAR(120) NOT NULL,
  state VARCHAR(120) NOT NULL DEFAULT 'Maharashtra',
  land_area VARCHAR(60) NOT NULL,
  primary_crop VARCHAR(80) NOT NULL,
  kyc_status ENUM('pending','verified') NOT NULL DEFAULT 'verified',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE crop_profiles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  crop_name VARCHAR(100) NOT NULL,
  season VARCHAR(80) NOT NULL,
  land_area VARCHAR(60) NOT NULL,
  field_notes TEXT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE cases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  case_no VARCHAR(40) NOT NULL UNIQUE,
  product_name VARCHAR(160) NOT NULL,
  product_type ENUM('Seeds','Fertilizer','Pesticide') NOT NULL,
  batch_no VARCHAR(80) NOT NULL,
  seller_name VARCHAR(160) NOT NULL,
  risk_level ENUM('Low','Medium','High') NOT NULL DEFAULT 'Medium',
  status ENUM('Draft','Evidence Pending','Ready','Submitted','Closed') NOT NULL DEFAULT 'Ready',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE product_scans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  case_id INT NULL,
  product_name VARCHAR(160) NOT NULL,
  product_type ENUM('Seeds','Fertilizer','Pesticide') NOT NULL,
  batch_no VARCHAR(80) NOT NULL,
  seller_name VARCHAR(160) NOT NULL,
  confidence INT NOT NULL,
  risk_level ENUM('Low','Medium','High') NOT NULL,
  ai_summary TEXT NOT NULL,
  latitude DECIMAL(10, 7) NULL,
  longitude DECIMAL(10, 7) NULL,
  location_accuracy DECIMAL(10, 2) NULL,
  scanned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE evidence_files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  case_id INT NOT NULL,
  file_name VARCHAR(180) NOT NULL,
  file_path VARCHAR(255) NULL,
  original_name VARCHAR(180) NULL,
  evidence_type ENUM('Product Photo','QR Photo','Purchase Bill','Crop Damage','Dealer Note','Officer Note') NOT NULL,
  quality_status ENUM('Clear','Retake','Draft') NOT NULL DEFAULT 'Clear',
  notes TEXT NULL,
  latitude DECIMAL(10, 7) NULL,
  longitude DECIMAL(10, 7) NULL,
  location_accuracy DECIMAL(10, 2) NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE case_events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  case_id INT NOT NULL,
  icon VARCHAR(50) NOT NULL,
  title VARCHAR(160) NOT NULL,
  description TEXT NOT NULL,
  event_status ENUM('ok','warn','bad') NOT NULL DEFAULT 'ok',
  event_date DATETIME NOT NULL,
  FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  case_id INT NOT NULL,
  report_no VARCHAR(40) NOT NULL UNIQUE,
  complaint_summary TEXT NOT NULL,
  readiness INT NOT NULL DEFAULT 72,
  status ENUM('Draft','Ready','Submitted') NOT NULL DEFAULT 'Ready',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  case_id INT NULL,
  title VARCHAR(160) NOT NULL,
  message TEXT NOT NULL,
  severity ENUM('ok','warn','bad') NOT NULL DEFAULT 'warn',
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE officers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(140) NOT NULL,
  designation VARCHAR(140) NOT NULL,
  area VARCHAR(140) NOT NULL,
  phone VARCHAR(24) NOT NULL
) ENGINE=InnoDB;

INSERT INTO users (id, name, mobile, email, password_hash, role) VALUES
(1, 'Ramesh Patil', '9876543210', 'ramesh@example.com', '$2y$10$dzzQ5gBiL29XfvQF86z/..cMNxcRBeOTBrcsEWm7zXaQh4jiVdrYO', 'farmer');

INSERT INTO farmer_profiles (user_id, village, taluka, district, land_area, primary_crop) VALUES
(1, 'Tasgaon', 'Tasgaon', 'Sangli', '4.5 acres', 'Cotton');

INSERT INTO crop_profiles (user_id, crop_name, season, land_area, field_notes) VALUES
(1, 'Cotton', 'Kharif 2026', '4.5 acres', 'Cotton field near canal road. Previous pesticide caused leaf yellowing.');

INSERT INTO cases (id, user_id, case_no, product_name, product_type, batch_no, seller_name, risk_level, status) VALUES
(1, 1, 'KK-2026-014', 'CropSafe Insecticide', 'Pesticide', 'CS-9X-2048', 'Mahalaxmi Krishi Seva Kendra', 'High', 'Ready');

INSERT INTO product_scans (user_id, case_id, product_name, product_type, batch_no, seller_name, confidence, risk_level, ai_summary) VALUES
(1, 1, 'CropSafe Insecticide', 'Pesticide', 'CS-9X-2048', 'Mahalaxmi Krishi Seva Kendra', 42, 'High', 'QR code failed, batch sequence is unusual, and label spacing does not match expected packaging.'),
(1, NULL, 'GreenGrow Urea 45kg', 'Fertilizer', 'GG-2026-19', 'Mahalaxmi Krishi Seva Kendra', 61, 'Medium', 'QR close-up is blurred. Retake required before final verification.'),
(1, NULL, 'Shakti Cotton Seeds', 'Seeds', 'SK-7721', 'Sai Agro Center', 89, 'Low', 'Manufacturer name and package layout match expected label pattern.');

INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes) VALUES
(1, 1, 'front-label.jpg', 'Product Photo', 'Clear', 'Front label, brand name, product type visible.'),
(1, 1, 'back-label.jpg', 'Product Photo', 'Clear', 'Manufacturer, MRP, expiry date visible.'),
(1, 1, 'qr-closeup-blur.jpg', 'QR Photo', 'Retake', 'QR area is blurred. Retake needed for traceability.'),
(1, 1, 'batch-number.jpg', 'Product Photo', 'Clear', 'Batch CS-9X-2048 captured clearly.'),
(1, 1, 'bill-mahalaxmi-2048.jpg', 'Purchase Bill', 'Clear', 'Dealer name, date, product name, and price are readable.'),
(1, 1, 'cotton-leaf-damage-01.jpg', 'Crop Damage', 'Clear', 'Yellowing leaves after second spray.'),
(1, 1, 'cotton-field-row-02.jpg', 'Crop Damage', 'Clear', 'Field row damage and plant density visible.'),
(1, 1, 'field-location-note.txt', 'Dealer Note', 'Draft', 'Tasgaon field location and observation note saved.');

INSERT INTO case_events (case_id, icon, title, description, event_status, event_date) VALUES
(1, 'receipt-text', 'Product purchased', 'Dealer bill uploaded from Mahalaxmi Krishi Seva Kendra.', 'ok', '2026-06-20 10:35:00'),
(1, 'package', 'Packet photos added', 'Front label, back label, MRP, and expiry photos saved.', 'ok', '2026-06-20 11:05:00'),
(1, 'scan-line', 'AI scan marked high risk', 'QR failed and batch sequence looked unusual.', 'bad', '2026-06-22 08:20:00'),
(1, 'qr-code', 'QR retake requested', 'System requested sharper QR close-up for traceability.', 'warn', '2026-06-22 08:23:00'),
(1, 'sprout', 'Crop damage logged', 'Cotton leaf yellowing photos added from field.', 'ok', '2026-06-25 17:45:00'),
(1, 'message-square-text', 'Dealer note added', 'Farmer recorded dealer response and replacement refusal.', 'warn', '2026-06-26 12:10:00'),
(1, 'file-check-2', 'Report draft generated', 'Evidence report ready for agriculture officer review.', 'ok', '2026-06-29 09:15:00');

INSERT INTO reports (user_id, case_id, report_no, complaint_summary, readiness, status) VALUES
(1, 1, 'RPT-2026-014', 'Farmer purchased CropSafe Insecticide on 20 June 2026. After application, cotton leaves turned yellow and the product packet QR code could not be verified. Batch number and label placement appear suspicious.', 72, 'Ready');

INSERT INTO notifications (user_id, case_id, title, message, severity, is_read) VALUES
(1, 1, 'High-risk pesticide scan', 'CropSafe Insecticide QR code failed verification and the batch number format looks unusual.', 'bad', 0),
(1, 1, 'Retake QR photo', 'Your report needs a sharper QR close-up before final officer submission.', 'warn', 0),
(1, 1, 'Complaint draft ready', 'Case KK-2026-014 has enough evidence for a draft report.', 'ok', 0),
(1, NULL, 'Profile verified', 'Farmer details are ready for report generation.', 'ok', 1);

INSERT INTO officers (name, designation, area, phone) VALUES
('Taluka Agriculture Office', 'Agriculture Office', 'Tasgaon Road, Sangli', '+919876543210'),
('Input Quality Inspector', 'Seed, Fertilizer, Pesticide Inspector', 'Sangli District', '+919876543211'),
('Farmer Helpline', 'Complaint Guidance', 'Maharashtra', '+911800000000');
