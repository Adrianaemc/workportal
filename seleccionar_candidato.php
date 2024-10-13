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
