<?php
require_once "bd.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']['id_usuario'])) {
    die('ID de usuario no encontrado en la sesión.');
}

$id_usuario = $_SESSION['usuario']['id_usuario']; // Obtener el ID del usuario desde la sesión

// Verificar la conexión a la base de datos
if (!$conexion) {
    die("La conexión a la base de datos falló.");
}

// Obtener datos del formulario
$id_vacante = isset($_POST['id_vacante']) ? (int)$_POST['id_vacante'] : 0;
$tipo_cv = isset($_POST['tipo_cv']) ? $_POST['tipo_cv'] : ''; 

// Validar datos
if (empty($id_vacante) || empty($id_usuario) || empty($tipo_cv)) {
    echo "Todos los campos son requeridos.";
    exit();
}

// Preparar la consulta SQL para insertar la postulación
$sql = "INSERT INTO postulaciones (id_vacante, id_usuario, tipo_cv, fecha_postulacion) VALUES (:id_vacante, :id_usuario, :tipo_cv, NOW())";
$stmt = $conexion->prepare($sql);

// Ejecutar la consulta
try {
    $stmt->execute([
        ':id_vacante' => $id_vacante,
        ':id_usuario' => $id_usuario,
        ':tipo_cv' => $tipo_cv
    ]);

    echo "<script>
    alert('Postulación realizada con éxito.');
    setTimeout(function() {
        window.location.href = 'motor_busqueda.php';
    }, 2000); // Redirige después de 2 segundos
</script>";
} catch (PDOException $e) {
// Manejar errores
echo "<script>
    alert('Error al procesar la postulación: " . $e->getMessage() . "');
</script>";
}
?>
