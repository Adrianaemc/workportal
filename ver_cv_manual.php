<?php
require_once "bd.php";
session_start();

// Verificar si la empresa está autenticada
if (!isset($_SESSION['empresa'])) {
    header("Location: login_empresa.php");
    exit();
}

// Obtener el ID del usuario desde la URL
$id_usuario = isset($_GET['id_usuario']) ? (int)$_GET['id_usuario'] : 0;

// Consultar la información personal del usuario
$sql_usuario = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
$stmt_usuario = $conexion->prepare($sql_usuario);
$stmt_usuario->execute([':id_usuario' => $id_usuario]);
$usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

// Verifica si se obtuvo un usuario
if (!$usuario) {
    echo "<p>No se encontró información para este usuario.</p>";
    exit();
}

// Consultar la educación del usuario
$sql_educacion = "SELECT * FROM educacion WHERE id_usuario = :id_usuario";
$stmt_educacion = $conexion->prepare($sql_educacion);
$stmt_educacion->execute([':id_usuario' => $id_usuario]);
$educacion = $stmt_educacion->fetchAll(PDO::FETCH_ASSOC);

// Consultar la experiencia laboral del usuario
$sql_experiencia = "SELECT * FROM experiencia_laboral WHERE id_usuario = :id_usuario";
$stmt_experiencia = $conexion->prepare($sql_experiencia);
$stmt_experiencia->execute([':id_usuario' => $id_usuario]);
$experiencia = $stmt_experiencia->fetchAll(PDO::FETCH_ASSOC);

// Consultar los idiomas del usuario
$sql_idiomas = "SELECT * FROM idiomas WHERE id_usuario = :id_usuario";
$stmt_idiomas = $conexion->prepare($sql_idiomas);
$stmt_idiomas->execute([':id_usuario' => $id_usuario]);
$idiomas = $stmt_idiomas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Manual del Postulante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/ver_postulantes.css">
</head>
<body>
<header>
    <?php include 'templates/header.php'; ?>
    <nav>
    <a href="javascript:history.back()">Volver a Postulantes</a>
        <a href="perfil_empresa.php">MI PERFIL</a>
        <a href="modificar_datos_empresa">Modificar mis datos</a>
        <a href="cerrar_sesion_empresa.php">Cerrar Sesión</a>
    </nav>
</header>

    <div class="container">
        <h2>CV Manual del Postulante</h2>

        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" class="card-img" alt="Foto de Perfil">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($usuario['nombre']); ?> <?php echo htmlspecialchars($usuario['apellido']); ?></h5>
                        <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($usuario['correo_electronico']); ?></p>
                        <p class="card-text"><strong>DNI:</strong> <?php echo htmlspecialchars($usuario['dni']); ?></p>
                        <p class="card-text"><strong>Localidad:</strong> <?php echo htmlspecialchars($usuario['localidad']); ?></p>
                        <p class="card-text"><strong>Provincia:</strong> <?php echo htmlspecialchars($usuario['provincia']); ?></p>
                        <p class="card-text"><strong>País:</strong> <?php echo htmlspecialchars($usuario['pais']); ?></p>
                        <p class="card-text"><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono']); ?></p>
                        
                        <h3>Educación</h3>
                        <ul>
                            <?php foreach ($educacion as $edu): ?>
                                <li>
                                    <strong>Institución:</strong> <?php echo htmlspecialchars($edu['institucion']); ?>, 
                                    <strong>Título:</strong> <?php echo htmlspecialchars($edu['titulo_carrera']); ?>, 
                                    <strong>Fecha Inicio:</strong> <?php echo htmlspecialchars($edu['fecha_inicio']); ?>, 
                                    <strong>Fecha Fin:</strong> <?php echo htmlspecialchars($edu['fecha_fin']); ?>, 
                                    <strong>Actualidad:</strong> <?php echo htmlspecialchars($edu['actualidad']); ?>, 
                                    <strong>Nivel de Estudio:</strong> <?php echo htmlspecialchars($edu['nivel_estudio']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <h3>Experiencia Laboral</h3>
                        <ul>
                            <?php foreach ($experiencia as $exp): ?>
                                <li>
                                    <strong>Puesto:</strong> <?php echo htmlspecialchars($exp['puesto']); ?>, 
                                    <strong>Empresa:</strong> <?php echo htmlspecialchars($exp['empresa']); ?>, 
                                    <strong>Fecha Inicio:</strong> <?php echo htmlspecialchars($exp['fecha_inicio']); ?>, 
                                    <strong>Fecha Fin:</strong> <?php echo htmlspecialchars($exp['fecha_fin']); ?>, 
                                    <strong>Actualidad:</strong> <?php echo htmlspecialchars($exp['actualidad']); ?>, 
                                    <strong>Tareas:</strong> <?php echo htmlspecialchars($exp['tareas']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <h3>Idiomas</h3>
                        <ul>
                            <?php foreach ($idiomas as $idioma): ?>
                                <li>
                                    <strong>Idioma:</strong> <?php echo htmlspecialchars($idioma['idioma']); ?>, 
                                    <strong>Nivel de Competencia:</strong> <?php echo htmlspecialchars($idioma['nivel_competencia']); ?>, 
                                    <strong>Nivel de Habilidad:</strong> <?php echo htmlspecialchars($idioma['nivel_habilidad']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
<footer><?php include 'templates/footer.php'; ?></footer>
</body>
</html>
