<?php
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

function getDB() {
    $database = new Database();
    return $database->getConnection();
}

define('BASE_URL', 'http://localhost/projeto-oficina/public/');
define('APP_NAME', 'Oficina do João');

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['usuario_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('index.php?page=login');
    }
}
?>