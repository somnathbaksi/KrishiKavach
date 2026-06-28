USE krishikavach;

INSERT INTO users (name, mobile, email, password_hash, role) VALUES
('Sita Jadhav', '9876543211', 'sita@example.com', '$2y$10$dzzQ5gBiL29XfvQF86z/..cMNxcRBeOTBrcsEWm7zXaQh4jiVdrYO', 'farmer'),
('Mahadev Shinde', '9876543212', 'mahadev@example.com', '$2y$10$dzzQ5gBiL29XfvQF86z/..cMNxcRBeOTBrcsEWm7zXaQh4jiVdrYO', 'farmer'),
('Anita Pawar', '9876543213', 'anita@example.com', '$2y$10$dzzQ5gBiL29XfvQF86z/..cMNxcRBeOTBrcsEWm7zXaQh4jiVdrYO', 'farmer'),
('Field Officer Sangli', '9876543220', 'officer@example.com', '$2y$10$dzzQ5gBiL29XfvQF86z/..cMNxcRBeOTBrcsEWm7zXaQh4jiVdrYO', 'officer');

INSERT INTO farmer_profiles (user_id, village, taluka, district, state, land_area, primary_crop, kyc_status)
SELECT id, 'Miraj', 'Miraj', 'Sangli', 'Maharashtra', '3.2 acres', 'Soybean', 'verified' FROM users WHERE mobile = '9876543211';
INSERT INTO farmer_profiles (user_id, village, taluka, district, state, land_area, primary_crop, kyc_status)
SELECT id, 'Niphad', 'Niphad', 'Nashik', 'Maharashtra', '6 acres', 'Onion', 'verified' FROM users WHERE mobile = '9876543212';
INSERT INTO farmer_profiles (user_id, village, taluka, district, state, land_area, primary_crop, kyc_status)
SELECT id, 'Katol', 'Katol', 'Nagpur', 'Maharashtra', '2.7 acres', 'Cotton', 'pending' FROM users WHERE mobile = '9876543213';

INSERT INTO crop_profiles (user_id, crop_name, season, land_area, field_notes)
SELECT id, 'Soybean', 'Kharif 2026', '3.2 acres', 'Black soil field near village water tank. Seed germination issue reported.' FROM users WHERE mobile = '9876543211';
INSERT INTO crop_profiles (user_id, crop_name, season, land_area, field_notes)
SELECT id, 'Onion', 'Rabi 2026', '6 acres', 'Drip irrigation field. Fertilizer quality complaint under review.' FROM users WHERE mobile = '9876543212';
INSERT INTO crop_profiles (user_id, crop_name, season, land_area, field_notes)
SELECT id, 'Cotton', 'Kharif 2026', '2.7 acres', 'Pesticide spray damage suspected after first application.' FROM users WHERE mobile = '9876543213';

INSERT INTO cases (user_id, case_no, product_name, product_type, batch_no, seller_name, risk_level, status)
SELECT id, 'KK-2026-015', 'Shakti Cotton Seeds', 'Seeds', 'SK-7721', 'Sai Agro Center', 'Low', 'Closed' FROM users WHERE mobile = '9876543210';
INSERT INTO cases (user_id, case_no, product_name, product_type, batch_no, seller_name, risk_level, status)
SELECT id, 'KK-2026-016', 'GreenGrow Urea 45kg', 'Fertilizer', 'GG-2026-19', 'Mahalaxmi Krishi Seva Kendra', 'Medium', 'Evidence Pending' FROM users WHERE mobile = '9876543210';
INSERT INTO cases (user_id, case_no, product_name, product_type, batch_no, seller_name, risk_level, status)
SELECT id, 'KK-2026-017', 'SoyMax Hybrid Seeds', 'Seeds', 'SM-1120', 'Miraj Agro Mart', 'High', 'Ready' FROM users WHERE mobile = '9876543211';
INSERT INTO cases (user_id, case_no, product_name, product_type, batch_no, seller_name, risk_level, status)
SELECT id, 'KK-2026-018', 'NutriMix DAP', 'Fertilizer', 'NM-DAP-778', 'Niphad Krushi Kendra', 'Medium', 'Draft' FROM users WHERE mobile = '9876543212';
INSERT INTO cases (user_id, case_no, product_name, product_type, batch_no, seller_name, risk_level, status)
SELECT id, 'KK-2026-019', 'BugShield Pesticide', 'Pesticide', 'BS-55-A9', 'Katol Farm Store', 'High', 'Submitted' FROM users WHERE mobile = '9876543213';

INSERT INTO product_scans (user_id, case_id, product_name, product_type, batch_no, seller_name, confidence, risk_level, ai_summary)
SELECT c.user_id, c.id, c.product_name, c.product_type, c.batch_no, c.seller_name, 91, 'Low', 'Package layout, manufacturer name, and batch format matched expected seed label pattern.' FROM cases c WHERE c.case_no = 'KK-2026-015';
INSERT INTO product_scans (user_id, case_id, product_name, product_type, batch_no, seller_name, confidence, risk_level, ai_summary)
SELECT c.user_id, c.id, c.product_name, c.product_type, c.batch_no, c.seller_name, 64, 'Medium', 'QR code was readable but label print quality and batch placement need manual review.' FROM cases c WHERE c.case_no = 'KK-2026-016';
INSERT INTO product_scans (user_id, case_id, product_name, product_type, batch_no, seller_name, confidence, risk_level, ai_summary)
SELECT c.user_id, c.id, c.product_name, c.product_type, c.batch_no, c.seller_name, 38, 'High', 'Seed packet hologram missing and batch number does not match expected format.' FROM cases c WHERE c.case_no = 'KK-2026-017';
INSERT INTO product_scans (user_id, case_id, product_name, product_type, batch_no, seller_name, confidence, risk_level, ai_summary)
SELECT c.user_id, c.id, c.product_name, c.product_type, c.batch_no, c.seller_name, 70, 'Medium', 'Fertilizer bag print is acceptable but dealer bill and QR verification are incomplete.' FROM cases c WHERE c.case_no = 'KK-2026-018';
INSERT INTO product_scans (user_id, case_id, product_name, product_type, batch_no, seller_name, confidence, risk_level, ai_summary)
SELECT c.user_id, c.id, c.product_name, c.product_type, c.batch_no, c.seller_name, 35, 'High', 'Pesticide label composition and QR code failed authenticity checks.' FROM cases c WHERE c.case_no = 'KK-2026-019';

INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'shakti-seeds-front.jpg', 'Product Photo', 'Clear', 'Seed packet front label captured clearly.' FROM cases WHERE case_no = 'KK-2026-015';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'shakti-seeds-bill.jpg', 'Purchase Bill', 'Clear', 'Dealer bill readable with product name and date.' FROM cases WHERE case_no = 'KK-2026-015';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'greengrow-urea-front.jpg', 'Product Photo', 'Clear', 'Fertilizer bag front photo.' FROM cases WHERE case_no = 'KK-2026-016';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'greengrow-qr-blur.jpg', 'QR Photo', 'Retake', 'QR image is blurred and needs retake.' FROM cases WHERE case_no = 'KK-2026-016';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'soymax-hologram-missing.jpg', 'Product Photo', 'Clear', 'Hologram area appears missing.' FROM cases WHERE case_no = 'KK-2026-017';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'soybean-germination-issue.jpg', 'Crop Damage', 'Clear', 'Low germination observed after sowing.' FROM cases WHERE case_no = 'KK-2026-017';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'nutrimix-dap-bag.jpg', 'Product Photo', 'Clear', 'DAP bag label captured.' FROM cases WHERE case_no = 'KK-2026-018';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'bugshield-label.jpg', 'Product Photo', 'Clear', 'Pesticide label has mismatch in composition text.' FROM cases WHERE case_no = 'KK-2026-019';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'bugshield-cotton-damage.jpg', 'Crop Damage', 'Clear', 'Cotton leaves curled after first spray.' FROM cases WHERE case_no = 'KK-2026-019';
INSERT INTO evidence_files (user_id, case_id, file_name, evidence_type, quality_status, notes)
SELECT user_id, id, 'officer-visit-note.txt', 'Officer Note', 'Draft', 'Officer inspection visit scheduled.' FROM cases WHERE case_no = 'KK-2026-019';

INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'receipt-text', 'Product purchased', 'Purchase bill uploaded and linked with case.', 'ok', '2026-06-18 09:20:00' FROM cases WHERE case_no = 'KK-2026-015';
INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'badge-check', 'Product verified', 'AI scan marked product as likely genuine.', 'ok', '2026-06-18 09:40:00' FROM cases WHERE case_no = 'KK-2026-015';

INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'receipt-text', 'Fertilizer purchased', 'Dealer bill pending for final report.', 'warn', '2026-06-19 11:10:00' FROM cases WHERE case_no = 'KK-2026-016';
INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'qr-code', 'QR retake required', 'Uploaded QR photo is blurred.', 'warn', '2026-06-19 11:25:00' FROM cases WHERE case_no = 'KK-2026-016';

INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'scan-line', 'High-risk seed scan', 'Missing hologram and unusual batch sequence detected.', 'bad', '2026-06-23 08:15:00' FROM cases WHERE case_no = 'KK-2026-017';
INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'sprout', 'Germination issue logged', 'Farmer uploaded soybean germination issue photos.', 'bad', '2026-06-27 17:30:00' FROM cases WHERE case_no = 'KK-2026-017';

INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'package', 'Fertilizer bag scanned', 'Package print quality requires manual review.', 'warn', '2026-06-24 13:10:00' FROM cases WHERE case_no = 'KK-2026-018';

INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'scan-line', 'Pesticide high-risk scan', 'Label composition and QR check failed.', 'bad', '2026-06-21 16:00:00' FROM cases WHERE case_no = 'KK-2026-019';
INSERT INTO case_events (case_id, icon, title, description, event_status, event_date)
SELECT id, 'file-check-2', 'Report submitted', 'Case sent for officer review.', 'ok', '2026-06-28 10:45:00' FROM cases WHERE case_no = 'KK-2026-019';

INSERT INTO reports (user_id, case_id, report_no, complaint_summary, readiness, status)
SELECT user_id, id, 'RPT-2026-015', 'Shakti Cotton Seeds were scanned and found likely genuine. Evidence retained for records.', 95, 'Submitted' FROM cases WHERE case_no = 'KK-2026-015';
INSERT INTO reports (user_id, case_id, report_no, complaint_summary, readiness, status)
SELECT user_id, id, 'RPT-2026-016', 'GreenGrow Urea packet requires QR retake and dealer bill verification before complaint submission.', 58, 'Draft' FROM cases WHERE case_no = 'KK-2026-016';
INSERT INTO reports (user_id, case_id, report_no, complaint_summary, readiness, status)
SELECT user_id, id, 'RPT-2026-017', 'SoyMax seed packet appears suspicious due to missing hologram and low germination evidence.', 81, 'Ready' FROM cases WHERE case_no = 'KK-2026-017';
INSERT INTO reports (user_id, case_id, report_no, complaint_summary, readiness, status)
SELECT user_id, id, 'RPT-2026-018', 'NutriMix DAP packet requires additional bill and QR proof before final report.', 46, 'Draft' FROM cases WHERE case_no = 'KK-2026-018';
INSERT INTO reports (user_id, case_id, report_no, complaint_summary, readiness, status)
SELECT user_id, id, 'RPT-2026-019', 'BugShield pesticide failed QR and label checks. Crop damage evidence attached for officer review.', 88, 'Submitted' FROM cases WHERE case_no = 'KK-2026-019';

INSERT INTO notifications (user_id, case_id, title, message, severity, is_read)
SELECT user_id, id, 'QR retake required', 'GreenGrow Urea QR photo is blurred. Upload a sharper image.', 'warn', 0 FROM cases WHERE case_no = 'KK-2026-016';
INSERT INTO notifications (user_id, case_id, title, message, severity, is_read)
SELECT user_id, id, 'High-risk seed packet', 'SoyMax Hybrid Seeds need officer review due to missing hologram.', 'bad', 0 FROM cases WHERE case_no = 'KK-2026-017';
INSERT INTO notifications (user_id, case_id, title, message, severity, is_read)
SELECT user_id, id, 'Report draft ready', 'SoyMax seed complaint report is ready for submission.', 'ok', 0 FROM cases WHERE case_no = 'KK-2026-017';
INSERT INTO notifications (user_id, case_id, title, message, severity, is_read)
SELECT user_id, id, 'Officer review submitted', 'BugShield pesticide report was submitted for review.', 'ok', 1 FROM cases WHERE case_no = 'KK-2026-019';

INSERT INTO officers (name, designation, area, phone) VALUES
('District Agriculture Officer Sangli', 'District Agriculture Officer', 'Sangli District', '+919876543212'),
('Seed Quality Lab Pune', 'Seed Testing Laboratory', 'Pune Region', '+919876543213'),
('Fertilizer Quality Cell Nashik', 'Fertilizer Inspector', 'Nashik Division', '+919876543214'),
('Pesticide Control Room Nagpur', 'Pesticide Inspector', 'Nagpur Division', '+919876543215');
