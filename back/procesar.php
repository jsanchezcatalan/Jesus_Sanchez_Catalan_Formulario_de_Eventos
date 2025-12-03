<?php
// Función para limpiar datos
function limpiar($dato) {
    return htmlspecialchars(trim($dato));
}

// Verificar método POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.html");
    exit();
}

// Capturar y limpiar datos - USANDO LOS NAMES QUE FALTAN EN TU HTML
$nombre = limpiar($_POST['nombre'] ?? '');
$email = limpiar($_POST['email'] ?? '');
$telefono = limpiar($_POST['telefono'] ?? '');
$fecha_nacimiento = limpiar($_POST['fecha_nacimiento'] ?? '');
$genero = limpiar($_POST['genero'] ?? '');
$fecha_evento = limpiar($_POST['fecha_evento'] ?? '');
$tipo_entrada = limpiar($_POST['tipo_entrada'] ?? '');
$preferencias_comida = $_POST['preferencias_comida'] ?? [];
$usuario = limpiar($_POST['usuario'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
$notificaciones = isset($_POST['email_contacto']) ? 'Sí' : 'No';
$calificacion = limpiar($_POST['calificador'] ?? '5');
$comentarios = limpiar($_POST['comentarios'] ?? 'Sin comentarios');
$archivo = $_FILES['archivo']['name'] ?? 'No se adjuntó archivo';

// Validaciones básicas
$errores = [];
if (empty($nombre)) $errores[] = "Nombre requerido";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email inválido";
if (empty($telefono)) $errores[] = "Teléfono requerido";
if (empty($fecha_nacimiento)) $errores[] = "Fecha de nacimiento requerida";
if (empty($genero)) $errores[] = "Género requerido";
if (empty($fecha_evento)) $errores[] = "Fecha del evento requerida";
if (empty($tipo_entrada)) $errores[] = "Tipo de entrada requerido";
if (empty($usuario)) $errores[] = "Usuario requerido";
if (empty($contrasena)) $errores[] = "Contraseña requerida";
if ($contrasena !== $confirmar_contrasena) $errores[] = "Las contraseñas no coinciden";
if (!isset($_POST['terminos_condiciones'])) $errores[] = "Debe aceptar términos y condiciones";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <h4>Errores encontrados:</h4>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="javascript:history.back()" class="btn btn-danger mt-2">Volver</a>
        </div>
    <?php else: ?>
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h2>✓ Registro Completado</h2>
            </div>
            <div class="card-body">
                
                <h4 class="text-secondary border-bottom pb-2">Información Personal</h4>
                <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
                <p><strong>Fecha de nacimiento:</strong> <?php echo date('d/m/Y', strtotime($fecha_nacimiento)); ?></p>
                <p><strong>Género:</strong> <?php echo $genero; ?></p>
                
                <h4 class="text-secondary border-bottom pb-2 mt-4">Información del Evento</h4>
                <p><strong>Fecha del evento:</strong> <?php echo date('d/m/Y', strtotime($fecha_evento)); ?></p>
                <p><strong>Tipo de entrada:</strong> <span class="badge bg-info"><?php echo $tipo_entrada; ?></span></p>
                <p><strong>Preferencias de comida:</strong> 
                    <?php 
                    if (!empty($preferencias_comida)) {
                        foreach ($preferencias_comida as $pref) {
                            echo '<span class="badge bg-success me-1">' . limpiar($pref) . '</span>';
                        }
                    } else {
                        echo '<span class="text-muted">Sin preferencias</span>';
                    }
                    ?>
                </p>
                
                <h4 class="text-secondary border-bottom pb-2 mt-4">Información de Acceso</h4>
                <p><strong>Usuario:</strong> <?php echo $usuario; ?></p>
                <p><strong>Contraseña:</strong> <span class="text-muted">••••••••</span></p>
                
                <h4 class="text-secondary border-bottom pb-2 mt-4">Preferencias de Contacto</h4>
                <p><strong>Notificaciones por email:</strong> 
                    <?php echo $notificaciones == 'Sí' ? '<span class="badge bg-primary">Sí</span>' : '<span class="badge bg-secondary">No</span>'; ?>
                </p>
                <p><strong>Términos:</strong> <span class="badge bg-success">Aceptados</span></p>
                
                <h4 class="text-secondary border-bottom pb-2 mt-4">Encuesta Adicional</h4>
                <p><strong>Calificación:</strong> <?php echo $calificacion; ?>/10</p>
                <div class="progress mb-3" style="height: 25px;">
                    <div class="progress-bar bg-warning" style="width: <?php echo ($calificacion * 10); ?>%;">
                        <?php echo $calificacion; ?>/10
                    </div>
                </div>
                <p><strong>Comentarios:</strong></p>
                <div class="alert alert-light"><?php echo nl2br($comentarios); ?></div>
                <p><strong>Archivo:</strong> <span class="badge bg-secondary"><?php echo $archivo; ?></span></p>
                
                <div class="alert alert-info mt-4">
                    <strong>Fecha de registro:</strong> <?php echo date('d/m/Y H:i:s'); ?>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.html" class="btn btn-primary">Volver al inicio</a>
                    <button onclick="window.print()" class="btn btn-secondary">Imprimir</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
</div>

<footer class="text-center mt-4 mb-3">
    <p class="text-muted">Formulario creado por Jesús Sánchez Catalán - 2025</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>