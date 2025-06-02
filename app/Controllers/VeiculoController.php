<?php
// app/Controllers/VeiculoController.php

require_once '../app/Models/Veiculo.php';

$veiculoModel = new Veiculo();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;
$cliente_id = $_GET['cliente_id'] ?? null;

$mensagem = '';
$erro = '';

// Processar ações
switch($action) {
    case 'create':
        $clientes = $veiculoModel->getAllClientes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'placa' => strtoupper(str_replace('-', '', $_POST['placa'] ?? '')),
                'marca' => $_POST['marca'] ?? '',
                'modelo' => $_POST['modelo'] ?? '',
                'ano' => $_POST['ano'] ?? '',
                'cor' => $_POST['cor'] ?? '',
                'cliente_id' => $_POST['cliente_id'] ?? ''
            ];
            
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (!verifyCSRFToken($csrf_token)) {
                $erro = 'Token de segurança inválido.';
            } else {
                $erros_validacao = $veiculoModel->validate($dados);
                
                if (!$veiculoModel->clienteExists($dados['cliente_id'])) {
                    $erros_validacao['cliente_id'] = 'Cliente não encontrado';
                }
                
                if (!empty($dados['placa']) && $veiculoModel->placaExists($dados['placa'])) {
                    $erros_validacao['placa'] = 'Esta placa já está cadastrada para outro veículo';
                }
                
                if (empty($erros_validacao)) {
                    if ($veiculoModel->create($dados)) {
                        $mensagem = 'Veículo cadastrado com sucesso!';
                        $dados = []; // Limpar formulário
                        // Manter cliente selecionado se veio por parâmetro
                        if ($cliente_id) {
                            $dados['cliente_id'] = $cliente_id;
                        }
                    } else {
                        $erro = 'Erro ao cadastrar veículo.';
                    }
                }
            }
        } else {
            // Pré-selecionar cliente se veio por parâmetro
            if ($cliente_id) {
                $dados['cliente_id'] = $cliente_id;
            }
        }
        include '../app/Views/veiculos/create.php';
        break;
        
    case 'edit':
        if (!$id) {
            redirect('?page=veiculos');
        }
        
        $veiculo = $veiculoModel->getById($id);
        if (!$veiculo) {
            redirect('?page=veiculos');
        }
        
        $clientes = $veiculoModel->getAllClientes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'placa' => strtoupper(str_replace('-', '', $_POST['placa'] ?? '')),
                'marca' => $_POST['marca'] ?? '',
                'modelo' => $_POST['modelo'] ?? '',
                'ano' => $_POST['ano'] ?? '',
                'cor' => $_POST['cor'] ?? '',
                'cliente_id' => $_POST['cliente_id'] ?? ''
            ];
            
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (!verifyCSRFToken($csrf_token)) {
                $erro = 'Token de segurança inválido.';
            } else {
                $erros_validacao = $veiculoModel->validate($dados);
                
                if (!$veiculoModel->clienteExists($dados['cliente_id'])) {
                    $erros_validacao['cliente_id'] = 'Cliente não encontrado';
                }
                
                if (!empty($dados['placa']) && $veiculoModel->placaExists($dados['placa'], $id)) {
                    $erros_validacao['placa'] = 'Esta placa já está cadastrada para outro veículo';
                }
                
                if (empty($erros_validacao)) {
                    if ($veiculoModel->update($id, $dados)) {
                        $mensagem = 'Veículo atualizado com sucesso!';
                        $veiculo = $veiculoModel->getById($id); // Recarregar dados
                    } else {
                        $erro = 'Erro ao atualizar veículo.';
                    }
                } else {
                    // Manter dados do formulário em caso de erro
                    $veiculo = array_merge($veiculo, $dados);
                }
            }
        }
        include '../app/Views/veiculos/edit.php';
        break;
        
    case 'delete':
        if (!$id) {
            redirect('?page=veiculos');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            
            if (verifyCSRFToken($csrf_token)) {
                if ($veiculoModel->delete($id)) {
                    redirect('?page=veiculos&msg=deleted');
                } else {
                    redirect('?page=veiculos&error=Erro ao excluir veículo');
                }
            } else {
                redirect('?page=veiculos&error=Token inválido');
            }
        }
        
        $veiculo = $veiculoModel->getById($id);
        if (!$veiculo) {
            redirect('?page=veiculos');
        }
        include '../app/Views/veiculos/delete.php';
        break;
        
    case 'view':
        if (!$id) {
            redirect('?page=veiculos');
        }
        
        $veiculo = $veiculoModel->getById($id);
        if (!$veiculo) {
            redirect('?page=veiculos');
        }
        
        include '../app/Views/veiculos/view.php';
        break;
        
    default: // 'index'
        // Busca
        $termo_busca = $_GET['busca'] ?? '';
        if (!empty($termo_busca)) {
            $veiculos = $veiculoModel->search($termo_busca);
        } else {
            $veiculos = $veiculoModel->getAll();
        }
        
        // Estatísticas para dashboard
        $stats_marcas = $veiculoModel->getEstatisticasPorMarca();
        $stats_anos = $veiculoModel->getEstatisticasPorAno();
        
        // Mensagens de retorno
        if (isset($_GET['msg'])) {
            switch($_GET['msg']) {
                case 'deleted':
                    $mensagem = 'Veículo excluído com sucesso!';
                    break;
            }
        }
        
        if (isset($_GET['error'])) {
            $erro = $_GET['error'];
        }
        
        include '../app/Views/veiculos/index.php';
        break;
}
?>