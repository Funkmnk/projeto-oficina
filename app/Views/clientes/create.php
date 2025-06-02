<?php
// app/Views/clientes/create.php
?>

<div class="card">
    <div class="card-header">
        <h1>Cadastrar Novo Cliente</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=clientes" class="btn btn-secondary">← Voltar para Lista</a>
        </nav>
    </div>
</div>

<?php if (!empty($mensagem)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($mensagem) ?>
        <div style="margin-top: 1rem;">
            <a href="?page=clientes" class="btn btn-primary">Ver Lista de Clientes</a>
            <a href="?page=clientes&action=create" class="btn btn-success">Cadastrar Outro Cliente</a>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($erro)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($erro) ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>Dados do Cliente</h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome">Nome Completo *</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?= htmlspecialchars($dados['nome'] ?? '') ?>" required>
                        <?php if (isset($erros_validacao['nome'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['nome'] ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefone">Telefone *</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" 
                               value="<?= htmlspecialchars($dados['telefone'] ?? '') ?>" 
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
                               value="<?= htmlspecialchars($dados['email'] ?? '') ?>" 
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
                               value="<?= htmlspecialchars($dados['cpf_cnpj'] ?? '') ?>" 
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
                          placeholder="Rua, número, bairro, cidade - CEP"><?= htmlspecialchars($dados['endereco'] ?? '') ?></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    💾 Cadastrar Cliente
                </button>
                <a href="?page=clientes" class="btn btn-secondary">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Dicas de Preenchimento</h3>
    </div>
    <div class="card-body">
        <ul style="margin: 0;">
            <li><strong>Nome:</strong> Informe o nome completo do cliente</li>
            <li><strong>Telefone:</strong> Número para contato (obrigatório)</li>
            <li><strong>Email:</strong> Para envio de orçamentos e comunicações</li>
            <li><strong>CPF/CNPJ:</strong> Para identificação fiscal (opcional)</li>
            <li><strong>Endereço:</strong> Para localização e possíveis visitas técnicas</li>
        </ul>
        
        <div class="alert alert-info" style="margin-top: 1rem;">
            <strong>💡 Dica:</strong> Após cadastrar o cliente, você poderá registrar os veículos dele na seção "Veículos".
        </div>
    </div>
</div>