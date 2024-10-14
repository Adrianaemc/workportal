<?php
require_once "bd.php";
session_start();

// Verificar si la empresa está autenticada
if (!isset($_SESSION['empresa'])) {
    header("Location: login_empresa.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_postulacion = $_POST['id_postulacion'];

    // Actualizar el estado a 'rechazado'
    $sql = "UPDATE postulaciones SET estado = 'rechazado' WHERE id_postulacion = :id_postulacion";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id_postulacion' => $id_postulacion]);

    // Obtener el id_usuario y el nombre de la postulación
    $sql_usuario = "SELECT id_usuario, (SELECT titulo FROM vacantes WHERE id = (SELECT id_vacante FROM postulaciones WHERE id_postulacion = :id_postulacion)) AS nombre_postulacion FROM postulaciones WHERE id_postulacion = :id_postulacion"; 
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->execute([':id_postulacion' => $id_postulacion]);
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

    // Insertar notificación solo si se encontró el usuario
    if ($usuario) {
        $id_usuario_postulante = $usuario['id_usuario'];
        $nombre_postulacion = $usuario['nombre_postulacion'];

        // Crear mensaje de notificación
        $mensaje = "Lo sentimos, tu CV para la búsqueda $nombre_postulacion ha sido rechazado.";
        
        // Insertar la notificación en la base de datos
        $sql_notificacion = "INSERT INTO notificaciones (id_usuario, mensaje, estado) VALUES (?, ?, 'rechazado')";
        $stmt_notificacion = $conexion->prepare($sql_notificacion);
        $stmt_notificacion->execute([$id_usuario_postulante, $mensaje]);
    }

    // Redirigir de vuelta a la página de postulantes
    header("Location: ver_postulantes.php?id_vacante=" . $_GET['id_vacante']);
    exit();
}
