<?php
require_once 'bd.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login_postulante.php');
    exit();
}

$id_usuario = $_SESSION['usuario']['id_usuario'];

// Obtener todas las notificaciones
$sql = "SELECT * FROM notificaciones WHERE id_usuario = ? ORDER BY fecha DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_usuario]);
$notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar solo las no leídas
$count_unread = 0;
foreach ($notificaciones as $notificacion) {
    if ($notificacion['leida'] == 0) {
        $count_unread++;
    }
}

// Retornar las notificaciones y el conteo
$response = [
    'notificaciones' => $notificaciones,
    'count_unread' => $count_unread,
];

header('Content-Type: application/json');
echo json_encode($response);
?>
