<?php
require_once "bd.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']['id_usuario'])) {
    header("Location: login_postulante.php");
    exit();
}


$id_usuario = $_SESSION['usuario']['id_usuario'];

// Inicializar variables de búsqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$ubicacion = isset($_GET['ubicacion']) ? $_GET['ubicacion'] : '';
$modalidad = isset($_GET['modalidad']) ? $_GET['modalidad'] : '';
$nivel_laboral = isset($_GET['nivel_laboral']) ? $_GET['nivel_laboral'] : '';
$carga_horaria = isset($_GET['carga_horaria']) ? $_GET['carga_horaria'] : '';

// Construir la consulta base
$sql = "SELECT v.*, e.nombre_empresa, e.foto_perfil 
        FROM vacantes v
        INNER JOIN empresas e ON v.id_empresa = e.id_empresa
        WHERE 1=1";

$params = [];

// Agregar condiciones según los filtros recibidos
if (!empty($busqueda)) {
    $sql .= " AND (v.titulo LIKE :busqueda OR v.descripcion LIKE :busqueda)";
    $params[':busqueda'] = '%' . $busqueda . '%';
}

if (!empty($ubicacion)) {
    $sql .= " AND v.provincia = :ubicacion";
    $params[':ubicacion'] = $ubicacion;
}

if (!empty($modalidad)) {
    $sql .= " AND v.modalidad = :modalidad";
    $params[':modalidad'] = $modalidad;
}

if (!empty($nivel_laboral)) {
    $sql .= " AND v.nivel_laboral = :nivel_laboral";
    $params[':nivel_laboral'] = $nivel_laboral;
}

if (!empty($carga_horaria)) {
    $sql .= " AND v.carga_horaria = :carga_horaria";
    $params[':carga_horaria'] = $carga_horaria;
}

// Preparar consulta SQL
$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar si hay resultados
$mensaje_no_resultados = (count($resultados) === 0) ? "No hay ofertas disponibles" : "";

$sql_postulaciones = "SELECT id_vacante FROM postulaciones WHERE id_usuario = :id_usuario";
$stmt_postulaciones = $conexion->prepare($sql_postulaciones);
$stmt_postulaciones->execute([':id_usuario' => $id_usuario]);
$postulaciones = $stmt_postulaciones->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="styles/styles_motor.css">
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
    </nav>
    <div class="container">
        <div class="filtros">
            <form id="filtros-form" method="GET" action="">
                <input type="hidden" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
                <label for="filtro-ubicacion">Filtrar por Ubicación:</label>
                <select id="filtro-ubicacion" name="ubicacion">
                    <option value="">Todos</option>
                    <option value="Buenos Aires" <?php if ($ubicacion === 'Buenos Aires') echo 'selected'; ?>>Buenos Aires</option>
                    <option value="Córdoba" <?php if ($ubicacion === 'Córdoba') echo 'selected'; ?>>Córdoba</option>
                    <option value="Rosario" <?php if ($ubicacion === 'Rosario') echo 'selected'; ?>>Rosario</option>
                </select>

                <label for="filtro-modalidad">Filtrar por Modalidad:</label>
                <select id="filtro-modalidad" name="modalidad">
                    <option value="">Todos</option>
                    <option value="Presencial" <?php if ($modalidad === 'Presencial') echo 'selected'; ?>>Presencial</option>
                    <option value="Remoto" <?php if ($modalidad === 'Remoto') echo 'selected'; ?>>Remoto</option>
                </select>

                <label for="filtro-nivel-laboral">Filtrar por Nivel Laboral:</label>
                <select id="filtro-nivel-laboral" name="nivel_laboral">
                    <option value="">Todos</option>
                    <option value="Junior" <?php if ($nivel_laboral === 'Junior') echo 'selected'; ?>>Junior</option>
                    <option value="Semi-Senior" <?php if ($nivel_laboral === 'Semi-Senior') echo 'selected'; ?>>Semi-Senior</option>
                    <option value="Senior" <?php if ($nivel_laboral === 'Senior') echo 'selected'; ?>>Senior</option>
                </select>

                <label for="filtro-carga-horaria">Filtrar por Carga Horaria:</label>
                <select id="filtro-carga-horaria" name="carga_horaria">
                    <option value="">Todos</option>
                    <option value="Part-Time" <?php if ($carga_horaria === 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                    <option value="Full-Time" <?php if ($carga_horaria === 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                </select>

                <button type="submit">Aplicar</button>
                <button type="button" onclick="window.location.href='perfil_postulante.php'">Volver</button>
            </form>
        </div>

        <div class="lista-vacantes">
            <?php if (!empty($mensaje_no_resultados)): ?>
                <p class="mensaje-no-resultados"><?php echo $mensaje_no_resultados; ?></p>
            <?php else: ?>
                <?php foreach ($resultados as $vacante): ?>
                    <div class="vacante">
                        <div class="foto-perfil">
                            <img src="<?php echo htmlspecialchars($vacante['foto_perfil']); ?>" alt="Foto de perfil de la empresa">
                        </div>
                        <div class="info-vacante">
                            <h3><?php echo htmlspecialchars($vacante['titulo']); ?></h3>
                            <div class="nombre-empresa"><?php echo htmlspecialchars($vacante['nombre_empresa']); ?></div>
                            <p><?php echo htmlspecialchars($vacante['provincia']); ?></p>
                            <p><?php echo htmlspecialchars($vacante['modalidad']); ?></p>
                            <p><?php echo htmlspecialchars($vacante['nivel_laboral']); ?></p>
                            <p><?php echo htmlspecialchars($vacante['carga_horaria']); ?></p>
                            <div class="descripcion"><?php echo htmlspecialchars($vacante['descripcion']); ?></div>

                            <!-- Botón de postulación -->
                            <?php if (in_array($vacante['id'], $postulaciones)): ?>
                                <button disabled class="btn-postulado">POSTULADO</button>
                            <?php else: ?>
                                <form action="procesar_postulacion.php" method="POST">
                                    <input type="hidden" name="id_vacante" value="<?php echo htmlspecialchars($vacante['id']); ?>">
                                    <label for="tipo_cv">Selecciona el CV:</label>
                                    <select id="tipo_cv" name="tipo_cv" class="select-cv">
                                        <option value="pdf">Enviar CV en PDF</option>
                                        <option value="manual">Enviar CV Manual</option>
                                    </select>
                                    <button type="submit" class="btn-postular">Postularme</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
