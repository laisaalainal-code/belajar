-- Jalankan SQL ini di phpMyAdmin atau terminal MySQL

CREATE DATABASE IF NOT EXISTS db_produk CHARACTER SET utf8 COLLATE utf8_general_ci;

USE db_produk;

CREATE TABLE IF NOT EXISTS produk (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100)   NOT NULL,
    kategori    VARCHAR(50)    NOT NULL,
    harga       DECIMAL(12, 2) NOT NULL,
    stok        INT            NOT NULL DEFAULT 0,
    deskripsi   TEXT,
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);

-- Data contoh
INSERT INTO produk (nama, kategori, harga, stok, deskripsi) VALUES
('Laptop Asus VivoBook', 'Elektronik', 7500000, 10, 'Laptop ringan untuk produktivitas sehari-hari'),
('Sepatu Adidas Running', 'Fashion', 850000, 25, 'Sepatu lari nyaman dengan sol anti-slip'),
('Meja Belajar Kayu', 'Furnitur', 450000, 5, 'Meja belajar minimalis dari bahan kayu jati');