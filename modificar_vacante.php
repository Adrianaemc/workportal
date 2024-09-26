<?php
// Verificar si se ha proporcionado un ID de vacante válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirigir a alguna página de manejo de errores
    header("Location: error.php");
    exit();
}

// Obtener el ID de la vacante desde los parámetros GET
$id_vacante = $_GET['id'];

// Obtener los detalles de la vacante desde la base de datos utilizando el ID
require_once "bd.php"; // Incluye el archivo de conexión a la base de datos
$sql_vacante = "SELECT * FROM vacantes WHERE id = ?";
$stmt_vacante = $conexion->prepare($sql_vacante);
$stmt_vacante->bindParam(1, $id_vacante);
$stmt_vacante->execute();
$vacante = $stmt_vacante->fetch(PDO::FETCH_ASSOC);

// Verificar si la vacante existe
if (!$vacante) {
    // Redirigir a alguna página de manejo de errores
    header("Location: error.php");
    exit();
}

// Procesar el formulario de modificación si se ha enviado
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

    // Preparar la consulta SQL para actualizar la vacante
    $sql_actualizar = "UPDATE vacantes 
                       SET titulo = ?, descripcion = ?, salario = ?, modalidad = ?, area = ?, provincia = ?, localidad = ?, pais = ?, nivel_laboral = ?, carga_horaria = ? 
                       WHERE id = ?";
    $stmt_actualizar = $conexion->prepare($sql_actualizar);
    $stmt_actualizar->bindParam(1, $titulo);
    $stmt_actualizar->bindParam(2, $descripcion);
    $stmt_actualizar->bindParam(3, $salario);
    $stmt_actualizar->bindParam(4, $modalidad);
    $stmt_actualizar->bindParam(5, $area);
    $stmt_actualizar->bindParam(6, $provincia);
    $stmt_actualizar->bindParam(7, $localidad);
    $stmt_actualizar->bindParam(8, $pais);
    $stmt_actualizar->bindParam(9, $nivel_laboral);
    $stmt_actualizar->bindParam(10, $carga_horaria);
    $stmt_actualizar->bindParam(11, $id_vacante);

    // Ejecutar la consulta
    if ($stmt_actualizar->execute()) {
        // Redirigir a la página de perfil de empresa después de la modificación
        header("Location: perfil_empresa.php");
        exit();
    } else {
        // Ocurrió un error al actualizar la vacante
        echo "Error al actualizar la vacante. Por favor, inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Vacante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h1>Modificar Vacante</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($vacante['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required><?php echo htmlspecialchars($vacante['descripcion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="salario">Salario:</label>
                <input type="number" class="form-control" id="salario" name="salario" value="<?php echo htmlspecialchars($vacante['salario']); ?>" required>
            </div>
            <div class="form-group">
                <label for="modalidad">Modalidad:</label>
                <select class="form-control" id="modalidad" name="modalidad" required>
                    <option value="Remoto" <?php if ($vacante['modalidad'] === "Remoto") echo "selected"; ?>>Remoto</option>
                    <option value="Presencial" <?php if ($vacante['modalidad'] === "Presencial") echo "selected"; ?>>Presencial</option>
                    <option value="Híbrido" <?php if ($vacante['modalidad'] === "Híbrido") echo "selected"; ?>>Híbrido</option>
                </select>
            </div>
            <div class="form-group">
                <label for="area">Área:</label>
                <select class="form-control" id="area" name="area" required>
                    <option value="Administración y Finanzas" <?php if ($vacante['area'] === "Administración y Finanzas") echo "selected"; ?>>Administración y Finanzas</option>
                    <option value="Oficios y Otros" <?php if ($vacante['area'] === "Oficios y Otros") echo "selected"; ?>>Oficios y Otros</option>
                    <option value="Atención al Cliente o Call Center" <?php if ($vacante['area'] === "Atención al Cliente o Call Center") echo "selected"; ?>>Atención al Cliente o Call Center</option>
                    <option value="Salud" <?php if ($vacante['area'] === "Salud") echo "selected"; ?>>Salud</option>
                    <option value="RRHH" <?php if ($vacante['area'] === "RRHH") echo "selected"; ?>>RRHH</option>
                    <option value="Ingenierías" <?php if ($vacante['area'] === "Ingenierías") echo "selected"; ?>>Ingenierías</option>
                </select>
            </div>
            <div class="form-group">
                <label for="provincia">Provincia:</label>
                <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo htmlspecialchars($vacante['provincia']); ?>" required>
            </div>
            <div class="form-group">
                <label for="localidad">Localidad:</label>
                <input type="text" class="form-control" id="localidad" name="localidad" value="<?php echo htmlspecialchars($vacante['localidad']); ?>" required>
            </div>
            <div class="form-group">
                <label for="pais">País:</label>
                <input type="text" class="form-control" id="pais" name="pais" value="<?php echo htmlspecialchars($vacante['pais']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nivel_laboral">Nivel Laboral:</label>
                <select class="form-control" id="nivel_laboral" name="nivel_laboral" required>
                    <option value="Junior" <?php if ($vacante['nivel_laboral'] === "Junior") echo "selected"; ?>>Junior</option>
                    <option value="Senior" <?php if ($vacante['nivel_laboral'] === "Senior") echo "selected"; ?>>Senior</option>
                    <option value="Jefe/Supervisor" <?php if ($vacante['nivel_laboral'] === "Jefe/Supervisor") echo "selected"; ?>>Jefe/Supervisor</option>
                    <option value="Gerencia" <?php if ($vacante['nivel_laboral'] === "Gerencia") echo "selected"; ?>>Gerencia</option>
                    <option value="Sin Experiencia" <?php if ($vacante['nivel_laboral'] === "Sin Experiencia") echo "selected"; ?>>Sin Experiencia</option>
                    <option value="Pasante" <?php if ($vacante['nivel_laboral'] === "Pasante") echo "selected"; ?>>Pasante</option>
                    <option value="Otro" <?php if ($vacante['nivel_laboral'] === "Otro") echo "selected"; ?>>Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="carga_horaria">Carga Horaria:</label>
                <select class="form-control" id="carga_horaria" name="carga_horaria" required>
                    <option value="Part-time" <?php if ($vacante['carga_horaria'] === "Part-time") echo "selected"; ?>>Part-time</option>
                    <option value="Full-time" <?php if ($vacante['carga_horaria'] === "Full-time") echo "selected"; ?>>Full-time</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        <footer><?php include 'templates/footer.php'; ?></footer>
    </div>
</body>
</html>
