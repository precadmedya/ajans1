CREATE TABLE IF NOT EXISTS `agencies` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `agency_name` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `tax_number` varchar(100) NOT NULL,
  `tax_office` varchar(100) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','rejected') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `logo_url` varchar(255) DEFAULT NULL,
  `logo_width` int DEFAULT 40,
  `logo_height` int DEFAULT 40
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admins (name, email, password_hash) VALUES
  ('Admin', 'admin@example.com', '$2y$12$z.5OMDN2y9fWASP22PA5L.6m3WkhF7V45vLTitVsKz8lmGhhXxdE2');

INSERT INTO agencies (agency_name, contact_name, phone, email, password_hash, tax_number, tax_office, logo_url, status)
VALUES ('Demo Ajans', 'Demo Yetkili', '5551234567', 'demo@agency.com', '$2y$12$cd/kEGcWeMBDGarQxueW4eQO1fg1MiAfG9yB1UqdQe91icOIIVXLO', '1234567890', 'Demo VD', NULL, 'active');

INSERT INTO settings (logo_url, logo_width, logo_height) VALUES ('uploads/logo.png', 40, 40);

