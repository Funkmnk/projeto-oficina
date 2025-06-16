<?php

class Servico {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    public function create($dados) {
        try {
            $sql = "INSERT INTO servicos (nome, descricao, preco, tempo_estimado) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['descricao'],
                $dados['preco'],
                $dados['tempo_estimado']
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function getAll() {
        try {
            $sql = "SELECT * FROM servicos ORDER BY nome";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function getById($id) {
        try {
            $sql = "SELECT * FROM servicos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function update($id, $dados) {
        try {
            $sql = "UPDATE servicos SET nome = ?, descricao = ?, preco = ?, tempo_estimado = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['descricao'],
                $dados['preco'],
                $dados['tempo_estimado'],
                $id
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function delete($id) {
        try {
            $sql = "DELETE FROM servicos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function search($termo) {
        try {
            $sql = "SELECT * FROM servicos 
                    WHERE nome LIKE ? OR descricao LIKE ?
                    ORDER BY nome";
            $termo = "%$termo%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$termo, $termo]);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function validate($dados) {
        $erros = [];
        
        if (empty($dados['nome'])) {
            $erros['nome'] = 'Nome do serviço é obrigatório';
        }
        
        if (empty($dados['preco'])) {
            $erros['preco'] = 'Preço é obrigatório';
        } elseif (!is_numeric($dados['preco']) || $dados['preco'] < 0) {
            $erros['preco'] = 'Preço deve ser um valor numérico positivo';
        }
        
        if (empty($dados['tempo_estimado'])) {
            $erros['tempo_estimado'] = 'Tempo estimado é obrigatório';
        } elseif (!is_numeric($dados['tempo_estimado']) || $dados['tempo_estimado'] <= 0) {
            $erros['tempo_estimado'] = 'Tempo estimado deve ser um número positivo (em minutos)';
        }
        
        return $erros;
    }
    
    public function nomeExists($nome, $id_servico = null) {
        if (empty($nome)) return false;
        
        try {
            $sql = "SELECT id FROM servicos WHERE LOWER(nome) = LOWER(?)";
            $params = [trim($nome)];
            
            if ($id_servico) {
                $sql .= " AND id != ?";
                $params[] = $id_servico;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch() !== false;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function getEstatisticasPrecos() {
        try {
            $sql = "SELECT 
                        MIN(preco) as preco_minimo,
                        MAX(preco) as preco_maximo,
                        AVG(preco) as preco_medio,
                        COUNT(*) as total_servicos
                    FROM servicos";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function getServicosPorFaixaPreco() {
        try {
            $sql = "SELECT 
                        CASE 
                            WHEN preco < 50 THEN 'Até R$ 50'
                            WHEN preco < 100 THEN 'R$ 50 - R$ 100'
                            WHEN preco < 200 THEN 'R$ 100 - R$ 200'
                            ELSE 'Acima de R$ 200'
                        END as faixa_preco,
                        COUNT(*) as total
                    FROM servicos 
                    GROUP BY 
                        CASE 
                            WHEN preco < 50 THEN 'Até R$ 50'
                            WHEN preco < 100 THEN 'R$ 50 - R$ 100'
                            WHEN preco < 200 THEN 'R$ 100 - R$ 200'
                            ELSE 'Acima de R$ 200'
                        END
                    ORDER BY MIN(preco)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function getServicosPorTempo() {
        try {
            $sql = "SELECT 
                        CASE 
                            WHEN tempo_estimado <= 30 THEN 'Até 30 min'
                            WHEN tempo_estimado <= 60 THEN '30 - 60 min'
                            WHEN tempo_estimado <= 120 THEN '1 - 2 horas'
                            ELSE 'Mais de 2 horas'
                        END as faixa_tempo,
                        COUNT(*) as total
                    FROM servicos 
                    GROUP BY 
                        CASE 
                            WHEN tempo_estimado <= 30 THEN 'Até 30 min'
                            WHEN tempo_estimado <= 60 THEN '30 - 60 min'
                            WHEN tempo_estimado <= 120 THEN '1 - 2 horas'
                            ELSE 'Mais de 2 horas'
                        END
                    ORDER BY MIN(tempo_estimado)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function formatarTempo($minutos) {
        if ($minutos < 60) {
            return $minutos . ' min';
        } elseif ($minutos < 1440) {
            $horas = floor($minutos / 60);
            $mins = $minutos % 60;
            if ($mins == 0) {
                return $horas . 'h';
            } else {
                return $horas . 'h' . $mins . 'min';
            }
        } else {
            $dias = floor($minutos / 1440);
            $horas = floor(($minutos % 1440) / 60);
            return $dias . 'd' . ($horas > 0 ? ' ' . $horas . 'h' : '');
        }
    }
}
?>