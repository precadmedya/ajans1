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
  `balance` decimal(10,2) DEFAULT 0,
  `debt` decimal(10,2) DEFAULT 0,
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
  `logo_height` int DEFAULT 40,
  `header_bg` varchar(20) DEFAULT '#343a40',
  `header_color` varchar(20) DEFAULT '#ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `services` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `description` text,
  `unit_price` decimal(10,2) NOT NULL,
  `vat_rate` int NOT NULL DEFAULT 20,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `agency_id` int NOT NULL,
  `service_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `domain` varchar(255) DEFAULT NULL,
  `ref_link` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `vat` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`agency_id`) REFERENCES `agencies`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admins (name, email, password_hash) VALUES
  ('Admin', 'admin@example.com', '$2y$12$z.5OMDN2y9fWASP22PA5L.6m3WkhF7V45vLTitVsKz8lmGhhXxdE2');

INSERT INTO agencies (agency_name, contact_name, phone, email, password_hash, tax_number, tax_office, logo_url, status, balance, debt)
VALUES ('Demo Ajans', 'Demo Yetkili', '5551234567', 'demo@agency.com', '$2y$12$cd/kEGcWeMBDGarQxueW4eQO1fg1MiAfG9yB1UqdQe91icOIIVXLO', '1234567890', 'Demo VD', NULL, 'active', 1000, 0);

INSERT INTO services (title, description, unit_price, vat_rate)
VALUES ('WordPress Kurumsal Site', 'Standart kurumsal web sitesi paketi', 5000, 20);

INSERT INTO orders (agency_id, service_id, title, description, domain, ref_link, file_url, price, vat, total, status)
VALUES (1, 1, 'Demo Proje', 'Tanıtım sitesi', 'demo.com', NULL, NULL, 5000, 1000, 6000, 'approved');

INSERT INTO settings (logo_url, logo_width, logo_height, header_bg, header_color)
VALUES ('uploads/logo.png', 40, 40, '#343a40', '#ffffff');

