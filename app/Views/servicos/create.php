<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Cadastrar Novo Serviço</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=admin-servicos" class="btn btn-secondary">← Voltar para Lista</a>
        </nav>
    </div>
</div>

<?php if (!empty($mensagem)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($mensagem) ?>
        <div style="margin-top: 1rem;">
            <a href="?page=admin-servicos" class="btn btn-primary">Ver Lista de Serviços</a>
            <a href="?page=admin-servicos&action=create" class="btn btn-success">Cadastrar Outro Serviço</a>
            <a href="?page=servicos" class="btn btn-warning" target="_blank">Ver no Site Público</a>
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
        <h2>Dados do Serviço</h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="form-group">
                <label for="nome">Nome do Serviço *</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       value="<?= htmlspecialchars($dados['nome'] ?? '') ?>" 
                       placeholder="Ex: Troca de Óleo, Alinhamento, Lavagem Completa" required>
                <?php if (isset($erros_validacao['nome'])): ?>
                    <small style="color: #dc3545;"><?= $erros_validacao['nome'] ?></small>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição do Serviço</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" 
                          placeholder="Descreva detalhes do serviço, o que está incluído, etc."><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
                <small style="color: #6c757d;">Esta descrição aparecerá no site público para os clientes.</small>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="preco">Preço (R$) *</label>
                        <input type="number" class="form-control" id="preco" name="preco" 
                               value="<?= htmlspecialchars($dados['preco'] ?? '') ?>" 
                               step="0.01" min="0" placeholder="0,00" required>
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
                               value="<?= htmlspecialchars($dados['tempo_estimado'] ?? '') ?>" 
                               min="1" placeholder="60" required>
                        <?php if (isset($erros_validacao['tempo_estimado'])): ?>
                            <small style="color: #dc3545;"><?= $erros_validacao['tempo_estimado'] ?></small>
                        <?php endif; ?>
                        <small style="color: #6c757d;">Tempo em minutos (Ex: 60 = 1 hora)</small>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    🔧 Cadastrar Serviço
                </button>
                <a href="?page=admin-servicos" class="btn btn-secondary">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Exemplos de Serviços</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>🔧 Serviços Mecânicos</h4>
                <ul style="margin: 0;">
                    <li><strong>Troca de Óleo:</strong> 30-45 min, R$ 60-100</li>
                    <li><strong>Alinhamento:</strong> 45-60 min, R$ 50-80</li>
                    <li><strong>Balanceamento:</strong> 30-45 min, R$ 30-60</li>
                    <li><strong>Troca de Filtros:</strong> 15-30 min, R$ 40-80</li>
                    <li><strong>Revisão Geral:</strong> 2-4 horas, R$ 150-300</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4>🚿 Lava Rápido</h4>
                <ul style="margin: 0;">
                    <li><strong>Lavagem Simples:</strong> 20-30 min, R$ 15-25</li>
                    <li><strong>Lavagem Completa:</strong> 45-60 min, R$ 25-40</li>
                    <li><strong>Enceramento:</strong> 30-45 min, R$ 20-35</li>
                    <li><strong>Limpeza Interna:</strong> 30-45 min, R$ 25-40</li>
                    <li><strong>Lavagem Premium:</strong> 60-90 min, R$ 50-80</li>
                </ul>
            </div>
        </div>
        
        <div class="alert alert-info" style="margin-top: 1.5rem;">
            <strong>💡 Dicas para Preços:</strong>
            <ul style="margin: 0.5rem 0 0 0;">
                <li>Pesquise preços da concorrência na região</li>
                <li>Considere custo de materiais + mão de obra + margem</li>
                <li>Ofereça pacotes promocionais para múltiplos serviços</li>
                <li>Atualize preços periodicamente conforme inflação</li>
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Conversão de Tempo</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>⏰ Referência Rápida</h5>
                <ul style="font-family: monospace; margin: 0;">
                    <li>15 minutos = 0,25 hora</li>
                    <li>30 minutos = 0,5 hora</li>
                    <li>45 minutos = 0,75 hora</li>
                    <li>60 minutos = 1 hora</li>
                    <li>90 minutos = 1,5 hora</li>
                    <li>120 minutos = 2 horas</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>📊 Categorias Sugeridas</h5>
                <ul style="margin: 0;">
                    <li><strong>Serviços Rápidos:</strong> 15-30 min</li>
                    <li><strong>Serviços Médios:</strong> 30-60 min</li>
                    <li><strong>Serviços Longos:</strong> 1-2 horas</li>
                    <li><strong>Serviços Complexos:</strong> 2+ horas</li>
                </ul>
            </div>
        </div>
    </div>
</div>