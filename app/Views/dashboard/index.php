<?php

try {
    $db = getDB();
    
    // Contar clientes
    $stmt = $db->query("SELECT COUNT(*) as total FROM clientes");
    $total_clientes = $stmt->fetch()['total'];
    
    // Contar veículos
    $stmt = $db->query("SELECT COUNT(*) as total FROM veiculos");
    $total_veiculos = $stmt->fetch()['total'];
    
    // Contar serviços
    $stmt = $db->query("SELECT COUNT(*) as total FROM servicos");
    $total_servicos = $stmt->fetch()['total'];
    
    // Contar mensagens de contato
    $stmt = $db->query("SELECT COUNT(*) as total FROM mensagens_contato WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $mensagens_mes = $stmt->fetch()['total'];
    
    // Últimos clientes cadastrados
    $stmt = $db->query("SELECT nome, telefone, created_at FROM clientes ORDER BY created_at DESC LIMIT 5");
    $ultimos_clientes = $stmt->fetchAll();
    
    // Últimas mensagens de contato
    $stmt = $db->query("SELECT nome, email, mensagem, created_at FROM mensagens_contato ORDER BY created_at DESC LIMIT 5");
    $ultimas_mensagens = $stmt->fetchAll();
    
} catch(PDOException $e) {
    $erro = "Erro ao carregar dados: " . $e->getMessage();
}
?>

<div class="card">
    <div class="card-header">
        <h1>Dashboard - Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h1>
    </div>
    <div class="card-body">
        <p>Aqui você pode gerenciar todos os aspectos da oficina: clientes, veículos e serviços.</p>
    </div>
</div>

<?php if (isset($erro)): ?>
    <div class="alert alert-error">
        <?= $erro ?>
    </div>
<?php endif; ?>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-number"><?= $total_clientes ?? 0 ?></div>
        <div class="stat-label">Clientes Cadastrados</div>
        <a href="?page=clientes" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
            Gerenciar Clientes
        </a>
    </div>
    
    <div class="stat-card" style="border-left-color: #28a745;">
        <div class="stat-number" style="color: #28a745;"><?= $total_veiculos ?? 0 ?></div>
        <div class="stat-label">Veículos Cadastrados</div>
        <a href="?page=veiculos" class="btn btn-success btn-sm" style="margin-top: 1rem;">
            Gerenciar Veículos
        </a>
    </div>
    
    <div class="stat-card" style="border-left-color: #ffc107;">
        <div class="stat-number" style="color: #ffc107;"><?= $total_servicos ?? 0 ?></div>
        <div class="stat-label">Serviços Disponíveis</div>
        <a href="?page=admin-servicos" class="btn btn-warning btn-sm" style="margin-top: 1rem;">
            Gerenciar Serviços
        </a>
    </div>
    
    <div class="stat-card" style="border-left-color: #dc3545;">
        <div class="stat-number" style="color: #dc3545;"><?= $mensagens_mes ?? 0 ?></div>
        <div class="stat-label">Mensagens este Mês</div>
        <a href="#mensagens" class="btn btn-danger btn-sm" style="margin-top: 1rem;">
            Ver Mensagens
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Últimos Clientes Cadastrados</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($ultimos_clientes)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ultimos_clientes as $cliente): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($cliente['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="?page=clientes" class="btn btn-primary btn-sm">Ver Todos os Clientes</a>
                <?php else: ?>
                    <p style="text-align: center; color: #6c757d;">Nenhum cliente cadastrado ainda.</p>
                    <a href="?page=clientes&action=create" class="btn btn-primary">Cadastrar Primeiro Cliente</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 id="mensagens">Últimas Mensagens de Contato</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($ultimas_mensagens)): ?>
                    <?php foreach($ultimas_mensagens as $mensagem): ?>
                        <div style="border-bottom: 1px solid #eee; padding-bottom: 1rem; margin-bottom: 1rem;">
                            <strong><?= htmlspecialchars($mensagem['nome']) ?></strong>
                            <small style="color: #6c757d; float: right;">
                                <?= date('d/m/Y H:i', strtotime($mensagem['created_at'])) ?>
                            </small>
                            <br>
                            <small style="color: #6c757d;"><?= htmlspecialchars($mensagem['email']) ?></small>
                            <p style="margin: 0.5rem 0; font-size: 0.9rem;">
                                <?= htmlspecialchars(substr($mensagem['mensagem'], 0, 100)) ?>
                                <?= strlen($mensagem['mensagem']) > 100 ? '...' : '' ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #6c757d;">Nenhuma mensagem recebida ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Ações Rápidas</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <a href="?page=clientes&action=create" class="btn btn-primary" style="width: 100%; margin-bottom: 0.5rem;">
                    ➕ Novo Cliente
                </a>
            </div>
            <div class="col-md-3">
                <a href="?page=veiculos&action=create" class="btn btn-success" style="width: 100%; margin-bottom: 0.5rem;">
                    🚗 Novo Veículo
                </a>
            </div>
            <div class="col-md-3">
                <a href="?page=admin-servicos&action=create" class="btn btn-warning" style="width: 100%; margin-bottom: 0.5rem;">
                    🔧 Novo Serviço
                </a>
            </div>
            <div class="col-md-3">
                <a href="?page=home" class="btn btn-secondary" style="width: 100%; margin-bottom: 0.5rem;">
                    🌐 Ver Site Público
                </a>
            </div>
        </div>
    </div>
</div>