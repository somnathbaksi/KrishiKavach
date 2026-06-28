USE krishikavach;

ALTER TABLE users MODIFY role ENUM('farmer','officer','ngo','admin') NOT NULL DEFAULT 'farmer';

INSERT INTO users (name, mobile, email, password_hash, role, status)
VALUES ('Admin Krishi Kavach', '9999999999', 'admin@krishikavach.local', '$2y$10$MVNZ0ZaRVuUIXS5w1ixcE.I8rNOiVL/GD8UveMZwjir92tIYHmoH.', 'admin', 'active')
ON DUPLICATE KEY UPDATE
  name = VALUES(name),
  email = VALUES(email),
  password_hash = VALUES(password_hash),
  role = 'admin',
  status = 'active';
