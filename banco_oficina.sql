-- Banco de dados para Sistema de Oficina Mecânica
-- Execute este script no phpMyAdmin ou MySQL

CREATE DATABASE IF NOT EXISTS oficina_db;
USE oficina_db;

-- Tabela de usuários (funcionários/administradores)
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de clientes
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    endereco TEXT,
    cpf_cnpj VARCHAR(18),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de veículos
CREATE TABLE veiculos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    placa VARCHAR(8) NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    ano YEAR NOT NULL,
    cor VARCHAR(30),
    cliente_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

-- Tabela de serviços
CREATE TABLE servicos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    tempo_estimado INT DEFAULT 60, -- em minutos
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de mensagens de contato (opcional)
CREATE TABLE mensagens_contato (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    mensagem TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir dados de exemplo
INSERT INTO usuarios (nome, usuario, email, senha) VALUES 
('Administrador', 'admin', 'admin@oficina.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- senha: password
('João Silva', 'joao', 'joao@oficina.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO clientes (nome, telefone, email, endereco, cpf_cnpj) VALUES 
('Maria Santos', '(41) 99999-1234', 'maria@email.com', 'Rua das Flores, 123', '123.456.789-00'),
('Pedro Oliveira', '(41) 88888-5678', 'pedro@email.com', 'Av. Presidente Vargas, 456', '987.654.321-00'),
('Empresa ABC Ltda', '(41) 77777-9999', 'contato@abc.com', 'Rua Comercial, 789', '12.345.678/0001-90');

INSERT INTO veiculos (placa, marca, modelo, ano, cor, cliente_id) VALUES 
('ABC1234', 'Toyota', 'Corolla', 2020, 'Branco', 1),
('XYZ5678', 'Honda', 'Civic', 2019, 'Preto', 2),
('DEF9012', 'Ford', 'Ka', 2021, 'Vermelho', 1),
('GHI3456', 'Chevrolet', 'Onix', 2022, 'Prata', 3);

INSERT INTO servicos (nome, descricao, preco, tempo_estimado) VALUES 
('Troca de Óleo', 'Troca de óleo do motor e filtro', 80.00, 30),
('Alinhamento', 'Alinhamento de rodas dianteiras', 60.00, 45),
('Balanceamento', 'Balanceamento das 4 rodas', 40.00, 30),
('Lavagem Completa', 'Lavagem externa e interna do veículo', 25.00, 60),
('Lavagem Simples', 'Lavagem externa do veículo', 15.00, 30),
('Troca de Pneus', 'Troca de pneus (por unidade)', 150.00, 20),
('Revisão Geral', 'Revisão completa do veículo', 200.00, 120);