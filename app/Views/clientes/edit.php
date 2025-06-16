<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Editar Cliente</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=clientes" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=clientes&action=view&id=<?= $cliente['id'] ?>" class="btn btn-primary">👁️ Ver Detalhes</a>
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
        <h2>Dados do Cliente #<?= $cliente['id'] ?></h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome">Nome Completo *</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?= htmlspecialchars($cliente['nome']) ?>" required>
                        <?php if (isset($erros_validacao['nome'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['nome'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefone">Telefone *</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" 
                               value="<?= htmlspecialchars($cliente['telefone']) ?>" 
                               placeholder="(41) 99999-9999" required>
                        <?php if (isset($erros_validacao['telefone'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['telefone'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($cliente['email'] ?? '') ?>" 
                               placeholder="cliente@email.com">
                        <?php if (isset($erros_validacao['email'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['email'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cpf_cnpj">CPF/CNPJ</label>
                        <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" 
                               value="<?= htmlspecialchars($cliente['cpf_cnpj'] ?? '') ?>" 
                               placeholder="000.000.000-00 ou 00.000.000/0000-00">
                        <?php if (isset($erros_validacao['cpf_cnpj'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['cpf_cnpj'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="endereco">Endereço Completo</label>
                <textarea class="form-control" id="endereco" name="endereco" rows="3" 
                          placeholder="Rua, número, bairro, cidade - CEP"><?= htmlspecialchars($cliente['endereco'] ?? '') ?></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    💾 Salvar Alterações
                </button>
                <a href="?page=clientes&action=view&id=<?= $cliente['id'] ?>" class="btn btn-secondary">
                    ❌ Cancelar
                </a>
                <a href="?page=clientes&action=delete&id=<?= $cliente['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                    🗑️ Excluir Cliente
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
                <p><strong>Data do Cadastro:</strong> <?= date('d/m/Y H:i', strtotime($cliente['created_at'])) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>ID do Cliente:</strong> #<?= $cliente['id'] ?></p>
            </div>
        </div>
        
        <div class="alert alert-info">
            <strong>💡 Dica:</strong> As alterações serão salvas imediatamente após clicar em "Salvar Alterações".
        </div>
    </div>
</div>