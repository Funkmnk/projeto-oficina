<?php
// app/Views/veiculos/delete.php
?>

<div class="card">
    <div class="card-header">
        <h1>Excluir Veículo</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=veiculos" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=veiculos&action=view&id=<?= $veiculo['id'] ?>" class="btn btn-primary">👁️ Ver Detalhes</a>
            <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>" class="btn btn-warning">👤 Ver Cliente</a>
        </nav>
    </div>
</div>

<div class="alert alert-error">
    <strong>⚠️ Confirmação de Exclusão</strong>
    <br>Você está prestes a excluir permanentemente o veículo abaixo. Esta ação não pode ser desfeita.
</div>

<div class="card">
    <div class="card-header">
        <h2>Dados do Veículo a ser Excluído</h2>
    </div>
    <div class="card-body">
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #dc3545;">
            <div class="row">
                <div class="col-md-6">
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <h3 style="font-family: monospace; background: white; padding: 0.5rem 1rem; border-radius: 4px; margin: 0; border: 2px solid #dc3545; display: inline-block;">
                            <?= htmlspecialchars($veiculo['placa']) ?>
                        </h3>
                    </div>
                    
                    <h4><?= htmlspecialchars($veiculo['marca']) ?> <?= htmlspecialchars($veiculo['modelo']) ?></h4>
                    <p><strong>ID:</strong> #<?= $veiculo['id'] ?></p>
                    <p><strong>Ano:</strong> <?= $veiculo['ano'] ?></p>
                    <p><strong>Cor:</strong> <?= htmlspecialchars($veiculo['cor']) ?></p>
                </div>
                
                <div class="col-md-6">
                    <h5>👤 Proprietário:</h5>
                    <p><strong><?= htmlspecialchars($veiculo['cliente_nome']) ?></strong></p>
                    <p>📞 <?= htmlspecialchars($veiculo['cliente_telefone']) ?></p>
                    
                    <?php if (!empty($veiculo['cliente_email'])): ?>
                        <p>📧 <?= htmlspecialchars($veiculo['cliente_email']) ?></p>
                    <?php endif; ?>
                    
                    <p><strong>Cadastrado em:</strong> <?= date('d/m/Y H:i', strtotime($veiculo['created_at'])) ?></p>
                </div>
            </div>
        </div>
        
        <form method="POST" style="margin-top: 2rem;">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="alert alert-info">
                <strong>📋 Confirme digitando "EXCLUIR"</strong>
                <div class="form-group" style="margin-top: 1rem;">
                    <input type="text" class="form-control" name="confirmacao" 
                           placeholder="Digite EXCLUIR para confirmar" required 
                           style="max-width: 300px;">
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Tem CERTEZA ABSOLUTA que deseja excluir este veículo? Esta ação NÃO pode ser desfeita!')">
                    🗑️ EXCLUIR VEÍCULO PERMANENTEMENTE
                </button>
                
                <a href="?page=veiculos&action=view&id=<?= $veiculo['id'] ?>" class="btn btn-secondary">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>⚠️ Importante - Leia Antes de Prosseguir</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4 style="color: #dc3545;">O que será excluído:</h4>
                <ul>
                    <li>✗ Todos os dados do veículo</li>
                    <li>✗ Histórico de cadastro</li>
                    <li>✗ Informações técnicas</li>
                    <li>✗ Registro completo do sistema</li>
                    <li>✗ Futuros históricos de serviços</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4 style="color: #28a745;">O que NÃO será afetado:</h4>
                <ul>
                    <li>✓ Dados do cliente proprietário</li>
                    <li>✓ Outros veículos do cliente</li>
                    <li>✓ Outros veículos do sistema</li>
                    <li>✓ Configurações da oficina</li>
                    <li>✓ Cadastro de serviços</li>
                </ul>
            </div>
        </div>
        
        <div class="alert alert-error" style="margin-top: 1.5rem;">
            <strong>⚠️ ATENÇÃO:</strong> Esta ação é <strong>IRREVERSÍVEL</strong>. 
            Uma vez excluído, não será possível recuperar os dados deste veículo.
            <br><br>
            <strong>💡 Alternativa:</strong> Se você não quer excluir definitivamente, 
            considere apenas <a href="?page=veiculos&action=edit&id=<?= $veiculo['id'] ?>">editar os dados</a> 
            ou transferir o veículo para outro cliente.
        </div>
    </div>
</div>