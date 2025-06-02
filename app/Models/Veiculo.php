<?php
// app/Models/Veiculo.php

class Veiculo {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    // Criar novo veículo
    public function create($dados) {
        try {
            $sql = "INSERT INTO veiculos (placa, marca, modelo, ano, cor, cliente_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $dados['placa'],
                $dados['marca'],
                $dados['modelo'],
                $dados['ano'],
                $dados['cor'],
                $dados['cliente_id']
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Listar todos os veículos com dados do cliente
    public function getAll() {
        try {
            $sql = "SELECT v.*, c.nome as cliente_nome, c.telefone as cliente_telefone 
                    FROM veiculos v 
                    JOIN clientes c ON v.cliente_id = c.id 
                    ORDER BY v.marca, v.modelo";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Buscar veículo por ID
    public function getById($id) {
        try {
            $sql = "SELECT v.*, c.nome as cliente_nome, c.telefone as cliente_telefone, c.email as cliente_email 
                    FROM veiculos v 
                    JOIN clientes c ON v.cliente_id = c.id 
                    WHERE v.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Listar veículos por cliente
    public function getByClienteId($cliente_id) {
        try {
            $sql = "SELECT * FROM veiculos WHERE cliente_id = ? ORDER BY modelo";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cliente_id]);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Atualizar veículo
    public function update($id, $dados) {
        try {
            $sql = "UPDATE veiculos SET placa = ?, marca = ?, modelo = ?, ano = ?, cor = ?, cliente_id = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $dados['placa'],
                $dados['marca'],
                $dados['modelo'],
                $dados['ano'],
                $dados['cor'],
                $dados['cliente_id'],
                $id
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Deletar veículo
    public function delete($id) {
        try {
            $sql = "DELETE FROM veiculos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Buscar veículos por termo
    public function search($termo) {
        try {
            $sql = "SELECT v.*, c.nome as cliente_nome, c.telefone as cliente_telefone 
                    FROM veiculos v 
                    JOIN clientes c ON v.cliente_id = c.id 
                    WHERE v.placa LIKE ? OR v.marca LIKE ? OR v.modelo LIKE ? OR c.nome LIKE ?
                    ORDER BY v.marca, v.modelo";
            $termo = "%$termo%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$termo, $termo, $termo, $termo]);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Validar dados do veículo
    public function validate($dados) {
        $erros = [];
        
        if (empty($dados['placa'])) {
            $erros['placa'] = 'Placa é obrigatória';
        } elseif (!preg_match('/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/', strtoupper(str_replace('-', '', $dados['placa'])))) {
            $erros['placa'] = 'Formato de placa inválido (Ex: ABC1234 ou ABC1D23)';
        }
        
        if (empty($dados['marca'])) {
            $erros['marca'] = 'Marca é obrigatória';
        }
        
        if (empty($dados['modelo'])) {
            $erros['modelo'] = 'Modelo é obrigatório';
        }
        
        if (empty($dados['ano'])) {
            $erros['ano'] = 'Ano é obrigatório';
        } elseif (!is_numeric($dados['ano']) || $dados['ano'] < 1900 || $dados['ano'] > (date('Y') + 1)) {
            $erros['ano'] = 'Ano deve estar entre 1900 e ' . (date('Y') + 1);
        }
        
        if (empty($dados['cor'])) {
            $erros['cor'] = 'Cor é obrigatória';
        }
        
        if (empty($dados['cliente_id']) || !is_numeric($dados['cliente_id'])) {
            $erros['cliente_id'] = 'Cliente é obrigatório';
        }
        
        return $erros;
    }
    
    // Verificar se placa já existe (para outro veículo)
    public function placaExists($placa, $id_veiculo = null) {
        if (empty($placa)) return false;
        
        try {
            // Normalizar placa (remover hífen e converter para maiúsculo)
            $placa_normalizada = strtoupper(str_replace('-', '', $placa));
            
            $sql = "SELECT id FROM veiculos WHERE UPPER(REPLACE(placa, '-', '')) = ?";
            $params = [$placa_normalizada];
            
            if ($id_veiculo) {
                $sql .= " AND id != ?";
                $params[] = $id_veiculo;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch() !== false;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Verificar se cliente existe
    public function clienteExists($cliente_id) {
        try {
            $sql = "SELECT id FROM clientes WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cliente_id]);
            return $stmt->fetch() !== false;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Listar todos os clientes para dropdown
    public function getAllClientes() {
        try {
            $sql = "SELECT id, nome, telefone FROM clientes ORDER BY nome";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Obter estatísticas de veículos por marca
    public function getEstatisticasPorMarca() {
        try {
            $sql = "SELECT marca, COUNT(*) as total FROM veiculos GROUP BY marca ORDER BY total DESC, marca";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Obter estatísticas de veículos por ano
    public function getEstatisticasPorAno() {
        try {
            $sql = "SELECT ano, COUNT(*) as total FROM veiculos GROUP BY ano ORDER BY ano DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>