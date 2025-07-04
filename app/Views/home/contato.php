<?php

$mensagem_enviada = false;
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Por favor, informe um email válido.';
    } elseif (!verifyCSRFToken($csrf_token)) {
        $erro = 'Token de segurança inválido. Tente novamente.';
    } else {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO mensagens_contato (nome, email, telefone, mensagem) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $telefone, $mensagem]);
            $mensagem_enviada = true;
        } catch(PDOException $e) {
            $erro = 'Erro ao enviar mensagem. Tente novamente.';
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h1>Entre em Contato</h1>
    </div>
    <div class="card-body">
        <p>Estamos aqui para atender você! Entre em contato conosco através do formulário abaixo ou utilize nossos dados de contato.</p>
    </div>
</div>

<?php if ($mensagem_enviada): ?>
    <div class="alert alert-success">
        <strong>Mensagem enviada com sucesso!</strong> Entraremos em contato em breve.
    </div>
<?php endif; ?>

<?php if (!empty($erro)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($erro) ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Envie sua Mensagem</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                    
                    <div class="form-group">
                        <label for="nome">Nome Completo *</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" 
                               value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" 
                               placeholder="(41) 99999-9999">
                    </div>
                    
                    <div class="form-group">
                        <label for="mensagem">Mensagem *</label>
                        <textarea class="form-control" id="mensagem" name="mensagem" 
                                  rows="5" required placeholder="Descreva o serviço desejado ou sua dúvida..."><?= htmlspecialchars($_POST['mensagem'] ?? '') ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        Enviar Mensagem
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3>Informações de Contato</h3>
            </div>
            <div class="card-body">
                <h4>📍 Endereço</h4>
                <p>
                    Rua das Oficinas, 123<br>
                    Centro - Curitiba - PR<br>
                    CEP: 80010-000
                </p>
                
                <h4>📞 Telefones</h4>
                <p>
                    <strong>Fixo:</strong> (41) 3333-4444<br>
                    <strong>WhatsApp:</strong> (41) 99999-8888
                </p>
                
                <h4>📧 Email</h4>
                <p>contato@oficinajao.com.br</p>
                
                <h4>🕒 Horário de Funcionamento</h4>
                <p>
                    <strong>Segunda à Sexta:</strong> 8h às 18h<br>
                    <strong>Sábado:</strong> 8h às 12h<br>
                    <strong>Domingo:</strong> Fechado
                </p>
            </div>
        </div>
        
        <div class="card" style="margin-top: 1rem;">
            <div class="card-header">
                <h3>Redes Sociais</h3>
            </div>
            <div class="card-body" style="text-align: center;">
                <p>Siga-nos nas redes sociais para ficar por dentro das novidades!</p>
                
                <div style="margin-top: 1rem;">
                    <a href="https://www.facebook.com/universidadepositivo/?locale=pt_BR" class="btn btn-primary" style="margin: 0.25rem;">
                        📘 Facebook
                    </a>
                    <a href="https://www.whatsapp.com/" class="btn btn-success" style="margin: 0.25rem;">
                        📱 WhatsApp
                    </a>
                    <a href="https://www.instagram.com/universidadepositivo/" class="btn btn-warning" style="margin: 0.25rem;">
                        📷 Instagram
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2>Como Chegar</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>🚗 De Carro</h4>
                <p>Nossa oficina fica no centro de Curitiba, com fácil acesso pelas principais avenidas. Temos estacionamento próprio para nossos clientes.</p>
                
                <h4>🚌 Transporte Público</h4>
                <p>Diversas linhas de ônibus passam próximo à nossa oficina. A parada mais próxima fica a apenas 50 metros.</p>
            </div>
            <div class="col-md-6">
                <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; text-align: center;">
                    <h4>📍 Localização</h4>
                    <p>Centro de Curitiba</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3603.140057365398!2d-49.27829022456741!3d-25.4335806775595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dce472e85bb7eb%3A0x78328b9f96a47e4d!2sUP%20-%20Universidade%20Positivo%20-%20Campus%20Pra%C3%A7a%20Os%C3%B3rio!5e0!3m2!1spt-BR!2sbr!4v1749055946580!5m2!1spt-BR!2sbr" width="450" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <a href="https://maps.app.goo.gl/6ohRRsyDNxd3KcQ29" target="_blank" class="btn btn-primary">
                        Ver no Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>