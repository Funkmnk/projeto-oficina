<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Detalhes do Veículo</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=veiculos" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=veiculos&action=edit&id=<?= $veiculo['id'] ?>" class="btn btn-warning">✏️ Editar</a>
            <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>" class="btn btn-primary">👤 Ver Cliente</a>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>
                    <?= htmlspecialchars($veiculo['marca']) ?> <?= htmlspecialchars($veiculo['modelo']) ?>
                    <small style="color: #6c757d;">#<?= $veiculo['id'] ?></small>
                </h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>🚗 Dados do Veículo</h4>
                        
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                            <h3 style="font-family: monospace; background: white; padding: 0.5rem 1rem; border-radius: 4px; margin: 0; border: 2px solid #007bff;">
                                <?= htmlspecialchars($veiculo['placa']) ?>
                            </h3>
                        </div>
                        
                        <p><strong>Marca:</strong> <?= htmlspecialchars($veiculo['marca']) ?></p>
                        <p><strong>Modelo:</strong> <?= htmlspecialchars($veiculo['modelo']) ?></p>
                        <p><strong>Ano:</strong> <?= $veiculo['ano'] ?></p>
                        <p><strong>Cor:</strong> <?= htmlspecialchars($veiculo['cor']) ?></p>
                        
                        <h4 style="margin-top: 2rem;">📅 Informações de Cadastro</h4>
                        <p><strong>Data do Cadastro:</strong> <?= date('d/m/Y H:i', strtotime($veiculo['created_at'])) ?></p>
                        <p><strong>ID do Veículo:</strong> #<?= $veiculo['id'] ?></p>
                    </div>
                    
                    <div class="col-md-6">
                        <h4>👤 Proprietário</h4>
                        
                        <div class="card">
                            <div class="card-body">
                                <h5>
                                    <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>" 
                                       style="text-decoration: none;">
                                        <?= htmlspecialchars($veiculo['cliente_nome']) ?>
                                    </a>
                                </h5>
                                
                                <p style="margin: 0.5rem 0;">
                                    <strong>📞 Telefone:</strong> 
                                    <a href="tel:<?= htmlspecialchars($veiculo['cliente_telefone']) ?>">
                                        <?= htmlspecialchars($veiculo['cliente_telefone']) ?>
                                    </a>
                                </p>
                                
                                <?php if (!empty($veiculo['cliente_email'])): ?>
                                    <p style="margin: 0.5rem 0;">
                                        <strong>📧 Email:</strong> 
                                        <a href="mailto:<?= htmlspecialchars($veiculo['cliente_email']) ?>">
                                            <?= htmlspecialchars($veiculo['cliente_email']) ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                
                                <div style="margin-top: 1rem;">
                                    <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        👁️ Ver Perfil Completo
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <h4 style="margin-top: 1.5rem;">🔧 Histórico de Serviços</h4>
                        <div class="alert alert-info">
                            <strong>💡 Em Desenvolvimento</strong><br>
                            Em breve você poderá ver todo o histórico de serviços realizados neste veículo.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3>Ações Rápidas</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <a href="?page=veiculos&action=edit&id=<?= $veiculo['id'] ?>" class="btn btn-warning">
                        ✏️ Editar Veículo
                    </a>
                    
                    <a href="?page=clientes&action=view&id=<?= $veiculo['cliente_id'] ?>" class="btn btn-primary">
                        👤 Ver Cliente
                    </a>
                    
                    <a href="tel:<?= htmlspecialchars($veiculo['cliente_telefone']) ?>" class="btn btn-success">
                        📞 Ligar para Cliente
                    </a>
                    
                    <?php if (!empty($veiculo['cliente_email'])): ?>
                        <a href="mailto:<?= htmlspecialchars($veiculo['cliente_email']) ?>" class="btn btn-primary">
                            📧 Email Cliente
                        </a>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <a href="?page=veiculos&action=delete&id=<?= $veiculo['id'] ?>" class="btn btn-danger"
                       onclick="return confirm('Tem certeza que deseja excluir este veículo?')">
                        🗑️ Excluir Veículo
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Informações Técnicas</h3>
            </div>
            <div class="card-body" style="font-size: 0.9rem;">
                <p><strong>Tipo de Placa:</strong> 
                    <?= preg_match('/^[A-Z]{3}[0-9][A-Z][0-9]{2}$/', strtoupper(str_replace('-', '', $veiculo['placa']))) ? 'Mercosul' : 'Antiga' ?>
                </p>
                
                <p><strong>Idade do Veículo:</strong> 
                    <?= (date('Y') - $veiculo['ano']) ?> ano<?= (date('Y') - $veiculo['ano']) != 1 ? 's' : '' ?>
                </p>
                
                <p><strong>Cadastrado há:</strong> 
                    <?php 
                    $dias = floor((time() - strtotime($veiculo['created_at'])) / (60 * 60 * 24));
                    if ($dias == 0) {
                        echo 'Hoje';
                    } elseif ($dias == 1) {
                        echo '1 dia';
                    } else {
                        echo $dias . ' dias';
                    }
                    ?>
                </p>
            </div>
        </div>
        
        <?php
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT id, placa, marca, modelo FROM veiculos WHERE cliente_id = ? AND id != ? ORDER BY modelo LIMIT 3");
            $stmt->execute([$veiculo['cliente_id'], $veiculo['id']]);
            $outros_veiculos = $stmt->fetchAll();
        } catch(PDOException $e) {
            $outros_veiculos = [];
        }
        ?>
        
        <?php if (!empty($outros_veiculos)): ?>
            <div class="card">
                <div class="card-header">
                    <h3>Outros Veículos do Cliente</h3>
                </div>
                <div class="card-body">
                    <?php foreach($outros_veiculos as $outro): ?>
                        <div style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 0.5rem;">
                            <strong style="font-family: monospace; font-size: 0.9rem;">
                                <?= htmlspecialchars($outro['placa']) ?>
                            </strong>
                            <br>
                            <small><?= htmlspecialchars($outro['marca']) ?> <?= htmlspecialchars($outro['modelo']) ?></small>
                            <br>
                            <a href="?page=veiculos&action=view&id=<?= $outro['id'] ?>" class="btn btn-primary btn-sm" style="margin-top: 0.25rem;">
                                👁️ Ver
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>