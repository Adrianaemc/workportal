<?php
require_once "bd.php";
session_start();

// Verificar si la empresa está autenticada
if (!isset($_SESSION['empresa'])) {
    header("Location: login_empresa.php");
    exit();
}

// Obtener la ID de la vacante desde la URL
$id_vacante = isset($_GET['id_vacante']) ? (int)$_GET['id_vacante'] : 0;

// Obtener el estado de postulaciones (todos, seleccionados o rechazados)
$estado = isset($_GET['estado']) ? $_GET['estado'] : 'todos';

// Establecer el orden por defecto como DESC (más reciente)
$orden = isset($_GET['orden']) && $_GET['orden'] === 'ant' ? 'ASC' : 'DESC';

// Consultar la información de la vacante
$sql_vacante = "SELECT * FROM vacantes WHERE id = :id_vacante";
$stmt_vacante = $conexion->prepare($sql_vacante);
$stmt_vacante->execute([':id_vacante' => $id_vacante]);
$vacante = $stmt_vacante->fetch(PDO::FETCH_ASSOC);

// Consultar los postulantes de la vacante según el estado
$sql_postulantes = "SELECT p.*, u.cv_pdf, u.foto_perfil, u.nombre, u.apellido
                    FROM postulaciones p
                    INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                    WHERE p.id_vacante = :id_vacante";

if ($estado === 'todos') {
    // Mostrar postulantes con estado 'enviado' y 'visto'
    $sql_postulantes .= " AND (p.estado = 'enviado' OR p.estado = 'visto')";
} elseif ($estado === 'seleccionados') {
    $sql_postulantes .= " AND p.estado = 'seleccionado'";
} elseif ($estado === 'rechazados') {
    $sql_postulantes .= " AND p.estado = 'rechazado'";
}

// Agregar la ordenación por fecha de postulación
$sql_postulantes .= " ORDER BY p.fecha_postulacion $orden";

$stmt_postulantes = $conexion->prepare($sql_postulantes);
$stmt_postulantes->execute([':id_vacante' => $id_vacante]);
$postulantes = $stmt_postulantes->fetchAll(PDO::FETCH_ASSOC);
// Consultar el número de postulantes por estado
$sql_count_todos = "SELECT COUNT(*) as total FROM postulaciones WHERE id_vacante = :id_vacante AND (estado = 'enviado' OR estado = 'visto')";
$stmt_count_todos = $conexion->prepare($sql_count_todos);
$stmt_count_todos->execute([':id_vacante' => $id_vacante]);
$count_todos = $stmt_count_todos->fetch(PDO::FETCH_ASSOC)['total'];

$sql_count_seleccionados = "SELECT COUNT(*) as total FROM postulaciones WHERE id_vacante = :id_vacante AND estado = 'seleccionado'";
$stmt_count_seleccionados = $conexion->prepare($sql_count_seleccionados);
$stmt_count_seleccionados->execute([':id_vacante' => $id_vacante]);
$count_seleccionados = $stmt_count_seleccionados->fetch(PDO::FETCH_ASSOC)['total'];

$sql_count_rechazados = "SELECT COUNT(*) as total FROM postulaciones WHERE id_vacante = :id_vacante AND estado = 'rechazado'";
$stmt_count_rechazados = $conexion->prepare($sql_count_rechazados);
$stmt_count_rechazados->execute([':id_vacante' => $id_vacante]);
$count_rechazados = $stmt_count_rechazados->fetch(PDO::FETCH_ASSOC)['total'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postulantes para Vacante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/ver_postulantes.css">
</head>
<body>
<header>
    <?php include 'templates/header.php'; ?>
    <nav>
        <a href="perfil_empresa.php">VOLVER A MI PERFIL</a>
        <a href="modificar_datos_empresa">Modificar mis datos</a>
        <a href="cerrar_sesion_empresa.php">Cerrar Sesión</a>
    </nav>
</header>

<div class="container mt-4">
    <h2 class="text-center mb-4">POSTULANTES PARA: <?php echo htmlspecialchars($vacante['titulo']); ?></h2>

    
    <!-- Navegación de pestañas -->
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $estado === 'todos' ? 'active' : ''; ?>" id="todos-tab" href="?id_vacante=<?php echo $id_vacante; ?>&estado=todos&orden=<?php echo $orden; ?>" role="tab" aria-controls="todos" aria-selected="<?php echo $estado === 'todos' ? 'true' : 'false'; ?>">
                Todos (<?php echo $count_todos; ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $estado === 'seleccionados' ? 'active' : ''; ?>" id="seleccionados-tab" href="?id_vacante=<?php echo $id_vacante; ?>&estado=seleccionados&orden=<?php echo $orden; ?>" role="tab" aria-controls="seleccionados" aria-selected="<?php echo $estado === 'seleccionados' ? 'true' : 'false'; ?>">
                Seleccionados (<?php echo $count_seleccionados; ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php echo $estado === 'rechazados' ? 'active' : ''; ?>" id="rechazados-tab" href="?id_vacante=<?php echo $id_vacante; ?>&estado=rechazados&orden=<?php echo $orden; ?>" role="tab" aria-controls="rechazados" aria-selected="<?php echo $estado === 'rechazados' ? 'true' : 'false'; ?>">
                Rechazados (<?php echo $count_rechazados; ?>)
            </a>
        </li>
    </ul>


    <?php if (empty($postulantes)): ?>
        <div class="alert alert-warning text-center" role="alert">No hay postulantes para esta vacante.</div>
    <?php else: ?>
        <div class="mb-3">
            <label for="orden" class="form-label">Ordenar por:</label>
            <select id="orden" class="form-select" onchange="location = this.value;">
                <option value="?id_vacante=<?php echo $id_vacante; ?>&estado=<?php echo $estado; ?>">Fecha de Postulación (Más Reciente)</option>
                <option value="?id_vacante=<?php echo $id_vacante; ?>&estado=<?php echo $estado; ?>&orden=ant" <?php echo $orden === 'ASC' ? 'selected' : ''; ?>>Fecha de Postulación (Más Antiguo)</option>
            </select>
        </div>
        <div class="row">
            <?php foreach ($postulantes as $postulante): ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-secondary shadow-sm">
                        <img src="<?php echo htmlspecialchars($postulante['foto_perfil'] ?? 'img/sinfoto.png'); ?>" class="card-img-top" alt="Foto de Perfil" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($postulante['nombre'])," ", ($postulante['apellido']); ?></h5>
                            <p class="card-text">
                                <strong>Tipo de CV:</strong> <?php echo htmlspecialchars($postulante['tipo_cv']); ?><br>
                                <strong>Fecha de Postulación:</strong> <?php echo htmlspecialchars($postulante['fecha_postulacion']); ?><br>
                                <strong>Estado:</strong> <?php echo htmlspecialchars($postulante['estado']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <?php if ($postulante['tipo_cv'] == 'pdf'): ?>
                            <a href="actualizar_estado.php?id_postulacion=<?php echo htmlspecialchars($postulante['id_postulacion']); ?>&tipo_cv=pdf" class="btn btn-primary" download>Descargar CV</a>
                        <?php else: ?>
                            <a href="actualizar_estado.php?id_postulacion=<?php echo htmlspecialchars($postulante['id_postulacion']); ?>&tipo_cv=manual" class="btn btn-info">Ver CV Manual</a>
                        <?php endif; ?>
                        <?php if ($postulante['estado'] === 'enviado' || $postulante['estado'] === 'visto'): // Mostrar botones para 'enviado' y 'visto' ?>
                            <form action="seleccionar_candidato.php?id_vacante=<?php echo htmlspecialchars($id_vacante); ?>" method="post" class="d-inline">
                                <input type="hidden" name="id_postulacion" value="<?php echo htmlspecialchars($postulante['id_postulacion']); ?>">
                                <button type="submit" class="btn btn-success">Seleccionar Candidato</button>
                            </form>
                            <form action="rechazar_candidato.php?id_vacante=<?php echo htmlspecialchars($id_vacante); ?>" method="post" class="d-inline">
                                <input type="hidden" name="id_postulacion" value="<?php echo htmlspecialchars($postulante['id_postulacion']); ?>">
                                <button type="submit" class="btn btn-danger">Rechazar Candidato</button>
                            </form>
                        <?php elseif ($postulante['estado'] === 'rechazado'): ?>
                            <span class="text-danger">Rechazado</span> <!-- Muestra 'Rechazado' si el estado es 'rechazado' -->
                        <?php else: ?>
                            <span class="text-success">Candidato Seleccionado</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-3f2aMA6vDDzjVY0d23+kTc+zDgM6fT6j4FYfK8iIqT8OMDg+2/6XyBhu6IHf7F+g" crossorigin="anonymous"></script>
<footer><?php include 'templates/footer.php'; ?></footer>
</body>
</html>
