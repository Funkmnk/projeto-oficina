<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Detalhes do Serviço</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=admin-servicos" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=admin-servicos&action=edit&id=<?= $servico['id'] ?>" class="btn btn-warning">✏️ Editar</a>
            <a href="?page=servicos" class="btn btn-success" target="_blank">🌐 Ver no Site</a>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>
                    <?= htmlspecialchars($servico['nome']) ?>
                    <small style="color: #6c757d;">#<?= $servico['id'] ?></small>
                </h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>💰 Informações Comerciais</h4>
                        
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
                            <h3 style="color: #28a745; margin: 0; font-size: 2rem;">
                                R$ <?= number_format($servico['preco'], 2, ',', '.') ?>
                            </h3>
                            <p style="margin: 0.5rem 0 0 0; color: #6c757d;">Preço do serviço</p>
                        </div>
                        
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; text-align: center;">
                            <h3 style="color: #007bff; margin: 0; font-size: 2rem;">
                                <?= $servicoModel->formatarTempo($servico['tempo_estimado']) ?>
                            </h3>
                            <p style="margin: 0.5rem 0 0 0; color: #6c757d;">Tempo estimado</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h4>📝 Descrição</h4>
                        <?php if (!empty($servico['descricao'])): ?>
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #007bff;">
                                <p style="margin: 0; line-height: 1.6;">
                                    <?= nl2br(htmlspecialchars($servico['descricao'])) ?>
                                </p>
                            </div>
                        <?php else: ?>
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center;">
                                <p style="margin: 0; color: #6c757d; font-style: italic;">
                                    Nenhuma descrição cadastrada
                                </p>
                            </div>
                        <?php endif; ?>
                        
                        <h4 style="margin-top: 2rem;">📅 Informações de Cadastro</h4>
                        <p><strong>Data do Cadastro:</strong> <?= date('d/m/Y H:i', strtotime($servico['created_at'])) ?></p>
                        <p><strong>ID do Serviço:</strong> #<?= $servico['id'] ?></p>
                        
                        <h4>🔧 Categoria</h4>
                        <p>
                            <?php 
                            $tempo = $servico['tempo_estimado'];
                            if ($tempo <= 30) {
                                echo '<span class="badge" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 4px;">Serviço Rápido</span>';
                            } elseif ($tempo <= 60) {
                                echo '<span class="badge" style="background: #ffc107; color: #212529; padding: 0.5rem 1rem; border-radius: 4px;">Serviço Médio</span>';
                            } elseif ($tempo <= 120) {
                                echo '<span class="badge" style="background: #fd7e14; color: white; padding: 0.5rem 1rem; border-radius: 4px;">Serviço Longo</span>';
                            } else {
                                echo '<span class="badge" style="background: #dc3545; color: white; padding: 0.5rem 1rem; border-radius: 4px;">Serviço Complexo</span>';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Análise do Serviço -->
        <div class="card">
            <div class="card-header">
                <h3>📊 Análise do Serviço</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>💵 Análise de Preço</h5>
                        <?php
                        $preco = $servico['preco'];
                        if ($preco < 50) {
                            $faixa_preco = "Preço Baixo";
                            $cor_preco = "#28a745";
                        } elseif ($preco < 100) {
                            $faixa_preco = "Preço Médio";
                            $cor_preco = "#ffc107";
                        } elseif ($preco < 200) {
                            $faixa_preco = "Preço Alto";
                            $cor_preco = "#fd7e14";
                        } else {
                            $faixa_preco = "Preço Premium";
                            $cor_preco = "#dc3545";
                        }
                        ?>
                        <p>Categoria: <strong style="color: <?= $cor_preco ?>;"><?= $faixa_preco ?></strong></p>
                        
                        <h5>⏱️ Análise de Tempo</h5>
                        <p><strong>Em minutos:</strong> <?= $servico['tempo_estimado'] ?> min</p>
                        <p><strong>Em horas:</strong> <?= number_format($servico['tempo_estimado'] / 60, 1) ?>h</p>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>💼 Rentabilidade</h5>
                        <p><strong>Preço por hora:</strong> 
                            R$ <?= number_format(($servico['preco'] / $servico['tempo_estimado']) * 60, 2, ',', '.') ?>
                        </p>
                        
                        <h5>📈 Posicionamento</h5>
                        <p>Este serviço tem um preço <strong><?= strtolower($faixa_preco) ?></strong> 
                        e tempo de execução 
                        <?php 
                        if ($tempo <= 30) echo "rápido";
                        elseif ($tempo <= 60) echo "médio";
                        elseif ($tempo <= 120) echo "longo";
                        else echo "complexo";
                        ?>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Ações Rápidas -->
        <div class="card">
            <div class="card-header">
                <h3>Ações Rápidas</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <a href="?page=admin-servicos&action=edit&id=<?= $servico['id'] ?>" class="btn btn-warning">
                        ✏️ Editar Serviço
                    </a>
                    
                    <a href="?page=servicos" class="btn btn-success" target="_blank">
                        🌐 Ver no Site Público
                    </a>
                    
                    <hr>
                    
                    <a href="?page=admin-servicos&action=delete&id=<?= $servico['id'] ?>" class="btn btn-danger"
                       onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                        🗑️ Excluir Serviço
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Comparação com Outros Serviços -->
        <?php
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT nome, preco, tempo_estimado FROM servicos WHERE id != ? ORDER BY preco LIMIT 3");
            $stmt->execute([$servico['id']]);
            $outros_servicos = $stmt->fetchAll();
        } catch(PDOException $e) {
            $outros_servicos = [];
        }
        ?>
        
        <?php if (!empty($outros_servicos)): ?>
            <div class="card">
                <div class="card-header">
                    <h3>Outros Serviços</h3>
                </div>
                <div class="card-body">
                    <?php foreach($outros_servicos as $outro): ?>
                        <div style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 0.5rem;">
                            <strong style="font-size: 0.9rem;">
                                <?= htmlspecialchars($outro['nome']) ?>
                            </strong>
                            <br>
                            <small style="color: #28a745;">R$ <?= number_format($outro['preco'], 2, ',', '.') ?></small>
                            <span style="color: #6c757d;"> • </span>
                            <small style="color: #007bff;"><?= $servicoModel->formatarTempo($outro['tempo_estimado']) ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Informações Técnicas -->
        <div class="card">
            <div class="card-header">
                <h3>Informações Técnicas</h3>
            </div>
            <div class="card-body" style="font-size: 0.9rem;">
                <p><strong>Custo por minuto:</strong> 
                    R$ <?= number_format($servico['preco'] / $servico['tempo_estimado'], 2, ',', '.') ?>
                </p>
                
                <p><strong>Cadastrado há:</strong> 
                    <?php 
                    $dias = floor((time() - strtotime($servico['created_at'])) / (60 * 60 * 24));
                    if ($dias == 0) {
                        echo 'Hoje';
                    } elseif ($dias == 1) {
                        echo '1 dia';
                    } else {
                        echo $dias . ' dias';
                    }
                    ?>
                </p>
                
                <?php if ($servico['tempo_estimado'] >= 60): ?>
                    <p><strong>Pausas sugeridas:</strong> 
                        <?= floor($servico['tempo_estimado'] / 60) ?> pausa<?= floor($servico['tempo_estimado'] / 60) > 1 ? 's' : '' ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>