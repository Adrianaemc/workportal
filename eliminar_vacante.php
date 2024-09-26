<?php
// Verificar si se ha recibido el ID de la vacante a eliminar
if (isset($_GET['id'])) {
    // Obtener el ID de la vacante desde el parámetro de la URL
    $id_vacante = $_GET['id'];

    // Preparar la consulta SQL para eliminar la vacante
    require_once "bd.php"; // Incluye el archivo de conexión a la base de datos
    $sql = "DELETE FROM vacantes WHERE id = ?";
    $stmt = $conexion->prepare($sql);

    // Vincular parámetro
    $stmt->bindParam(1, $id_vacante);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La vacante se ha eliminado correctamente, redirigir a la página del perfil de la empresa
        header("Location: perfil_empresa.php");
        exit();
    } else {
        // Ocurrió un error al eliminar la vacante
        echo "Error al eliminar la vacante. Por favor, inténtalo de nuevo.";
    }
} else {
    // Si no se proporcionó un ID de vacante, redirigir a alguna otra página (por ejemplo, al perfil de la empresa)
    header("Location: perfil_empresa.php");
    exit();
}
?>
