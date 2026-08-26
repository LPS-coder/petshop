CREATE DATABASE IF NOT EXISTS petshop
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;

USE petshop;

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefone VARCHAR(20),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    especie VARCHAR(50),
    raca VARCHAR(50),
    idade INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    CONSTRAINT fk_animais_clientes
        FOREIGN KEY (cliente_id)
        REFERENCES clientes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO clientes (nome, email, telefone) VALUES
('João da Silva', 'joao@gmail.com', '(47) 99999-8888'),
('Maria Caetano', 'maria@gmail.com', '(47) 99967-6788'),

INSERT INTO animais (cliente_id, nome, especie, raca, idade) VALUES
(1, 'Thor', 'Cachorro', 'Labrador', 5),
(1, 'Wolverine', 'Gato', 'Tigrado', 3),
(2, 'Chagas', 'Cachorro', 'Golden', 2),

