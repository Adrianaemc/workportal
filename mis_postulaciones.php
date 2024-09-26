<?php
require_once "bd.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']['id_usuario'])) {
    die('Acceso no autorizado.');
}

$id_usuario = $_SESSION['usuario']['id_usuario'];

// Consulta para obtener las postulaciones del usuario
$sql = "SELECT p.*, v.titulo, e.nombre_empresa
        FROM postulaciones p
        INNER JOIN vacantes v ON p.id_vacante = v.id
        INNER JOIN empresas e ON v.id_empresa = e.id_empresa
        WHERE p.id_usuario = :id_usuario";
$stmt = $conexion->prepare($sql);
$stmt->execute([':id_usuario' => $id_usuario]);
$postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Postulaciones</title>
    <link rel="stylesheet" href="styles/mis_postulaciones.css">
</head>
<body>
    <header><?php include 'templates/header.php'; ?></header>

    <main>

        <nav>
        <a href="perfil_postulante.php">Volver a mi perfil</a>
            <a href="cv_postulantes.php">Mi CV</a>
            <a href="#">Mis Postulaciones</a>
            <a href="#">Configuración</a>
            <a href="cerrar_sesion_postulante.php">Cerrar Sesión</a>
            <a href="#"><i class="fas fa-bell"></i></a>
            
            <section>
                <div class="container-postulaciones">
                    <h2>Mis Postulaciones</h2>
                    <?php if (empty($postulaciones)): ?>
                        <p>No tienes postulaciones.</p>
                    <?php else: ?>
                        <ul>
                            <?php foreach ($postulaciones as $postulacion): ?>
                                <li>
                                    <strong><?php echo htmlspecialchars($postulacion['titulo']); ?></strong><br>
                                    Empresa: <?php echo htmlspecialchars($postulacion['nombre_empresa']); ?><br>
                                    Fecha de postulación: <?php echo htmlspecialchars($postulacion['fecha_postulacion']); ?><br>
                                    Estado de mi CV: <?php echo htmlspecialchars($postulacion['estado']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>
    </main>
    <footer><?php include 'templates/footer.php'; ?></footer>
</body>
</html>
