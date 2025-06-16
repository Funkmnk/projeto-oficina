<?php
if (isLoggedIn()) {
    redirect('index.php?page=dashboard');
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (empty($usuario) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } elseif (!verifyCSRFToken($csrf_token)) {
        $erro = 'Token de segurança inválido.';
    } else {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT id, nome, usuario, senha FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($senha, $user['senha'])) {
                // Login bem-sucedido
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_login'] = $user['usuario'];
                
                redirect('?page=dashboard');
            } else {
                $erro = 'Usuário ou senha incorretos.';
            }
        } catch(PDOException $e) {
            $erro = 'Erro no sistema. Tente novamente.';
        }
    }
}
?>

<div class="login-container">
    <div class="login-card">
        <h2>Login - <?= APP_NAME ?></h2>
        
        <?php if (!empty($erro)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            
            <div class="form-group">
                <label for="usuario">Usuário</label>
                <input type="text" class="form-control" id="usuario" name="usuario" 
                       value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                Entrar
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee;">
            <p style="color: #6c757d; font-size: 0.9rem;">
                Área restrita para funcionários
            </p>
            <a href="?page=home" class="btn btn-secondary">
                Voltar ao Site
            </a>
        </div>
    </div>
</div>

<div class="card" style="max-width: 400px; margin: 1rem auto;">
    <div class="card-header">
        <h4>Dados de Teste</h4>
    </div>
    <div class="card-body" style="font-size: 0.9rem;">
        <p><strong>Usuário:</strong> admin<br>
        <strong>Senha:</strong> password</p>
        <p style="color: #6c757d;">
            Use estes dados para testar o sistema.
        </p>
    </div>
</div>