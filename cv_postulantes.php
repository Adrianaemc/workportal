<?php
require_once "bd.php";
session_start();

if (!isset($_SESSION['usuario']['id_usuario'])) {
    die('ID de usuario no encontrado en la sesión.');
}

$id_usuario = $_SESSION['usuario']['id_usuario'];
$ruta_imagen_usuario = isset($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'img/sinfoto.png';
// Inicializar arrays para los datos de educación, experiencia e idiomas
$educacion = [];
$experiencia = [];
$idiomas = [];
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

    // Obtener los idiomas del usuario
    $sql = "SELECT * FROM idiomas WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_usuario]);
    $idiomas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Procesar eliminación de una entrada de educación
    if (isset($_POST['action']) && $_POST['action'] === 'eliminar_educacion') {
        $id = $_POST['id'];
        $sql = "DELETE FROM educacion WHERE id_educacion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        echo json_encode(['success' => $stmt->rowCount() > 0]);
        exit();
    }

    // Procesar eliminación de una entrada de experiencia
    if (isset($_POST['action']) && $_POST['action'] === 'eliminar_experiencia') {
        $id = $_POST['id'];
        $sql = "DELETE FROM experiencia_laboral WHERE id_experiencia = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        echo json_encode(['success' => $stmt->rowCount() > 0]);
        exit();
    }

    // Procesar eliminación de una entrada de idioma
    if (isset($_POST['action']) && $_POST['action'] === 'eliminar_idioma') {
        $id = $_POST['id'];
        $sql = "DELETE FROM idiomas WHERE id_idioma = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        echo json_encode(['success' => $stmt->rowCount() > 0]);
        exit();
    }
} else {
    die("La conexión a la base de datos falló.");
}
?>
<script src="javascript/script_cargar_cv.js"></script>

        
</head>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de CV</title>
    <link rel="stylesheet" href="styles/styles_cargar_cv.css">
    
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <h1>Carga tu CV </h1>
        <div class="container">
            <form action="procesar_cv.php" method="POST" enctype="multipart/form-data">
            
                <div class="form-section">
                    <h2>Sobre Mí</h2>
                    <textarea name="sobre_mi" rows="4" required><?php echo htmlspecialchars($sobre_mi); ?></textarea>
                </div>

                <div class="form-section">
                    <h2>Educación</h2>
                    <div id="educacion-container">
                        <?php foreach ($educacion as $edu): ?>
                            <div class="educacion-item">
                                <hr>
                                <input type="hidden" name="id_edu[]" value="<?php echo htmlspecialchars($edu['id_educacion']); ?>">
                                <label>Institución:</label>
                                <input type="text" name="institucion[]" value="<?php echo htmlspecialchars($edu['institucion']); ?>" required>
                                
                                <label>Título Carrera:</label>
                                <input type="text" name="titulo_carrera[]" value="<?php echo htmlspecialchars($edu['titulo_carrera']); ?>" required>
                                
                                <label>Fecha de Inicio:</label>
                                <input type="date" name="fecha_inicio[]" value="<?php echo htmlspecialchars($edu['fecha_inicio']); ?>" required>
                                
                                <label>Fecha de Fin:</label>
                                <input type="date" name="fecha_fin[]" value="<?php echo htmlspecialchars($edu['fecha_fin']); ?>">
                                
                                <label>Actualidad:</label>
                                <input type="checkbox" name="actualidad[]" <?php echo $edu['actualidad'] ? 'checked' : ''; ?>>
                                
                                <label>Nivel de Estudio:</label>
                                <select name="nivel_estudio[]" required>
                                    <option value="primaria completa" <?php echo $edu['nivel_estudio'] === 'primaria completa' ? 'selected' : ''; ?>>Primaria Completa</option>
                                    <option value="primaria incompleta" <?php echo $edu['nivel_estudio'] === 'primaria incompleta' ? 'selected' : ''; ?>>Primaria Incompleta</option>
                                    <option value="secundario completo" <?php echo $edu['nivel_estudio'] === 'secundario completo' ? 'selected' : ''; ?>>Secundario Completo</option>
                                    <option value="secundario incompleto" <?php echo $edu['nivel_estudio'] === 'secundario incompleto' ? 'selected' : ''; ?>>Secundario Incompleto</option>
                                    <option value="terciario completo" <?php echo $edu['nivel_estudio'] === 'terciario completo' ? 'selected' : ''; ?>>Terciario Completo</option>
                                    <option value="terciario incompleto" <?php echo $edu['nivel_estudio'] === 'terciario incompleto' ? 'selected' : ''; ?>>Terciario Incompleto</option>
                                    <option value="universitario completo" <?php echo $edu['nivel_estudio'] === 'universitario completo' ? 'selected' : ''; ?>>Universitario Completo</option>
                                    <option value="universitario incompleto" <?php echo $edu['nivel_estudio'] === 'universitario incompleto' ? 'selected' : ''; ?>>Universitario Incompleto</option>
                                </select>
                                <button type="button" class="delete-button" onclick="eliminarEducacion(this)">Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="agregarEducacion()">Agregar Educación</button>
                </div>

                <div class="form-section">
                    <h2>Experiencia Laboral</h2>
                    <div id="experiencia-container">
                        <?php foreach ($experiencia as $exp): ?>
                            <div class="experiencia-item">
                                <hr>
                                <input type="hidden" name="id_exp[]" value="<?php echo htmlspecialchars($exp['id_experiencia']); ?>">
                                <label>Puesto:</label>
                                <input type="text" name="puesto[]" value="<?php echo htmlspecialchars($exp['puesto']); ?>" required>
                                
                                <label>Empresa:</label>
                                <input type="text" name="empresa[]" value="<?php echo htmlspecialchars($exp['empresa']); ?>" required>
                                
                                <label>Fecha de Ingreso:</label>
                                <input type="date" name="fecha_inicio[]" value="<?php echo htmlspecialchars($exp['fecha_inicio']); ?>" required>
                                
                                <label>Fecha de Egreso:</label>
                                <input type="date" name="fecha_fin[]" value="<?php echo htmlspecialchars($exp['fecha_fin']); ?>">
                                
                                <label>Actualmente:</label>
                                <input type="checkbox" name="actualidad[]" <?php echo $exp['actualidad'] ? 'checked' : ''; ?>>
                                
                                <label>Principales Tareas:</label>
                                <textarea name="tareas[]" rows="4" required><?php echo htmlspecialchars($exp['tareas']); ?></textarea>
                                
                                <button type="button" class="delete-button" onclick="eliminarExperiencia(this)">Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="agregarExperiencia()">Agregar Experiencia</button>
                </div>

                <div class="form-section">
                    <h2>Idiomas</h2>
                    <div id="idioma-container">
                        <?php foreach ($idiomas as $idioma): ?>
                            <div class="idioma-item">
                                <hr>
                                <input type="hidden" name="id_idioma[]" value="<?php echo htmlspecialchars($idioma['id_idioma']); ?>">
                                <label>Idioma:</label>
                                <input type="text" name="idioma[]" value="<?php echo htmlspecialchars($idioma['idioma']); ?>" required>
                                
                                <label>Nivel de Competencia:</label>
                                <select name="nivel_competencia[]" required>
                                    <option value="oral" <?php echo $idioma['nivel_competencia'] === 'oral' ? 'selected' : ''; ?>>Oral</option>
                                    <option value="escrito" <?php echo $idioma['nivel_competencia'] === 'escrito' ? 'selected' : ''; ?>>Escrito</option>
                                    <option value="nativo" <?php echo $idioma['nivel_competencia'] === 'nativo' ? 'selected' : ''; ?>>Nativo</option>
                                </select>
                                
                                <label>Nivel de Habilidad:</label>
                                <select name="nivel_habilidad[]" required>
                                    <option value="basico" <?php echo $idioma['nivel_habilidad'] === 'basico' ? 'selected' : ''; ?>>Básico</option>
                                    <option value="intermedio" <?php echo $idioma['nivel_habilidad'] === 'intermedio' ? 'selected' : ''; ?>>Intermedio</option>
                                    <option value="experto" <?php echo $idioma['nivel_habilidad'] === 'experto' ? 'selected' : ''; ?>>Experto</option>
                                </select>
                                <button type="button" class="delete-button" onclick="eliminarIdioma(this)">Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" onclick="agregarIdioma()">Agregar Idioma</button>
                
                    <h2>Foto de Perfil</h2>

                    <label for="foto_perfil">Foto de Perfil:</label>
                    <input type="file" id="foto_perfil" name="foto_perfil">
                    <h2>CV en PDF</h2>
                
                    <input type="file" id="cv_pdf" name="cv_pdf" accept="application/pdf" >             
                <div class="form-section">
                    
        
    </div>


                
                <div class="form-section">
                    <button type="submit">Guardar</button>
                    <button type="button" class=btn-secondary onclick="window.location.href='perfil_postulante.php'">Volver</button>
                </div>
                
            </form>
        </div>
    </main>
    <footer><?php include 'templates/footer.php'; ?></footer>

</body>

</html>
