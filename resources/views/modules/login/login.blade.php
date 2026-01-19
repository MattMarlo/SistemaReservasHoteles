<?php
require_once 'config.php';

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.html');
    exit();
}

// Obtener y sanitizar datos
$username = sanitize($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Validaciones
$errors = [];

if (empty($username)) {
    $errors[] = "El usuario o email es requerido";
}

if (empty($password)) {
    $errors[] = "La contraseña es requerida";
}

if (!empty($errors)) {
    header('Location: ../login.html?error=' . urlencode(implode('|', $errors)));
    exit();
}

// Conexión a la base de datos
$pdo = getConnection();
if (!$pdo) {
    header('Location: ../login.html?error=' . urlencode('Error de conexión con el servidor'));
    exit();
}

try {
    // Buscar usuario por username o email
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE (username = ? OR email = ?) AND estado = 'activo'");
    $stmt->execute([$username, $username]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        logAccess(null, false, $username);
        header('Location: ../login.html?error=' . urlencode('Usuario no encontrado o inactivo'));
        exit();
    }
    
    // Verificar contraseña
    if (!password_verify($password, $usuario['password_hash'])) {
        logAccess($usuario['id'], false, $username);
        header('Location: ../login.html?error=' . urlencode('Contraseña incorrecta'));
        exit();
    }
    
    // Iniciar sesión
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['username'] = $usuario['username'];
    $_SESSION['rol'] = $usuario['rol'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['last_activity'] = time();
    
    // Si se marcó "Recordarme", crear cookie
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        $expires = time() + (30 * 24 * 60 * 60); // 30 días
        
        setcookie('remember_token', $token, $expires, '/', '', true, true);
        
        // Guardar token en la base de datos
        $stmt = $pdo->prepare("UPDATE usuarios SET reset_token = ?, token_expira = ? WHERE id = ?");
        $stmt->execute([
            password_hash($token, PASSWORD_DEFAULT),
            date('Y-m-d H:i:s', $expires),
            $usuario['id']
        ]);
    }
    
    // Actualizar último login
    $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?");
    $stmt->execute([$usuario['id']]);
    
    // Registrar acceso exitoso
    logAccess($usuario['id'], true, $username);
    
    // Redireccionar según el rol
    $redirect = getRedirectByRole($usuario['rol']);
    header("Location: $redirect");
    exit();
    
} catch (PDOException $e) {
    error_log("Error en login: " . $e->getMessage());
    header('Location: ../login.html?error=' . urlencode('Error del sistema'));
    exit();
}

// Función para registrar acceso
function logAccess($usuario_id, $exito, $username) {
    $pdo = getConnection();
    if (!$pdo) return;
    
    try {
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $stmt = $pdo->prepare("INSERT INTO logs_acceso (usuario_id, ip_address, user_agent, exito) VALUES (?, ?, ?, ?)");
        $stmt->execute([$usuario_id, $ip, $user_agent, $exito]);
    } catch (PDOException $e) {
        error_log("Error al registrar log: " . $e->getMessage());
    }
}

// Función para redireccionar según rol
function getRedirectByRole($rol) {
    switch ($rol) {
        case 'gerencia':
            return '../dashboard/gerencia.php';
        case 'administracion':
            return '../dashboard/administracion.php';
        case 'recepcion':
            return '../dashboard/recepcion.php';
        case 'limpieza':
            return '../dashboard/limpieza.php';
        default:
            return '../dashboard/index.php';
    }
}
?>