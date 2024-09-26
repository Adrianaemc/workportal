<?php
// Incluir archivo de conexión a la base de datos
require_once 'bd.php';

// Iniciar sesión si aún no está iniciada
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login_postulante.php");
    exit();
}

// Obtener la información del usuario desde la sesión
$usuario = $_SESSION['usuario'];
$id_usuario = $usuario['id_usuario'];

// Definir la ruta de la imagen de perfil
$ruta_imagen_perfil = isset($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'img/sinfoto.png';

// Inicializar arrays para los datos de educación, experiencia e idiomas
$educacion = [];
$experiencia = [];
$sobre_mi = '';

// Verificar la conexión a la base de datos
if ($conexion) {
    // Obtener la información del campo "Sobre Mí"
    $sql = "SELECT sobre_mi FROM usuarios WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_usuario]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $sobre_mi = $result['sobre_mi'] ?? '';

    // Obtener la educación del usuario
    $sql = "SELECT * FROM educacion WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_usuario]);
    $educacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener la experiencia laboral del usuario
    $sql = "SELECT * FROM experiencia_laboral WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_usuario]);
    $experiencia = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Candidato</title>
    <link rel="stylesheet" href="styles/styles_perfil_postulante.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <?php include 'templates/header.php'; ?>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="cv_postulantes.php">Mi CV</a>
        <a href="mis_postulaciones.php">Mis Postulaciones</a>
        <a href="#">Configuración</a>
        <a href="cerrar_sesion_postulante.php">Cerrar Sesión</a>
        <a href="#"><i class="fas fa-bell"></i></a>
        <div class="seccion-busqueda">
            
            <form class="busqueda-form" action="motor_busqueda.php" method="GET">
                <input type="text" name="query" placeholder="Buscar empleo por puesto ..">
                <button type="submit">Buscar</button>
                <button>Ver Todos los Empleos</button>
            </form>
            
        </div>
    </nav>

    <div class="container">
        <div class="perfil-header">
            <img src="<?php echo htmlspecialchars($ruta_imagen_perfil); ?>" alt="Foto de perfil">
            <div class="info">
                <h1><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h1>
                <p id="sobre-mi"><?php echo nl2br(htmlspecialchars($sobre_mi)); ?></p>
                
                
            </div>
        </div>

        <div class="form-container">
            <div class="seccion-experiencia">
                <h3>Experiencia Laboral</h3>
                <?php if (!empty($experiencia)) : ?>
                    <ul>
                        <?php foreach ($experiencia as $exp) : ?>
                            <li>
                                <strong><?php echo htmlspecialchars($exp['puesto']); ?></strong> en <?php echo htmlspecialchars($exp['empresa']); ?><br>
                                Desde <?php echo htmlspecialchars($exp['fecha_inicio']); ?> hasta <?php echo htmlspecialchars($exp['fecha_fin']); ?><br>
                                <em>Tareas:</em> <?php echo htmlspecialchars($exp['tareas']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No hay experiencia laboral disponible.</p>
                <?php endif; ?>
            </div>

            <div class="seccion-educacion">
                <h3>Educación</h3>
                <?php if (!empty($educacion)) : ?>
                    <ul>
                        <?php foreach ($educacion as $edu) : ?>
                            <li>
                                <strong><?php echo htmlspecialchars($edu['titulo_carrera']); ?></strong> en <?php echo htmlspecialchars($edu['institucion']); ?><br>
                                Desde <?php echo htmlspecialchars($edu['fecha_inicio']); ?> hasta <?php echo htmlspecialchars($edu['fecha_fin']); ?><br>
                                Nivel de estudio: <?php echo htmlspecialchars($edu['nivel_estudio']); ?><br>
                                <?php if ($edu['actualidad']) : ?>
                                    <em>Actualmente cursando</em>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No hay información de educación disponible.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="seccion-recomendaciones">
            <h3>Empleos recomendados</h3>
            <p>Esta sección estará disponible próximamente.</p>
        </div>

       

        <div class="seccion-guardados">
            <h3>Empleos Guardados</h3>
            <p>Esta sección estará disponible próximamente.</p>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
