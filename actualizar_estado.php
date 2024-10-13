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

// Actualizar el estado a 'visto'
$sql_actualizar = "UPDATE postulaciones SET estado = 'visto' WHERE id_postulacion = :id_postulacion"; // Usar 'id_postulacion'
$stmt_actualizar = $conexion->prepare($sql_actualizar);
$stmt_actualizar->execute([':id_postulacion' => $id_postulacion]);

// Redirigir según el tipo de CV
if ($tipo_cv === 'pdf') {
    $cv_pdf = "SELECT cv_pdf FROM usuarios WHERE id_usuario = (SELECT id_usuario FROM postulaciones WHERE id_postulacion = :id_postulacion)"; // Usar 'id_postulacion'
    $stmt_cv = $conexion->prepare($cv_pdf);
    $stmt_cv->execute([':id_postulacion' => $id_postulacion]);
    $cv = $stmt_cv->fetch(PDO::FETCH_ASSOC);
    
    header("Location: " . htmlspecialchars($cv['cv_pdf']));
    exit();
} elseif ($tipo_cv === 'manual') {
    // Obtener el id_usuario de la postulación
    $sql_usuario = "SELECT id_usuario FROM postulaciones WHERE id_postulacion = :id_postulacion"; // Usar 'id_postulacion'
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->execute([':id_postulacion' => $id_postulacion]);
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Redirigir a ver_cv_manual.php con el id_usuario
        header("Location: ver_cv_manual.php?id_usuario=" . $usuario['id_usuario']);
    } else {
        // Manejo del caso en que no se encuentra el usuario
        echo "<p>No se encontró información para esta postulación.</p>";
    }
    exit();
}
?>
