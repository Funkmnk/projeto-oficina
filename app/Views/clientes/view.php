<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Detalhes do Cliente</h1>
    </div>
    <div class="card-body">
        <nav style="margin-bottom: 1rem;">
            <a href="?page=clientes" class="btn btn-secondary">← Voltar para Lista</a>
            <a href="?page=clientes&action=edit&id=<?= $cliente['id'] ?>" class="btn btn-warning">✏️ Editar</a>
            <a href="?page=veiculos&action=create&cliente_id=<?= $cliente['id'] ?>" class="btn btn-success">🚗 Cadastrar Veículo</a>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2><?= htmlspecialchars($cliente['nome']) ?> <small style="color: #6c757d;">#<?= $cliente['id'] ?></small></h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>📞 Contato</h4>
                        <p><strong>Telefone:</strong> 
                            <a href="tel:<?= htmlspecialchars($cliente['telefone']) ?>">
                                <?= htmlspecialchars($cliente['telefone']) ?>
                            </a>
                        </p>
                        
                        <?php if (!empty($cliente['email'])): ?>
                            <p><strong>Email:</strong> 
                                <a href="mailto:<?= htmlspecialchars($cliente['email']) ?>">
                                    <?= htmlspecialchars($cliente['email']) ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (!empty($cliente['cpf_cnpj'])): ?>
                            <p><strong>CPF/CNPJ:</strong> <?= htmlspecialchars($cliente['cpf_cnpj']) ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <h4>📍 Endereço</h4>
                        <?php if (!empty($cliente['endereco'])): ?>
                            <p><?= nl2br(htmlspecialchars($cliente['endereco'])) ?></p>
                        <?php else: ?>
                            <p style="color: #6c757d; font-style: italic;">Endereço não informado</p>
                        <?php endif; ?>
                        
                        <h4>📅 Cadastro</h4>
                        <p><?= date('d/m/Y H:i', strtotime($cliente['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>🚗 Veículos do Cliente (<?= count($veiculos) ?>)</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($veiculos)): ?>
                    <div class="row">
                        <?php foreach($veiculos as $veiculo): ?>
                            <div class="col-md-6" style="margin-bottom: 1rem;">
                                <div class="card">
                                    <div class="card-body">
                                        <h5><?= htmlspecialchars($veiculo['marca']) ?> <?= htmlspecialchars($veiculo['modelo']) ?></h5>
                                        <p style="margin: 0.5rem 0;">
                                            <strong>Placa:</strong> <?= htmlspecialchars($veiculo['placa']) ?><br>
                                            <strong>Ano:</strong> <?= $veiculo['ano'] ?><br>
                                            <strong>Cor:</strong> <?= htmlspecialchars($veiculo['cor']) ?>
                                        </p>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="?page=veiculos&action=view&id=<?= $veiculo['id'] ?>" class="btn btn-primary btn-sm">
                                                👁️ Ver
                                            </a>
                                            <a href="?page=veiculos&action=edit&id=<?= $veiculo['id'] ?>" class="btn btn-warning btn-sm">
                                                ✏️ Editar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem;">
                        <h4 style="color: #6c757d;">Nenhum veículo cadastrado</h4>
                        <p style="color: #6c757d;">Este cliente ainda não possui veículos cadastrados.</p>
                        <a href="?page=veiculos&action=create&cliente_id=<?= $cliente['id'] ?>" class="btn btn-primary">
                            🚗 Cadastrar Primeiro Veículo
                        </a>
                    </div>
                <?php endif; ?>
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
                    <a href="?page=clientes&action=edit&id=<?= $cliente['id'] ?>" class="btn btn-warning">
                        ✏️ Editar Cliente
                    </a>
                    
                    <a href="?page=veiculos&action=create&cliente_id=<?= $cliente['id'] ?>" class="btn btn-success">
                        🚗 Novo Veículo
                    </a>
                    
                    <a href="tel:<?= htmlspecialchars($cliente['telefone']) ?>" class="btn btn-primary">
                        📞 Ligar
                    </a>
                    
                    <?php if (!empty($cliente['email'])): ?>
                        <a href="mailto:<?= htmlspecialchars($cliente['email']) ?>" class="btn btn-primary">
                            📧 Enviar Email
                        </a>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <a href="?page=clientes&action=delete&id=<?= $cliente['id'] ?>" class="btn btn-danger"
                       onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                        🗑️ Excluir Cliente
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Estatísticas</h3>
            </div>
            <div class="card-body">
                <div style="text-align: center;">
                    <div class="stat-card" style="margin-bottom: 1rem;">
                        <div class="stat-number" style="color: #28a745;"><?= count($veiculos) ?></div>
                        <div class="stat-label">Veículos Cadastrados</div>
                    </div>
                    
                    <div style="font-size: 0.9rem; color: #6c757d;">
                        <p>Cliente desde:<br>
                        <strong><?= date('d/m/Y', strtotime($cliente['created_at'])) ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Informações</h3>
            </div>
            <div class="card-body" style="font-size: 0.9rem;">
                <p><strong>ID do Cliente:</strong> #<?= $cliente['id'] ?></p>
                <p><strong>Cadastrado em:</strong> <?= date('d/m/Y H:i', strtotime($cliente['created_at'])) ?></p>
                
                <?php if (!empty($cliente['cpf_cnpj'])): ?>
                    <p><strong>Tipo:</strong> 
                        <?= strlen(preg_replace('/[^0-9]/', '', $cliente['cpf_cnpj'])) == 11 ? 'Pessoa Física' : 'Pessoa Jurídica' ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>