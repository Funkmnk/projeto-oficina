<?php
// app/Controllers/ClienteController.php

require_once '../app/Models/Cliente.php';

$clienteModel = new Cliente();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$mensagem = '';
$erro = '';

// Processar ações
switch($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'telefone' => $_POST['telefone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'cpf_cnpj' => $_POST['cpf_cnpj'] ?? ''
            ];
            
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (!verifyCSRFToken($csrf_token)) {
                $erro = 'Token de segurança inválido.';
            } else {
                $erros_validacao = $clienteModel->validate($dados);
                
                if (!empty($dados['cpf_cnpj']) && $clienteModel->cpfCnpjExists($dados['cpf_cnpj'])) {
                    $erros_validacao['cpf_cnpj'] = 'CPF/CNPJ já cadastrado para outro cliente';
                }
                
                if (empty($erros_validacao)) {
                    if ($clienteModel->create($dados)) {
                        $mensagem = 'Cliente cadastrado com sucesso!';
                        $dados = []; // Limpar formulário
                    } else {
                        $erro = 'Erro ao cadastrar cliente.';
                    }
                }
            }
        }
        include '../app/Views/clientes/create.php';
        break;
        
    case 'edit':
        if (!$id) {
            redirect('?page=clientes');
        }
        
        $cliente = $clienteModel->getById($id);
        if (!$cliente) {
            redirect('?page=clientes');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'telefone' => $_POST['telefone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'cpf_cnpj' => $_POST['cpf_cnpj'] ?? ''
            ];
            
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (!verifyCSRFToken($csrf_token)) {
                $erro = 'Token de segurança inválido.';
            } else {
                $erros_validacao = $clienteModel->validate($dados);
                
                if (!empty($dados['cpf_cnpj']) && $clienteModel->cpfCnpjExists($dados['cpf_cnpj'], $id)) {
                    $erros_validacao['cpf_cnpj'] = 'CPF/CNPJ já cadastrado para outro cliente';
                }
                
                if (empty($erros_validacao)) {
                    if ($clienteModel->update($id, $dados)) {
                        $mensagem = 'Cliente atualizado com sucesso!';
                        $cliente = $clienteModel->getById($id); // Recarregar dados
                    } else {
                        $erro = 'Erro ao atualizar cliente.';
                    }
                } else {
                    // Manter dados do formulário em caso de erro
                    $cliente = array_merge($cliente, $dados);
                }
            }
        }
        include '../app/Views/clientes/edit.php';
        break;
        
    case 'delete':
        if (!$id) {
            redirect('?page=clientes');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (verifyCSRFToken($csrf_token)) {
                $resultado = $clienteModel->delete($id);
                if ($resultado['success']) {
                    redirect('?page=clientes&msg=deleted');
                } else {
                    redirect('?page=clientes&error=' . urlencode($resultado['message']));
                }
            } else {
                redirect('?page=clientes&error=Token inválido');
            }
        }
        
        $cliente = $clienteModel->getById($id);
        if (!$cliente) {
            redirect('?page=clientes');
        }
        include '../app/Views/clientes/delete.php';
        break;
        
    case 'view':
        if (!$id) {
            redirect('?page=clientes');
        }
        
        $cliente = $clienteModel->getById($id);
        if (!$cliente) {
            redirect('?page=clientes');
        }
        
        // Buscar veículos do cliente
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM veiculos WHERE cliente_id = ? ORDER BY modelo");
            $stmt->execute([$id]);
            $veiculos = $stmt->fetchAll();
        } catch(PDOException $e) {
            $veiculos = [];
        }
        
        include '../app/Views/clientes/view.php';
        break;
        
    default: // 'index'
        // Busca
        $termo_busca = $_GET['busca'] ?? '';
        if (!empty($termo_busca)) {
            $clientes = $clienteModel->search($termo_busca);
        } else {
            $clientes = $clienteModel->getAll();
        }
        
        // Mensagens de retorno
        if (isset($_GET['msg'])) {
            switch($_GET['msg']) {
                case 'deleted':
                    $mensagem = 'Cliente excluído com sucesso!';
                    break;
            }
        }
        
        if (isset($_GET['error'])) {
            $erro = $_GET['error'];
        }
        
        include '../app/Views/clientes/index.php';
        break;
}
?>