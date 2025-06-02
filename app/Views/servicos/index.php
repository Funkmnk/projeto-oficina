<?php
// app/Views/servicos/index.php
?>

<div class="card">
    <div class="card-header">
        <h1>Gerenciar Serviços</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a href="?page=admin-servicos&action=create" class="btn btn-primary">
                    🔧 Novo Serviço
                </a>
            </div>
            <div class="col-md-6">
                <form method="GET" style="display: flex; gap: 0.5rem;">
                    <input type="hidden" name="page" value="admin-servicos">
                    <input type="text" class="form-control" name="busca" 
                           placeholder="Buscar por nome ou descrição"
                           value="<?= htmlspecialchars($termo_busca) ?>">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                    <?php if (!empty($termo_busca)): ?>
                        <a href="?page=admin-servicos" class="btn btn-warning">Limpar</a>
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
        (<?= count($servicos) ?> resultado<?= count($servicos) != 1 ? 's' : '' ?> encontrado<?= count($servicos) != 1 ? 's' : '' ?>)
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Lista de Serviços (<?= count($servicos) ?> total)</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($servicos)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome do Serviço</th>
                                    <th>Preço</th>
                                    <th>Tempo Estimado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($servicos as $servico): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($servico['nome']) ?></strong>
                                            <?php if (!empty($servico['descricao'])): ?>
                                                <br>
                                                <small style="color: #6c757d;">
                                                    <?= htmlspecialchars(substr($servico['descricao'], 0, 100)) ?>
                                                    <?= strlen($servico['descricao']) > 100 ? '...' : '' ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong style="color: #28a745;">
                                                R$ <?= number_format($servico['preco'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #007bff; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                                <?= $servicoModel->formatarTempo($servico['tempo_estimado']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                                                <a href="?page=admin-servicos&action=view&id=<?= $servico['id'] ?>" 
                                                   class="btn btn-primary btn-sm" title="Ver detalhes">
                                                    👁️
                                                </a>
                                                <a href="?page=admin-servicos&action=edit&id=<?= $servico['id'] ?>" 
                                                   class="btn btn-warning btn-sm" title="Editar">
                                                    ✏️
                                                </a>
                                                <a href="?page=admin-servicos&action=delete&id=<?= $servico['id'] ?>" 
                                                   class="btn btn-danger btn-sm" title="Excluir"
                                                   onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
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
                                Nenhum serviço encontrado para a busca
                            <?php else: ?>
                                Nenhum serviço cadastrado
                            <?php endif; ?>
                        </h3>
                        <p style="color: #6c757d;">
                            <?php if (!empty($termo_busca)): ?>
                                Tente buscar por outros termos ou <a href="?page=admin-servicos">ver todos os serviços</a>.
                            <?php else: ?>
                                Comece cadastrando o primeiro serviço.
                            <?php endif; ?>
                        </p>
                        <a href="?page=admin-servicos&action=create" class="btn btn-primary">
                            🔧 Cadastrar Serviço
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Estatísticas de Preços -->
        <?php if ($stats_precos && $stats_precos['total_servicos'] > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h3>Estatísticas de Preços</h3>
                </div>
                <div class="card-body">
                    <div style="text-align: center;">
                        <div class="stat-card" style="margin-bottom: 1rem;">
                            <div class="stat-number" style="color: #28a745; font-size: 1.5rem;">
                                R$ <?= number_format($stats_precos['preco_medio'], 2, ',', '.') ?>
                            </div>
                            <div class="stat-label">Preço Médio</div>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
                            <div style="text-align: center;">
                                <strong style="color: #007bff;">R$ <?= number_format($stats_precos['preco_minimo'], 2, ',', '.') ?></strong>
                                <br><small>Mínimo</small>
                            </div>
                            <div style="text-align: center;">
                                <strong style="color: #dc3545;">R$ <?= number_format($stats_precos['preco_maximo'], 2, ',', '.') ?></strong>
                                <br><small>Máximo</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Serviços por Faixa de Preço -->
        <div class="card">
            <div class="card-header">
                <h3>Serviços por Preço</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($stats_faixa_preco)): ?>
                    <?php foreach($stats_faixa_preco as $stat): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.9rem;"><?= htmlspecialchars($stat['faixa_preco']) ?></span>
                            <span class="badge" style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                <?= $stat['total'] ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #6c757d; text-align: center;">Nenhum dado disponível</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Serviços por Tempo -->
        <div class="card">
            <div class="card-header">
                <h3>Serviços por Tempo</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($stats_tempo)): ?>
                    <?php foreach($stats_tempo as $stat): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.9rem;"><?= htmlspecialchars($stat['faixa_tempo']) ?></span>
                            <span class="badge" style="background: #007bff; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                <?= $stat['total'] ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
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
                    <a href="?page=admin-servicos&action=create" class="btn btn-primary">
                        🔧 Novo Serviço
                    </a>
                    <a href="?page=servicos" class="btn btn-success" target="_blank">
                        🌐 Ver Site Público
                    </a>
                    <a href="?page=clientes" class="btn btn-secondary">
                        👤 Gerenciar Clientes
                    </a>
                    <a href="?page=dashboard" class="btn btn-secondary">
                        📊 Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>