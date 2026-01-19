<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'hotel_management');
define('DB_USER', 'root'); // Cambiar según tu configuración
define('DB_PASS', ''); // Cambiar según tu configuración

// Configuración de seguridad
define('SALT_KEY', 'hotel_paradise_salt_2024'); // Cambiar por una clave única
define('SESSION_TIMEOUT', 3600); // 1 hora en segundos

// Configuración de la aplicación
define('APP_NAME', 'Hotel Paradise');
define('APP_URL', 'http://localhost/hotel'); // Cambiar según tu URL

// Iniciar sesión segura
session_start();

// Conexión a la base de datos
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Error de conexión: " . $e->getMessage());
        return null;
    }
}

// Función para sanitizar datos
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Verificar si el usuario está logueado
function isLoggedIn() {
    if (!isset($_SESSION['usuario_id'])) {
        return false;
    }
    
    // Verificar timeout de sesión
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        return false;
    }
    
    $_SESSION['last_activity'] = time();
    return true;
}

// Redireccionar si no está logueado
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login.html');
        exit();
    }
}

// Obtener información del usuario actual
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $pdo = getConnection();
    if (!$pdo) return null; 
    
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, nombre, apellido, rol, departamento FROM usuarios WHERE id = ? AND estado = 'activo'");
        $stmt->execute([$_SESSION['usuario_id']]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error al obtener usuario: " . $e->getMessage());
        return null;
    }
}
?>