CREATE DATABASE IF NOT EXISTS projetominds DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE projetominds;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cpf` VARCHAR(14) NOT NULL UNIQUE,
    `email` VARCHAR(50) NOT NULL,
    `senha` VARCHAR(200) NOT NULL,
    `nome` VARCHAR(100) NOT NULL,
    `sobrenome` VARCHAR(100) NOT NULL,
    `telefone` VARCHAR(20),
    `estado_civil` ENUM('Solteiro', 'Casado', 'Divorciado', 'Viúvo', 'Outro') NOT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS `enderecos` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cep` VARCHAR(10) NOT NULL,
    `endereco` VARCHAR(255) NOT NULL,
    `numero` VARCHAR(10) NOT NULL,
    `complemento` VARCHAR(100) NULL,
    `observacoes` TEXT NULL,
    `user_id` INT UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE
);

