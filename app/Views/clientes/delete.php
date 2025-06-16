<?php

try {
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM veiculos WHERE cliente_id = ?");
    $stmt->execute([$cliente['id']]);
    $total_veiculos = $stmt->fetch()['total'];
} catch(PDOException $e) {
    $total_veiculos = 0;
}
?>

<div class="card">
    <div class="card-header">
        <h1>Excluir Cliente</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=clientes" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=clientes&action=view&id=<?= $cliente['id'] ?>" class="btn btn-primary">👁️ Ver Detalhes</a>
        </nav>
    </div>
</div>

<?php if ($total_veiculos > 0): ?>
    <div class="alert alert-error">
        <strong>⚠️ Atenção!</strong> Este cliente não pode ser excluído porque possui <strong><?= $total_veiculos ?></strong> veículo<?= $total_veiculos > 1 ? 's' : '' ?> cadastrado<?= $total_veiculos > 1 ? 's' : '' ?>.
        <br><br>
        Para excluir este cliente, primeiro você deve:
        <ol style="margin-top: 1rem;">
            <li>Excluir todos os veículos associados a este cliente, OU</li>
            <li>Transferir os veículos para outro cliente</li>
        </ol>
        <div style="margin-top: 1rem;">
            <a href="?page=clientes&action=view&id=<?= $cliente['id'] ?>" class="btn btn-primary">
                Ver Veículos do Cliente
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-error">
        <strong>⚠️ Confirmação de Exclusão</strong>
        <br>Você está prestes a excluir permanentemente o cliente abaixo. Esta ação não pode ser desfeita.
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>Dados do Cliente a ser Excluído</h2>
    </div>
    <div class="card-body">
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #dc3545;">
            <div class="row">
                <div class="col-md-6">
                    <h4><?= htmlspecialchars($cliente['nome']) ?></h4>
                    <p><strong>ID:</strong> #<?= $cliente['id'] ?></p>
                    <p><strong>Telefone:</strong> <?= htmlspecialchars($cliente['telefone']) ?></p>
                    
                    <?php if (!empty($cliente['email'])): ?>
                        <p><strong>Email:</strong> <?= htmlspecialchars($cliente['email']) ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($cliente['cpf_cnpj'])): ?>
                        <p><strong>CPF/CNPJ:</strong> <?= htmlspecialchars($cliente['cpf_cnpj']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                    <?php if (!empty($cliente['endereco'])): ?>
                        <h5>Endereço:</h5>
                        <p><?= nl2br(htmlspecialchars($cliente['endereco'])) ?></p>
                    <?php endif; ?>
                    
                    <p><strong>Cadastrado em:</strong> <?= date('d/m/Y H:i', strtotime($cliente['created_at'])) ?></p>
                    <p><strong>Veículos:</strong> <?= $total_veiculos ?></p>
                </div>
            </div>
        </div>
        
        <?php if ($total_veiculos == 0): ?>
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
                            onclick="return confirm('Tem CERTEZA ABSOLUTA que deseja excluir este cliente? Esta ação NÃO pode ser desfeita!')">
                        🗑️ EXCLUIR CLIENTE PERMANENTEMENTE
                    </button>
                    
                    <a href="?page=clientes&action=view&id=<?= $cliente['id'] ?>" class="btn btn-secondary">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        <?php else: ?>
            <div style="margin-top: 2rem;">
                <a href="?page=clientes&action=view&id=<?= $cliente['id'] ?>" class="btn btn-primary">
                    👁️ Ver Detalhes do Cliente
                </a>
                <a href="?page=clientes" class="btn btn-secondary">
                    ← Voltar para Lista
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($total_veiculos == 0): ?>
    <div class="card">
        <div class="card-header">
            <h3>⚠️ Importante - Leia Antes de Prosseguir</h3>
        </div>
        <div class="card-body">
            <h4 style="color: #dc3545;">O que será excluído:</h4>
            <ul>
                <li>✗ Todos os dados pessoais do cliente</li>
                <li>✗ Histórico de contato</li>
                <li>✗ Informações de endereço</li>
                <li>✗ Registro completo do sistema</li>
            </ul>
            
            <h4 style="color: #28a745; margin-top: 1.5rem;">O que NÃO será afetado:</h4>
            <ul>
                <li>✓ Outros clientes do sistema</li>
                <li>✓ Configurações da oficina</li>
                <li>✓ Cadastro de serviços</li>
            </ul>
            
            <div class="alert alert-error" style="margin-top: 1.5rem;">
                <strong>⚠️ ATENÇÃO:</strong> Esta ação é <strong>IRREVERSÍVEL</strong>. 
                Uma vez excluído, não será possível recuperar os dados deste cliente.
            </div>
        </div>
    </div>
<?php endif; ?>