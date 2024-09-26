<?php
// Incluir el archivo de conexión a la base de datos
require_once "bd.php";

// Iniciar sesión si aún no está iniciada
session_start();

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre_empresa = $_POST["nombre_empresa"];
    $telefono = $_POST["telefono"];
    $descripcion = $_POST["descripcion"];
    $id_empresa = $_SESSION['empresa']['id_empresa'];

    // Manejar la carga de la imagen
    $foto_perfil = $_FILES['foto_perfil'];
    $ruta_foto_perfil = '';

    if ($foto_perfil['error'] == UPLOAD_ERR_OK) {
        $nombre_archivo = basename($foto_perfil['name']);
        $directorio_destino = 'uploads/' . $nombre_archivo;

        if (move_uploaded_file($foto_perfil['tmp_name'], $directorio_destino)) {
            $ruta_foto_perfil = $directorio_destino;
        }
    }

    // Actualizar los datos de la empresa en la base de datos
    $sql = "UPDATE empresas SET nombre_empresa = :nombre, telefono = :telefono, descripcion = :descripcion";
    
    if (!empty($ruta_foto_perfil)) {
        $sql .= ", foto_perfil = :foto_perfil";
    }

    $sql .= " WHERE id_empresa = :id";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre_empresa);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':id', $id_empresa);

    if (!empty($ruta_foto_perfil)) {
        $stmt->bindParam(':foto_perfil', $ruta_foto_perfil);
        $_SESSION['empresa']['foto_perfil'] = $ruta_foto_perfil;
    }

    // Ejecutar la consulta
    $stmt->execute();

    // Actualizar la sesión con los nuevos datos de la empresa
    $_SESSION['empresa']['nombre_empresa'] = $nombre_empresa;
    $_SESSION['empresa']['telefono'] = $telefono;
    $_SESSION['empresa']['descripcion'] = $descripcion;

    // Redirigir al perfil de la empresa
    header("Location: perfil_empresa.php");
    exit(); // Asegúrate de salir del script después de la redirección
} else {
    // Si se intenta acceder directamente a este archivo sin enviar datos del formulario, redirigir a algún lugar apropiado
    header("Location: index.php");
    exit(); // Asegúrate de salir del script después de la redirección
}
?>
