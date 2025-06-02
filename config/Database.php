<?php
// config/Database.php
class Database {
    private $host = 'localhost';
    private $db_name = 'oficina_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
            die();
        }
        
        return $this->conn;
    }
}

// Função global para obter conexão
function getDB() {
    $database = new Database();
    return $database->getConnection();
}

// Configurações gerais
define('BASE_URL', 'http://localhost/projeto-oficina/public/');
define('APP_NAME', 'Oficina do João');

// Função para gerar token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Função para verificar token CSRF
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Função para redirecionar
function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

// Função para verificar se está logado
function isLoggedIn() {
    return isset($_SESSION['usuario_id']);
}

// Função para exigir login
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
}
?>