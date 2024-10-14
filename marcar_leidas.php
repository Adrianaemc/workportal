<?php
require_once 'bd.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login_postulante.php');
    exit();
}

$id_usuario = $_SESSION['usuario']['id_usuario'];

// Marcar todas las notificaciones como leídas
$sql = "UPDATE notificaciones SET leida = 1 WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_usuario]);
?>
