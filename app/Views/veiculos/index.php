<?php
// app/Views/veiculos/index.php
?>

<div class="card">
    <div class="card-header">
        <h1>Gerenciar Veículos</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a href="?page=veiculos&action=create" class="btn btn-primary">
                    🚗 Novo Veículo
                </a>
            </div>
            <div class="col-md-6">
                <form method="GET" style="display: flex; gap: 0.5rem;">
                    <input type="hidden" name="page" value="veiculos">
                    <input type="text" class="form-control" name="busca" 
                           placeholder="Buscar por placa, marca, modelo ou cliente"
                           value="<?= htmlspecialchars($termo_busca) ?>">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                    <?php if (!empty($termo_busca)): ?>
                        <a href="?page=veiculos" class="btn btn-warning">Limpar</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($mensagem)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($mensagem) ?>
    </div>
<?php endif; ?>

<?php if (!empty($erro)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($erro) ?>
    </div>
<?php endif; ?>

<?php if (!empty($termo_busca)): ?>
    <div class="alert alert-info">
        Resultados da busca por: <strong><?= htmlspecialchars($termo_busca) ?></strong>
        (<?= count($veiculos) ?> resultado<?= count($veiculos) != 1 ? 's' : '' ?> encontrado<?= count($veiculos) != 1 ? 's' : '' ?>)
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Lista de Veículos (<?= count($veiculos) ?> total)</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($veiculos)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Placa</th>
                                    <th>Veículo</th>
                                    <th>Ano</th>
                                    <th>Cor</th>
                                    <th>Cliente</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($veiculos as $veiculo): ?>
                                    <tr>
                                        <td>
                                            <strong style="font-family: monospace; background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                                <?= htmlspecialchars($veiculo['placa']) ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($veiculo['marca']) ?></strong><br>
                                            <small style="color: #6c757d;"><?= htmlspecialchars($veiculo['modelo']) ?></small>
                                        </td>
                                        <td><?= $veiculo['ano'] ?></td>
                                        <td><?= htmlspecialchars($veiculo['cor']) ?></td>
                                        <td>
                                            <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>" 
                                               style="text-decoration: none;">
                                                <?= htmlspecialchars($veiculo['cliente_nome']) ?>
                                            </a>
                                            <br>
                                            <small style="color: #6c757d;">
                                                <?= htmlspecialchars($veiculo['cliente_telefone']) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                                                <a href="?page=veiculos&action=view&id=<?= $veiculo['id'] ?>" 
                                                   class="btn btn-primary btn-sm" title="Ver detalhes">
                                                    👁️
                                                </a>
                                                <a href="?page=veiculos&action=edit&id=<?= $veiculo['id'] ?>" 
                                                   class="btn btn-warning btn-sm" title="Editar">
                                                    ✏️
                                                </a>
                                                <a href="?page=veiculos&action=delete&id=<?= $veiculo['id'] ?>" 
                                                   class="btn btn-danger btn-sm" title="Excluir"
                                                   onclick="return confirm('Tem certeza que deseja excluir este veículo?')">
                                                    🗑️
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem;">
                        <h3 style="color: #6c757d;">
                            <?php if (!empty($termo_busca)): ?>
                                Nenhum veículo encontrado para a busca
                            <?php else: ?>
                                Nenhum veículo cadastrado
                            <?php endif; ?>
                        </h3>
                        <p style="color: #6c757d;">
                            <?php if (!empty($termo_busca)): ?>
                                Tente buscar por outros termos ou <a href="?page=veiculos">ver todos os veículos</a>.
                            <?php else: ?>
                                Comece cadastrando o primeiro veículo.
                            <?php endif; ?>
                        </p>
                        <a href="?page=veiculos&action=create" class="btn btn-primary">
                            🚗 Cadastrar Veículo
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Estatísticas por Marca -->
        <div class="card">
            <div class="card-header">
                <h3>Veículos por Marca</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($stats_marcas)): ?>
                    <?php foreach(array_slice($stats_marcas, 0, 5) as $stat): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span><?= htmlspecialchars($stat['marca']) ?></span>
                            <span class="badge" style="background: #007bff; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                <?= $stat['total'] ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (count($stats_marcas) > 5): ?>
                        <small style="color: #6c757d;">
                            + <?= count($stats_marcas) - 5 ?> outras marcas
                        </small>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="color: #6c757d; text-align: center;">Nenhum dado disponível</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Estatísticas por Ano -->
        <div class="card">
            <div class="card-header">
                <h3>Veículos por Ano</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($stats_anos)): ?>
                    <?php foreach(array_slice($stats_anos, 0, 5) as $stat): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span><?= $stat['ano'] ?></span>
                            <span class="badge" style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                <?= $stat['total'] ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (count($stats_anos) > 5): ?>
                        <small style="color: #6c757d;">
                            + <?= count($stats_anos) - 5 ?> outros anos
                        </small>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="color: #6c757d; text-align: center;">Nenhum dado disponível</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Ações Rápidas -->
        <div class="card">
            <div class="card-header">
                <h3>Ações Rápidas</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <a href="?page=veiculos&action=create" class="btn btn-primary">
                        🚗 Novo Veículo
                    </a>
                    <a href="?page=clientes&action=create" class="btn btn-success">
                        👤 Novo Cliente
                    </a>
                    <a href="?page=clientes" class="btn btn-secondary">
                        📋 Ver Clientes
                    </a>
                    <a href="?page=dashboard" class="btn btn-secondary">
                        📊 Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>