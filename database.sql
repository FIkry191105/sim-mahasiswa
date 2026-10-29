-- Jalankan di phpMyAdmin (tab SQL) atau MySQL CLI
CREATE DATABASE IF NOT EXISTS db_sim CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_sim;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(15) NOT NULL UNIQUE,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  jurusan VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Akun login: username = admin | password = admin123
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$H.ViuJfzuWxkUpYloBXEeuCg8mGYxmH2fqOEVjDxm8IaI5TqI3Jba');
