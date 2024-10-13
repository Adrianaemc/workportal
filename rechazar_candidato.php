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

    // Redirigir de vuelta a la página de postulantes
    header("Location: ver_postulantes.php?id_vacante=" . $_GET['id_vacante']);
    exit();
}
