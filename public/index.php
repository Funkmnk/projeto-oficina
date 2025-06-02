<?php
// public/index.php
session_start();
require_once '../config/Database.php';

// Roteamento simples
$page = $_GET['page'] ?? 'home';

// Páginas públicas (sem necessidade de login)
$publicPages = ['home', 'servicos', 'contato'];

// Páginas que requerem login
$privatePages = ['dashboard', 'clientes', 'veiculos', 'admin-servicos', 'logout'];

// Verificar se a página existe
if (!in_array($page, array_merge($publicPages, $privatePages, ['login']))) {
    $page = 'home';
}

// Verificar login para páginas privadas
if (in_array($page, $privatePages)) {
    requireLogin();
}

// Incluir o cabeçalho
include '../app/Views/layouts/header.php';

// Carregar a página solicitada
switch($page) {
    case 'home':
        include '../app/Views/home/index.php';
        break;
    case 'servicos':
        include '../app/Views/home/servicos.php';
        break;
    case 'contato':
        include '../app/Views/home/contato.php';
        break;
    case 'login':
        include '../app/Views/auth/login.php';
        break;
    case 'dashboard':
        include '../app/Views/dashboard/index.php';
        break;
    case 'clientes':
        include '../app/Controllers/ClienteController.php';
        break;
    case 'veiculos':
        include '../app/Controllers/VeiculoController.php';
        break;
    case 'admin-servicos':
        include '../app/Controllers/ServicoController.php';
        break;
    case 'logout':
        include '../app/Controllers/AuthController.php';
        break;
    default:
        include '../app/Views/home/index.php';
}

// Incluir o rodapé
include '../app/Views/layouts/footer.php';
?>