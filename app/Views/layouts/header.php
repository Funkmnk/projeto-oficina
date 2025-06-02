<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1><?= APP_NAME ?></h1>
                </div>
                <nav class="nav">
                    <ul>
                        <?php if (!isLoggedIn()): ?>
                            <li><a href="?page=home" class="<?= ($page == 'home') ? 'active' : '' ?>">Início</a></li>
                            <li><a href="?page=servicos" class="<?= ($page == 'servicos') ? 'active' : '' ?>">Serviços</a></li>
                            <li><a href="?page=contato" class="<?= ($page == 'contato') ? 'active' : '' ?>">Contato</a></li>
                            <li><a href="?page=login" class="<?= ($page == 'login') ? 'active' : '' ?>">Login</a></li>
                        <?php else: ?>
                            <li><a href="?page=dashboard" class="<?= ($page == 'dashboard') ? 'active' : '' ?>">Dashboard</a></li>
                            <li><a href="?page=clientes" class="<?= ($page == 'clientes') ? 'active' : '' ?>">Clientes</a></li>
                            <li><a href="?page=veiculos" class="<?= ($page == 'veiculos') ? 'active' : '' ?>">Veículos</a></li>
                            <li><a href="?page=admin-servicos" class="<?= ($page == 'admin-servicos') ? 'active' : '' ?>">Serviços</a></li>
                            <li><a href="?page=logout">Sair (<?= $_SESSION['usuario_nome'] ?>)</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">