<?php
// app/Models/Cliente.php

class Cliente {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    // Criar novo cliente
    public function create($dados) {
        try {
            $sql = "INSERT INTO clientes (nome, telefone, email, endereco, cpf_cnpj) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['telefone'],
                $dados['email'],
                $dados['endereco'],
                $dados['cpf_cnpj']
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Listar todos os clientes
    public function getAll() {
        try {
            $sql = "SELECT *, 
                    (SELECT COUNT(*) FROM veiculos WHERE cliente_id = clientes.id) as total_veiculos 
                    FROM clientes ORDER BY nome";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Buscar cliente por ID
    public function getById($id) {
        try {
            $sql = "SELECT * FROM clientes WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Atualizar cliente
    public function update($id, $dados) {
        try {
            $sql = "UPDATE clientes SET nome = ?, telefone = ?, email = ?, endereco = ?, cpf_cnpj = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['telefone'],
                $dados['email'],
                $dados['endereco'],
                $dados['cpf_cnpj'],
                $id
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Deletar cliente
    public function delete($id) {
        try {
            // Verificar se há veículos associados
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM veiculos WHERE cliente_id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'Não é possível excluir cliente que possui veículos cadastrados.'];
            }
            
            $sql = "DELETE FROM clientes WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $success = $stmt->execute([$id]);
            
            return ['success' => $success, 'message' => $success ? 'Cliente excluído com sucesso.' : 'Erro ao excluir cliente.'];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Erro no banco de dados.'];
        }
    }
    
    // Buscar clientes por termo
    public function search($termo) {
        try {
            $sql = "SELECT *, 
                    (SELECT COUNT(*) FROM veiculos WHERE cliente_id = clientes.id) as total_veiculos 
                    FROM clientes 
                    WHERE nome LIKE ? OR telefone LIKE ? OR email LIKE ? OR cpf_cnpj LIKE ?
                    ORDER BY nome";
            $termo = "%$termo%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$termo, $termo, $termo, $termo]);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Validar dados do cliente
    public function validate($dados) {
        $erros = [];
        
        if (empty($dados['nome'])) {
            $erros['nome'] = 'Nome é obrigatório';
        }
        
        if (empty($dados['telefone'])) {
            $erros['telefone'] = 'Telefone é obrigatório';
        }
        
        if (!empty($dados['email']) && !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $erros['email'] = 'Email inválido';
        }
        
        return $erros;
    }
    
    // Verificar se CPF/CNPJ já existe (para outro cliente)
    public function cpfCnpjExists($cpf_cnpj, $id_cliente = null) {
        if (empty($cpf_cnpj)) return false;
        
        try {
            $sql = "SELECT id FROM clientes WHERE cpf_cnpj = ?";
            $params = [$cpf_cnpj];
            
            if ($id_cliente) {
                $sql .= " AND id != ?";
                $params[] = $id_cliente;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch() !== false;
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>