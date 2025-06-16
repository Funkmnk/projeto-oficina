<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Cadastrar Novo Veículo</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=veiculos" class="btn btn-secondary">← Voltar para Lista</a>
            <?php if ($cliente_id): ?>
                <a href="?page=clientes&action=view&id=<?= $cliente_id ?>" class="btn btn-primary">👁️ Ver Cliente</a>
            <?php endif; ?>
        </nav>
    </div>
</div>

<?php if (!empty($mensagem)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($mensagem) ?>
        <div style="margin-top: 1rem;">
            <a href="?page=veiculos" class="btn btn-primary">Ver Lista de Veículos</a>
            <a href="?page=veiculos&action=create" class="btn btn-success">Cadastrar Outro Veículo</a>
            <?php if (!empty($dados['cliente_id'])): ?>
                <a href="?page=clientes&action=view&id=<?= $dados['cliente_id'] ?>" class="btn btn-warning">Ver Cliente</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($erro)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($erro) ?>
    </div>
<?php endif; ?>

<?php if (empty($clientes)): ?>
    <div class="alert alert-error">
        <strong>⚠️ Atenção!</strong> Não há clientes cadastrados no sistema.
        <br>É necessário ter pelo menos um cliente cadastrado para registrar um veículo.
        <div style="margin-top: 1rem;">
            <a href="?page=clientes&action=create" class="btn btn-primary">
                👤 Cadastrar Cliente Primeiro
            </a>
        </div>
    </div>
<?php else: ?>

<div class="card">
    <div class="card-header">
        <h2>Dados do Veículo</h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="placa">Placa *</label>
                        <input type="text" class="form-control" id="placa" name="placa" 
                               value="<?= htmlspecialchars($dados['placa'] ?? '') ?>" 
                               placeholder="ABC1234 ou ABC1D23" required
                               style="text-transform: uppercase; font-family: monospace;">
                        <?php if (isset($erros_validacao['placa'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['placa'] ?></small>
                        <?php endif; ?>
                        <small style="color: #6c757d;">Formatos aceitos: ABC1234 (antigo) ou ABC1D23 (Mercosul)</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cliente_id">Cliente *</label>
                        <select class="form-control" id="cliente_id" name="cliente_id" required>
                            <option value="">Selecione um cliente...</option>
                            <?php foreach($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>" 
                                        <?= (isset($dados['cliente_id']) && $dados['cliente_id'] == $cliente['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cliente['nome']) ?> - <?= htmlspecialchars($cliente['telefone']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($erros_validacao['cliente_id'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['cliente_id'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="marca">Marca *</label>
                        <input type="text" class="form-control" id="marca" name="marca" 
                               value="<?= htmlspecialchars($dados['marca'] ?? '') ?>" 
                               placeholder="Ex: Toyota, Volkswagen, Ford" required>
                        <?php if (isset($erros_validacao['marca'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['marca'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="modelo">Modelo *</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" 
                               value="<?= htmlspecialchars($dados['modelo'] ?? '') ?>" 
                               placeholder="Ex: Corolla, Gol, Ka" required>
                        <?php if (isset($erros_validacao['modelo'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['modelo'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ano">Ano *</label>
                        <input type="number" class="form-control" id="ano" name="ano" 
                               value="<?= htmlspecialchars($dados['ano'] ?? '') ?>" 
                               min="1900" max="<?= date('Y') + 1 ?>" 
                               placeholder="<?= date('Y') ?>" required>
                        <?php if (isset($erros_validacao['ano'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['ano'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cor">Cor *</label>
                        <input type="text" class="form-control" id="cor" name="cor" 
                               value="<?= htmlspecialchars($dados['cor'] ?? '') ?>" 
                               placeholder="Ex: Branco, Preto, Prata" required>
                        <?php if (isset($erros_validacao['cor'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['cor'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    🚗 Cadastrar Veículo
                </button>
                <a href="?page=veiculos" class="btn btn-secondary">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>Dicas de Preenchimento</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>📋 Campos Obrigatórios</h4>
                <ul style="margin: 0;">
                    <li><strong>Placa:</strong> Identificação única do veículo</li>
                    <li><strong>Cliente:</strong> Proprietário do veículo</li>
                    <li><strong>Marca:</strong> Fabricante do veículo</li>
                    <li><strong>Modelo:</strong> Modelo específico</li>
                    <li><strong>Ano:</strong> Ano de fabricação</li>
                    <li><strong>Cor:</strong> Cor predominante</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4>💡 Dicas Importantes</h4>
                <ul style="margin: 0;">
                    <li>A placa deve seguir o padrão brasileiro</li>
                    <li>Verifique se o cliente já está cadastrado</li>
                    <li>Use nomes padronizados para marcas</li>
                    <li>O ano não pode ser futuro</li>
                    <li>Cores podem ser simples ou compostas</li>
                </ul>
            </div>
        </div>
        
        <div class="alert alert-info" style="margin-top: 1rem;">
            <strong>🔍 Não encontrou o cliente?</strong> 
            <a href="?page=clientes&action=create" target="_blank">Cadastre um novo cliente aqui</a> 
            e depois volte para cadastrar o veículo.
        </div>
    </div>
</div>