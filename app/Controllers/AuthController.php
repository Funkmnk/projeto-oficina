<?php
// app/Controllers/AuthController.php

// Processar logout
if ($page === 'logout') {
    // Limpar sessão
    $_SESSION = array();
    
    // Destruir cookie de sessão se existir
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destruir sessão
    session_destroy();
    
    // Redirecionar para home
    redirect('?page=home');
}
?>