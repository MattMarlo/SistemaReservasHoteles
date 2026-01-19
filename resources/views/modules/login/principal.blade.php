<?php
require_once '../php/config.php';
requireLogin();

$usuario = getCurrentUser();

// Si no se encuentra usuario, cerrar sesión
if (!$usuario) {
    session_unset();
    session_destroy();
    header('Location: ../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="user-info">
                    <div class="avatar">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </div>
                    <div class="user-details">
                        <h3><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h3>
                        <p class="role-badge"><?php echo htmlspecialchars(ucfirst($usuario['rol'])); ?></p>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-menu">
                <ul>
                    <li class="active">
                        <a href="index.php">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <?php if ($usuario['rol'] == 'recepcion' || $usuario['rol'] == 'gerencia'): ?>
                    <li>
                        <a href="reservas.php">
                            <i class="fas fa-calendar-check"></i> Reservas
                        </a>
                    </li>
                    <li>
                        <a href="clientes.php">
                            <i class="fas fa-users"></i> Clientes
                        </a>
                    </li>
                    <li>
                        <a href="habitaciones.php">
                            <i class="fas fa-bed"></i> Habitaciones
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($usuario['rol'] == 'gerencia' || $usuario['rol'] == 'administracion'): ?>
                    <li>
                        <a href="reportes.php">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                    </li>
                    <li>
                        <a href="empleados.php">
                            <i class="fas fa-user-tie"></i> Empleados
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if ($usuario['rol'] == 'limpieza'): ?>
                    <li>
                        <a href="tareas.php">
                            <i class="fas fa-broom"></i> Tareas de Limpieza
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <li>
                        <a href="perfil.php">
                            <i class="fas fa-user-cog"></i> Mi Perfil
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <a href="../php/logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <h1>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h1>
                    <p>Sistema de Gestión Hotelera</p>
                </div>
                <div class="header-right">
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="date-time">
                        <span id="current-date"></span>
                        <span id="current-time"></span>
                    </div>
                </div>
            </header>
            
            <div class="content-wrapper">
                <!-- Widgets -->
                <div class="dashboard-widgets">
                    <?php if ($usuario['rol'] == 'recepcion' || $usuario['rol'] == 'gerencia'): ?>
                    <div class="widget">
                        <div class="widget-icon checkin">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="widget-info">
                            <h3>Check-ins Hoy</h3>
                            <p class="widget-value">12</p>
                        </div>
                    </div>
                    
                    <div class="widget">
                        <div class="widget-icon checkout">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="widget-info">
                            <h3>Check-outs Hoy</h3>
                            <p class="widget-value">8</p>
                        </div>
                    </div>
                    
                    <div class="widget">
                        <div class="widget-icon occupancy">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <div class="widget-info">
                            <h3>Ocupación</h3>
                            <p class="widget-value">85%</p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="widget">
                        <div class="widget-icon tasks">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="widget-info">
                            <h3>Tareas Pendientes</h3>
                            <p class="widget-value"><?php echo ($usuario['rol'] == 'limpieza') ? '15' : '5'; ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Últimas actividades -->
                <div class="activity-section">
                    <h2><i class="fas fa-history"></i> Actividad Reciente</h2>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                            <div class="activity-content">
                                <p>Sesión iniciada correctamente</p>
                                <span class="activity-time">Hace 5 minutos</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-bed text-primary"></i>
                            </div>
                            <div class="activity-content">
                                <p>Habitación 203 marcada como limpia</p>
                                <span class="activity-time">Hace 2 horas</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-credit-card text-warning"></i>
                            </div>
                            <div class="activity-content">
                                <p>Nueva reserva confirmada - Hab. 301</p>
                                <span class="activity-time">Hace 4 horas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../js/dashboard.js"></script>
    <script>
        // Actualizar fecha y hora en tiempo real
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('es-ES', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            const time = now.toLocaleTimeString('es-ES');
            
            document.getElementById('current-date').textContent = date;
            document.getElementById('current-time').textContent = time;
        }
        
        // Actualizar cada segundo
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Manejar notificaciones
        document.querySelector('.notifications').addEventListener('click', function() {
            alert('Tienes 3 notificaciones pendientes');
        });
    </script>
</body>
</html>