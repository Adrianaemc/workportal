<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['foto_perfil'])) {
    $directorio_destino = 'C:/xampp/htdocs/sitioweb/uploads';
    $nombre_temporal = $_FILES['foto_perfil']['tmp_name'];
    $nombre_archivo = uniqid('perfil_') . '.' . pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);

    if (move_uploaded_file($nombre_temporal, $directorio_destino . '/' . $nombre_archivo)) {
        $_SESSION['empresa']['imagen'] = $directorio_destino . '/' . $nombre_archivo;
        header("Location: perfil_empresa.php?mensaje=La foto de perfil se ha actualizado correctamente");
        exit();
    } else {
        header("Location: perfil_empresa.php?mensaje=Hubo un error al subir la foto de perfil");
        exit();
    }
} else {
    header("Location: perfil_empresa.php");
    exit();
}
?>

