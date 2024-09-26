<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Verificar si la empresa está autenticada
if (!isset($_SESSION['empresa'])) {
    // Si la empresa no está autenticada, redirigir al inicio de sesión
    header("Location: login_empresa.php");
    exit();
}

// Obtener los detalles de la empresa desde la sesión
$empresa = $_SESSION['empresa'];

// Verificar si se ha enviado el formulario de publicación de vacante
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $salario = $_POST["salario"];
    $modalidad = $_POST["modalidad"];
    $area = $_POST["area"];
    $provincia = $_POST["provincia"];
    $localidad = $_POST["localidad"];
    $pais = $_POST["pais"];
    $nivel_laboral = $_POST["nivel_laboral"];
    $carga_horaria = $_POST["carga_horaria"];

    // Validar los datos (puedes agregar tus propias reglas de validación aquí)

    // Preparar la consulta SQL para insertar la vacante
    require_once "bd.php"; // Incluye el archivo de conexión a la base de datos
    $sql = "INSERT INTO vacantes 
            (titulo, descripcion, salario, modalidad, id_empresa, area, provincia, localidad, pais, nivel_laboral, carga_horaria) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bindParam(1, $titulo);
    $stmt->bindParam(2, $descripcion);
    $stmt->bindParam(3, $salario);
    $stmt->bindParam(4, $modalidad);
    $stmt->bindParam(5, $empresa['id_empresa']);
    $stmt->bindParam(6, $area);
    $stmt->bindParam(7, $provincia);
    $stmt->bindParam(8, $localidad);
    $stmt->bindParam(9, $pais);
    $stmt->bindParam(10, $nivel_laboral);
    $stmt->bindParam(11, $carga_horaria);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La vacante se ha publicado correctamente, redirigir a la página de perfil de la empresa
        header("Location: perfil_empresa.php");
        exit();
    } else {
        // Ocurrió un error al publicar la vacante
        echo "Error al publicar la vacante. Por favor, inténtalo de nuevo.";
    }
} else {
    // Si se intenta acceder a este script directamente sin enviar el formulario, redirigir al formulario de publicación de vacantes
    header("Location: formulario_publicacion_vacante.php");
    exit();
}
?>
