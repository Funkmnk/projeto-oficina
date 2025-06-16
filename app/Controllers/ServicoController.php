<?php

require_once '../app/Models/Servico.php';

$servicoModel = new Servico();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$mensagem = '';
$erro = '';

switch($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'descricao' => $_POST['descricao'] ?? '',
                'preco' => str_replace(',', '.', $_POST['preco'] ?? ''),
                'tempo_estimado' => $_POST['tempo_estimado'] ?? ''
            ];
            
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (!verifyCSRFToken($csrf_token)) {
                $erro = 'Token de segurança inválido.';
            } else {
                $erros_validacao = $servicoModel->validate($dados);
                
                if (!empty($dados['nome']) && $servicoModel->nomeExists($dados['nome'])) {
                    $erros_validacao['nome'] = 'Já existe um serviço com este nome';
                }
                
                if (empty($erros_validacao)) {
                    if ($servicoModel->create($dados)) {
                        $mensagem = 'Serviço cadastrado com sucesso!';
                        $dados = []; // Limpar formulário
                    } else {
                        $erro = 'Erro ao cadastrar serviço.';
                    }
                }
            }
        }
        include '../app/Views/servicos/create.php';
        break;
        
    case 'edit':
        if (!$id) {
            redirect('?page=admin-servicos');
        }
        
        $servico = $servicoModel->getById($id);
        if (!$servico) {
            redirect('?page=admin-servicos');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'descricao' => $_POST['descricao'] ?? '',
                'preco' => str_replace(',', '.', $_POST['preco'] ?? ''),
                'tempo_estimado' => $_POST['tempo_estimado'] ?? ''
            ];
            
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (!verifyCSRFToken($csrf_token)) {
                $erro = 'Token de segurança inválido.';
            } else {
                $erros_validacao = $servicoModel->validate($dados);
                
                if (!empty($dados['nome']) && $servicoModel->nomeExists($dados['nome'], $id)) {
                    $erros_validacao['nome'] = 'Já existe um serviço com este nome';
                }
                
                if (empty($erros_validacao)) {
                    if ($servicoModel->update($id, $dados)) {
                        $mensagem = 'Serviço atualizado com sucesso!';
                        $servico = $servicoModel->getById($id);
                    } else {
                        $erro = 'Erro ao atualizar serviço.';
                    }
                } else {
                    $servico = array_merge($servico, $dados);
                }
            }
        }
        include '../app/Views/servicos/edit.php';
        break;
        
    case 'delete':
        if (!$id) {
            redirect('?page=admin-servicos');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            $confirmacao = $_POST['confirmacao'] ?? '';
            
            if (verifyCSRFToken($csrf_token) && strtoupper($confirmacao) === 'EXCLUIR') {
                if ($servicoModel->delete($id)) {
                    redirect('?page=admin-servicos&msg=deleted');
                } else {
                    redirect('?page=admin-servicos&error=Erro ao excluir serviço');
                }
            } else {
                redirect('?page=admin-servicos&error=Confirmação inválida ou token expirado');
            }
        }
        
        $servico = $servicoModel->getById($id);
        if (!$servico) {
            redirect('?page=admin-servicos');
        }
        include '../app/Views/servicos/delete.php';
        break;
        
    case 'view':
        if (!$id) {
            redirect('?page=admin-servicos');
        }
        
        $servico = $servicoModel->getById($id);
        if (!$servico) {
            redirect('?page=admin-servicos');
        }
        
        include '../app/Views/servicos/view.php';
        break;
        
    default:
        $termo_busca = $_GET['busca'] ?? '';
        if (!empty($termo_busca)) {
            $servicos = $servicoModel->search($termo_busca);
        } else {
            $servicos = $servicoModel->getAll();
        }
        
        $stats_precos = $servicoModel->getEstatisticasPrecos();
        $stats_faixa_preco = $servicoModel->getServicosPorFaixaPreco();
        $stats_tempo = $servicoModel->getServicosPorTempo();
        
        if (isset($_GET['msg'])) {
            switch($_GET['msg']) {
                case 'deleted':
                    $mensagem = 'Serviço excluído com sucesso!';
                    break;
            }
        }
        
        if (isset($_GET['error'])) {
            $erro = $_GET['error'];
        }
        
        include '../app/Views/servicos/index.php';
        break;
}
?>