<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Editar Serviço</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=admin-servicos" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=admin-servicos&action=view&id=<?= $servico['id'] ?>" class="btn btn-primary">👁️ Ver Detalhes</a>
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
        <h2>Dados do Serviço #<?= $servico['id'] ?></h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="form-group">
                <label for="nome">Nome do Serviço *</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       value="<?= htmlspecialchars($servico['nome']) ?>" 
                       placeholder="Ex: Troca de Óleo, Alinhamento, Lavagem Completa" required>
                <?php if (isset($erros_validacao['nome'])): ?>
                    <small style="color: #dc3545;"><?= $erros_validacao['nome'] ?></small>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição do Serviço</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" 
                          placeholder="Descreva detalhes do serviço, o que está incluído, etc."><?= htmlspecialchars($servico['descricao'] ?? '') ?></textarea>
                <small style="color: #6c757d;">Esta descrição aparecerá no site público para os clientes.</small>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="preco">Preço (R$) *</label>
                        <input type="number" class="form-control" id="preco" name="preco" 
                               value="<?= htmlspecialchars($servico['preco']) ?>" 
                               step="0.01" min="0" required>
                        <?php if (isset($erros_validacao['preco'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['preco'] ?></small>
                        <?php endif; ?>
                        <small style="color: #6c757d;">Use ponto (.) ou vírgula (,) para decimais</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tempo_estimado">Tempo Estimado (minutos) *</label>
                        <input type="number" class="form-control" id="tempo_estimado" name="tempo_estimado" 
                               value="<?= htmlspecialchars($servico['tempo_estimado']) ?>" 
                               min="1" required>
                        <?php if (isset($erros_validacao['tempo_estimado'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['tempo_estimado'] ?></small>
                        <?php endif; ?>
                        <small style="color: #6c757d;">
                            Tempo atual: <?= $servicoModel->formatarTempo($servico['tempo_estimado']) ?>
                        </small>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    💾 Salvar Alterações
                </button>
                <a href="?page=admin-servicos&action=view&id=<?= $servico['id'] ?>" class="btn btn-secondary">
                    ❌ Cancelar
                </a>
                <a href="?page=admin-servicos&action=delete&id=<?= $servico['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                    🗑️ Excluir Serviço
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
                <p><strong>Data do Cadastro:</strong> <?= date('d/m/Y H:i', strtotime($servico['created_at'])) ?></p>
                <p><strong>ID do Serviço:</strong> #<?= $servico['id'] ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Preço Atual:</strong> <span style="color: #28a745; font-weight: bold;">R$ <?= number_format($servico['preco'], 2, ',', '.') ?></span></p>
                <p><strong>Tempo Estimado:</strong> <span style="color: #007bff; font-weight: bold;"><?= $servicoModel->formatarTempo($servico['tempo_estimado']) ?></span></p>
            </div>
        </div>
        
        <div class="alert alert-info">
            <strong>💡 Dica:</strong> As alterações serão salvas imediatamente e refletirão no site público. 
            Certifique-se de que os preços estão atualizados e condizem com a realidade do mercado.
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Impacto das Alterações</h3>
    </div>
    <div class="card-body">
        <h4>🌐 Onde este serviço aparece:</h4>
        <ul>
            <li><strong>Site Público:</strong> Na página de serviços para os clientes</li>
            <li><strong>Orçamentos:</strong> Para cálculo de valores de serviços</li>
            <li><strong>Sistema Interno:</strong> Para agendamentos e controle</li>
        </ul>
        
        <div style="margin-top: 1rem;">
            <a href="?page=servicos" class="btn btn-success" target="_blank">
                🌐 Ver no Site Público
            </a>
        </div>
    </div>
</div>