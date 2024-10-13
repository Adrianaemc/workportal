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

// Ruta de la imagen de la empresa
$ruta_imagen_empresa = isset($empresa['foto_perfil']) ? $empresa['foto_perfil'] : 'img/sinfoto.png';

// Preparar la consulta SQL para obtener las vacantes según el estado seleccionado
require_once "bd.php"; 

// Verificar el estado seleccionado por el usuario (si está establecido)
$estado_vacante = isset($_GET['estado']) ? $_GET['estado'] : 'activa';

// Preparar la consulta SQL para obtener las vacantes por estado
$sql_vacantes = "SELECT * FROM vacantes WHERE id_empresa = ? AND estado = ?";
$stmt_vacantes = $conexion->prepare($sql_vacantes);
$stmt_vacantes->bindParam(1, $empresa['id_empresa']);
$stmt_vacantes->bindParam(2, $estado_vacante);
$stmt_vacantes->execute();
$vacantes = $stmt_vacantes->fetchAll(PDO::FETCH_ASSOC);

// Contar cuántas vacantes hay en total por estado
$sql_total_vacantes = "SELECT COUNT(*) FROM vacantes WHERE id_empresa = ? AND estado = ?";
$stmt_total = $conexion->prepare($sql_total_vacantes);
$stmt_total->bindParam(1, $empresa['id_empresa']);
$stmt_total->bindParam(2, $estado_vacante);
$stmt_total->execute();
$total_vacantes = $stmt_total->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Empresa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/perfil_empresas.css">
</head>
<body>
<header>
    <?php include 'templates/header.php'; ?>
</header> 
<main>
    <div class="container">
        <div id="perfil-empresa">
            <!-- Mostrar la imagen de la empresa -->
            <img src="<?php echo htmlspecialchars($ruta_imagen_empresa); ?>" alt="Foto de la empresa" id="imagen-empresa">
            <div id="datos-empresa">
                <h1 id="nombre-empresa"><?php echo htmlspecialchars($empresa['nombre_empresa']); ?></h1>
                <p id="descripcion-empresa"><?php echo htmlspecialchars($empresa['descripcion']); ?></p>
            </div>
        </div>
        
        <div style="position: fixed; top: 20px; right: 20px;">
            <a href="modificar_datos_empresa.php" class="btn btn-primary">Modificar Perfil</a>
            <a href="cerrar_sesion_empresa.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
        
        <!-- Mostrar las vacantes publicadas por la empresa -->
        <div>
            <div class="titulo">
                <h2>Vacantes Publicadas (<?php echo $total_vacantes; ?>)</h2>
                <a href="publicar_vacante.php" class="btn btn-publicar-vacante">Nueva Vacante</a>
            </div>
            
            <!-- Filtro por estado de vacantes -->
            <form method="GET" action="perfil_empresa.php" class="form-inline mt-3">
                <label for="estado">Mostrar:</label>
                <select name="estado" id="estado" class="form-control ml-2" onchange="this.form.submit()">
                    <option value="activa" <?php if ($estado_vacante == 'activa') echo 'selected'; ?>>Búsquedas activas</option>
                    <option value="finalizada" <?php if ($estado_vacante == 'finalizada') echo 'selected'; ?>>Búsquedas finalizadas</option>
                </select>
            </form>
        </div>

        <!-- Listar las vacantes según el estado seleccionado -->
        <div class="mt-4">
            <?php foreach ($vacantes as $vacante): ?>
                <div class="vacante <?php echo htmlspecialchars($vacante['estado']); ?> mb-4 p-3 border rounded">
                    <h3><?php echo htmlspecialchars($vacante['titulo']); ?></h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Salario:</strong> <?php echo htmlspecialchars($vacante['salario']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Modalidad:</strong> <?php echo htmlspecialchars($vacante['modalidad']); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Área:</strong> <?php echo htmlspecialchars($vacante['area']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Provincia:</strong> <?php echo htmlspecialchars($vacante['provincia']); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Localidad:</strong> <?php echo htmlspecialchars($vacante['localidad']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>País:</strong> <?php echo htmlspecialchars($vacante['pais']); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nivel Laboral:</strong> <?php echo htmlspecialchars($vacante['nivel_laboral']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Carga Horaria:</strong> <?php echo htmlspecialchars($vacante['carga_horaria']); ?></p>
                        </div>
                    </div>
                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($vacante['descripcion']); ?></p>
                    <a href="modificar_vacante.php?id=<?php echo htmlspecialchars($vacante['id']); ?>" class="btn btn-primary btn-modificar">Modificar</a>
                    <a href="eliminar_vacante.php?id=<?php echo htmlspecialchars($vacante['id']); ?>" class="btn btn-danger btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta vacante?')">Eliminar</a>
                    <a href="ver_postulantes.php?id_vacante=<?php echo htmlspecialchars($vacante['id']); ?>" class="btn btn-info">Ver Postulantes</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<footer>
    <?php include 'templates/footer.php'; ?>
</footer>
</body>
</html>
