<?php
// app/Views/veiculos/edit.php
?>

<div class="card">
    <div class="card-header">
        <h1>Editar Veículo</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=veiculos" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=veiculos&action=view&id=<?= $veiculo['id'] ?>" class="btn btn-primary">👁️ Ver Detalhes</a>
            <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>" class="btn btn-warning">👤 Ver Cliente</a>
        </nav>
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

<div class="card">
    <div class="card-header">
        <h2>Dados do Veículo #<?= $veiculo['id'] ?></h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="placa">Placa *</label>
                        <input type="text" class="form-control" id="placa" name="placa" 
                               value="<?= htmlspecialchars($veiculo['placa']) ?>" 
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
                                        <?= ($veiculo['cliente_id'] == $cliente['id']) ? 'selected' : '' ?>>
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
                               value="<?= htmlspecialchars($veiculo['marca']) ?>" 
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
                               value="<?= htmlspecialchars($veiculo['modelo']) ?>" 
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
                               value="<?= htmlspecialchars($veiculo['ano']) ?>" 
                               min="1900" max="<?= date('Y') + 1 ?>" required>
                        <?php if (isset($erros_validacao['ano'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['ano'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cor">Cor *</label>
                        <input type="text" class="form-control" id="cor" name="cor" 
                               value="<?= htmlspecialchars($veiculo['cor']) ?>" 
                               placeholder="Ex: Branco, Preto, Prata" required>
                        <?php if (isset($erros_validacao['cor'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['cor'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    💾 Salvar Alterações
                </button>
                <a href="?page=veiculos&action=view&id=<?= $veiculo['id'] ?>" class="btn btn-secondary">
                    ❌ Cancelar
                </a>
                <a href="?page=veiculos&action=delete&id=<?= $veiculo['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Tem certeza que deseja excluir este veículo?')">
                    🗑️ Excluir Veículo
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Informações do Cadastro</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Data do Cadastro:</strong> <?= date('d/m/Y H:i', strtotime($veiculo['created_at'])) ?></p>
                <p><strong>ID do Veículo:</strong> #<?= $veiculo['id'] ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Cliente Atual:</strong> 
                    <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>">
                        <?= htmlspecialchars($veiculo['cliente_nome']) ?>
                    </a>
                </p>
                <p><strong>Contato:</strong> <?= htmlspecialchars($veiculo['cliente_telefone']) ?></p>
            </div>
        </div>
        
        <div class="alert alert-info">
            <strong>💡 Dica:</strong> As alterações serão salvas imediatamente após clicar em "Salvar Alterações".
            Se você alterar o cliente, o veículo será transferido para o novo proprietário.
        </div>
    </div>
</div>