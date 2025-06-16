<?php

try {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM servicos ORDER BY nome");
    $stmt->execute();
    $servicos = $stmt->fetchAll();
} catch(PDOException $e) {
    $servicos = [];
    $erro = "Erro ao carregar serviços: " . $e->getMessage();
}
?>

<div class="card">
    <div class="card-header">
        <h1>Nossos Serviços</h1>
    </div>
    <div class="card-body">
        <p>Confira todos os serviços disponíveis em nossa oficina. Trabalhamos com qualidade e garantia em todos os serviços.</p>
    </div>
</div>

<?php if (isset($erro)): ?>
    <div class="alert alert-error">
        <?= $erro ?>
    </div>
<?php endif; ?>

<?php if (!empty($servicos)): ?>
    <div class="services-grid">
        <?php foreach($servicos as $servico): ?>
            <div class="service-card">
                <h3><?= htmlspecialchars($servico['nome']) ?></h3>
                <p><?= htmlspecialchars($servico['descricao']) ?></p>
                
                <div class="price">
                    R$ <?= number_format($servico['preco'], 2, ',', '.') ?>
                </div>
                
                <p style="color: #6c757d; font-size: 0.9rem; margin-top: 0.5rem;">
                    Tempo estimado: <?= $servico['tempo_estimado'] ?> minutos
                </p>
                
                <a href="?page=contato" class="btn btn-primary" style="margin-top: 1rem;">
                    Solicitar Orçamento
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h3>Nenhum serviço cadastrado</h3>
            <p>Entre em contato conosco para saber mais sobre nossos serviços.</p>
            <a href="?page=contato" class="btn btn-primary">Entrar em Contato</a>
        </div>
    </div>
<?php endif; ?>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2>Informações Importantes</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>🕒 Horário de Funcionamento</h4>
                <ul>
                    <li><strong>Segunda à Sexta:</strong> 8h às 18h</li>
                    <li><strong>Sábado:</strong> 8h às 12h</li>
                    <li><strong>Domingo:</strong> Fechado</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4>📋 Como Funciona</h4>
                <ul>
                    <li>1. Entre em contato ou venha até nossa oficina</li>
                    <li>2. Fazemos uma avaliação do seu veículo</li>
                    <li>3. Apresentamos um orçamento detalhado</li>
                    <li>4. Com sua aprovação, iniciamos o serviço</li>
                    <li>5. Entregamos seu veículo revisado</li>
                </ul>
            </div>
        </div>
        
        <div class="row" style="margin-top: 2rem;">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <strong>💡 Dica:</strong> Agende seus serviços com antecedência para garantir o melhor horário. 
                    Oferecemos desconto de 10% para clientes que fazem manutenção preventiva regular!
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 2rem;">
            <a href="?page=contato" class="btn btn-success btn-lg">
                Agendar Serviço Agora
            </a>
        </div>
    </div>
</div>