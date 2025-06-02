<?php
// app/Views/servicos/delete.php
?>

<div class="card">
    <div class="card-header">
        <h1>Excluir Serviço</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=admin-servicos" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=admin-servicos&action=view&id=<?= $servico['id'] ?>" class="btn btn-primary">👁️ Ver Detalhes</a>
        </nav>
    </div>
</div>

<div class="alert alert-error">
    <strong>⚠️ Confirmação de Exclusão</strong>
    <br>Você está prestes a excluir permanentemente o serviço abaixo. Esta ação não pode ser desfeita.
</div>

<div class="card">
    <div class="card-header">
        <h2>Dados do Serviço a ser Excluído</h2>
    </div>
    <div class="card-body">
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #dc3545;">
            <div class="row">
                <div class="col-md-6">
                    <h4><?= htmlspecialchars($servico['nome']) ?></h4>
                    <p><strong>ID:</strong> #<?= $servico['id'] ?></p>
                    
                    <?php if (!empty($servico['descricao'])): ?>
                        <h5>Descrição:</h5>
                        <p style="background: white; padding: 1rem; border-radius: 4px; margin: 0.5rem 0;">
                            <?= nl2br(htmlspecialchars($servico['descricao'])) ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <div style="background: white; padding: 1rem; border-radius: 4px; border: 2px solid #dc3545; display: inline-block;">
                            <h3 style="color: #dc3545; margin: 0;">
                                R$ <?= number_format($servico['preco'], 2, ',', '.') ?>
                            </h3>
                            <small style="color: #6c757d;">Preço do serviço</small>
                        </div>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="background: white; padding: 1rem; border-radius: 4px; border: 2px solid #dc3545; display: inline-block;">
                            <h3 style="color: #dc3545; margin: 0;">
                                <?= $servicoModel->formatarTempo($servico['tempo_estimado']) ?>
                            </h3>
                            <small style="color: #6c757d;">Tempo estimado</small>
                        </div>
                    </div>
                    
                    <p style="margin-top: 1rem;"><strong>Cadastrado em:</strong> <?= date('d/m/Y H:i', strtotime($servico['created_at'])) ?></p>
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
                        onclick="return confirm('Tem CERTEZA ABSOLUTA que deseja excluir este serviço? Esta ação NÃO pode ser desfeita!')">
                    🗑️ EXCLUIR SERVIÇO PERMANENTEMENTE
                </button>
                
                <a href="?page=admin-servicos&action=view&id=<?= $servico['id'] ?>" class="btn btn-secondary">
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
                    <li>✗ Todos os dados do serviço</li>
                    <li>✗ Nome e descrição</li>
                    <li>✗ Preço e tempo estimado</li>
                    <li>✗ Histórico de cadastro</li>
                    <li>✗ Aparição no site público</li>
                    <li>✗ Disponibilidade para novos orçamentos</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4 style="color: #28a745;">O que NÃO será afetado:</h4>
                <ul>
                    <li>✓ Outros serviços do sistema</li>
                    <li>✓ Clientes e veículos</li>
                    <li>✓ Configurações da oficina</li>
                    <li>✓ Históricos já realizados (se houver)</li>
                    <li>✓ Sistema de login</li>
                </ul>
            </div>
        </div>
        
        <div class="alert alert-error" style="margin-top: 1.5rem;">
            <strong>⚠️ ATENÇÃO:</strong> Esta ação é <strong>IRREVERSÍVEL</strong>. 
            Uma vez excluído, não será possível recuperar os dados deste serviço.
            <br><br>
            <strong>💡 Alternativas:</strong>
            <ul style="margin: 0.5rem 0 0 0;">
                <li>Se o serviço não é mais oferecido, considere apenas <a href="?page=admin-servicos&action=edit&id=<?= $servico['id'] ?>">editar o nome</a> para "DESATIVADO - <?= htmlspecialchars($servico['nome']) ?>"</li>
                <li>Se é apenas uma atualização de preço, <a href="?page=admin-servicos&action=edit&id=<?= $servico['id'] ?>">edite os dados</a> ao invés de excluir</li>
                <li>Se há duplicatas, exclua apenas a duplicata e mantenha o original</li>
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>🌐 Impacto no Site Público</h3>
    </div>
    <div class="card-body">
        <p>Este serviço atualmente <strong>está disponível</strong> no site público para os clientes visualizarem. 
        Após a exclusão:</p>
        
        <ul>
            <li>❌ Não aparecerá mais na lista de serviços</li>
            <li>❌ Clientes não poderão mais vê-lo ou solicitar orçamentos</li>
            <li>❌ Links diretos para este serviço retornarão erro</li>
        </ul>
        
        <div style="margin-top: 1rem;">
            <a href="?page=servicos" class="btn btn-success" target="_blank">
                🌐 Ver Como Aparece no Site Público
            </a>
        </div>
    </div>
</div>