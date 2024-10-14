<?php
require_once "bd.php";
session_start();

// Verificar si la empresa está autenticada
if (!isset($_SESSION['empresa'])) {
    header("Location: login_empresa.php");
    exit();
}

// Obtener los parámetros de la URL
$id_postulacion = isset($_GET['id_postulacion']) ? (int)$_GET['id_postulacion'] : 0;
$tipo_cv = isset($_GET['tipo_cv']) ? $_GET['tipo_cv'] : '';

// Cambiar el estado de la postulación según la acción
$estado_nuevo = 'visto'; // Cambia esto según el estado que necesites (visto, seleccionado, rechazado)

$sql_actualizar = "UPDATE postulaciones SET estado = :estado_nuevo WHERE id_postulacion = :id_postulacion"; 
$stmt_actualizar = $conexion->prepare($sql_actualizar);
$stmt_actualizar->execute([':estado_nuevo' => $estado_nuevo, ':id_postulacion' => $id_postulacion]);

// Obtener el id_usuario y el nombre de la postulación
$sql_usuario = "SELECT id_usuario, (SELECT titulo FROM vacantes WHERE id = (SELECT id_vacante FROM postulaciones WHERE id_postulacion = :id_postulacion)) AS nombre_postulacion FROM postulaciones WHERE id_postulacion = :id_postulacion"; 
$stmt_usuario = $conexion->prepare($sql_usuario);
$stmt_usuario->execute([':id_postulacion' => $id_postulacion]);
$usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

// Insertar notificación solo si se encontró el usuario
if ($usuario) {
    $id_usuario_postulante = $usuario['id_usuario'];
    $nombre_postulacion = $usuario['nombre_postulacion'];

    // Crear mensaje de notificación según el estado
    if ($estado_nuevo === 'visto') {
        $mensaje = "Tu CV para $nombre_postulacion fue visto.";
    } elseif ($estado_nuevo === 'seleccionado') {
        $mensaje = "Tu CV para $nombre_postulacion ha sido seleccionado. Pronto la empresa se comunicará con vos para una entrevista.";
    } elseif ($estado_nuevo === 'rechazado') {
        $mensaje = "Lo sentimos, tu CV para la búsqueda $nombre_postulacion ha sido rechazado.";
    }

    // Insertar la notificación en la base de datos
    $sql_notificacion = "INSERT INTO notificaciones (id_usuario, mensaje, estado) VALUES (?, ?, ?)";
    $stmt_notificacion = $conexion->prepare($sql_notificacion);
    $stmt_notificacion->execute([$id_usuario_postulante, $mensaje, $estado_nuevo]);
}

// Redirigir según el tipo de CV
if ($tipo_cv === 'pdf') {
    $cv_pdf = "SELECT cv_pdf FROM usuarios WHERE id_usuario = (SELECT id_usuario FROM postulaciones WHERE id_postulacion = :id_postulacion)";
    $stmt_cv = $conexion->prepare($cv_pdf);
    $stmt_cv->execute([':id_postulacion' => $id_postulacion]);
    $cv = $stmt_cv->fetch(PDO::FETCH_ASSOC);

    if ($cv) {
        header("Location: " . htmlspecialchars($cv['cv_pdf']));
        exit();
    } else {
        echo "<p>No se encontró el CV en PDF para este usuario.</p>";
    }
} elseif ($tipo_cv === 'manual') {
    // Redirigir a ver_cv_manual.php con el id_usuario
    header("Location: ver_cv_manual.php?id_usuario=" . $id_usuario_postulante);
    exit();
}
?>
