<?php
function insertarNotificacion($conexion, $id_usuario, $mensaje, $estado) {
    $sql = "INSERT INTO notificaciones (id_usuario, mensaje, fecha, leida, estado) VALUES (?, ?, NOW(), 0, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_usuario, $mensaje, $estado]);
}
?>
