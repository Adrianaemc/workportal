<?php 
require_once "bd.php";
session_start();

// Verificar si la empresa está autenticada
if (!isset($_SESSION['empresa'])) {
    header("Location: login_empresa.php");
    exit();
}

// Verificar si se ha enviado el ID de la postulación
if (isset($_POST['id_postulacion'])) {
    $id_postulacion = (int)$_POST['id_postulacion'];

    // Actualizar el estado de la postulación a 'seleccionado'
    $sql = "UPDATE postulaciones SET estado = 'seleccionado' WHERE id_postulacion = :id_postulacion";
    $stmt = $conexion->prepare($sql);

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
        $mensaje = "Tu CV para $nombre_postulacion ha sido seleccionado. Pronto la empresa se comunicará con vos para una entrevista.";
        
        // Insertar la notificación en la base de datos
        $sql_notificacion = "INSERT INTO notificaciones (id_usuario, mensaje, estado) VALUES (?, ?, 'seleccionado')";
        $stmt_notificacion = $conexion->prepare($sql_notificacion);
        $stmt_notificacion->execute([$id_usuario_postulante, $mensaje]);
    }
    
    if ($stmt->execute([':id_postulacion' => $id_postulacion])) {
        // Redirigir de vuelta a la página de postulantes con un mensaje de éxito
        header("Location: ver_postulantes.php?id_vacante=" . $_GET['id_vacante'] . "&success=1");
        exit();
    } else {
        // Manejo de error
        header("Location: ver_postulantes.php?id_vacante=" . $_GET['id_vacante'] . "&error=1");
        exit();
    }
} else {
    // Redirigir si no se recibió el ID
    header("Location: ver_postulantes.php?id_vacante=" . $_GET['id_vacante']);
    exit();
}
