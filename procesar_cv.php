<?php
require_once "bd.php";
session_start();

if (!isset($_SESSION['usuario']['id_usuario'])) {
    die('ID de usuario no encontrado en la sesión.');
}

$id_usuario = $_SESSION['usuario']['id_usuario'];

// Verificar la conexión a la base de datos
if (!$conexion) {
    die("La conexión a la base de datos falló.");
}

// Procesar eliminación de una entrada (educación, experiencia o idioma)
if (isset($_POST['action'])) {
    $id = $_POST['id'] ?? 0;
    $success = false;
    $error = '';

    switch ($_POST['action']) {
        case 'eliminar_educacion':
            $sql = "DELETE FROM educacion WHERE id_educacion = ?";
            break;
        case 'eliminar_experiencia':
            $sql = "DELETE FROM experiencia_laboral WHERE id_experiencia = ?";
            break;
        case 'eliminar_idioma':
            $sql = "DELETE FROM idiomas WHERE id_idioma = ?";
            break;
        default:
            die('Acción no válida.');
    }

    $stmt = $conexion->prepare($sql);
    if ($stmt->execute([$id])) {
        $success = $stmt->rowCount() > 0;
    } else {
        $error = $stmt->errorInfo();
    }

    echo json_encode(['success' => $success, 'error' => $error]);
    exit();
}

// Guardar o actualizar datos del campo "Sobre Mí"
if (isset($_POST['sobre_mi'])) {
    $sobre_mi = $_POST['sobre_mi'];
    $sql = "UPDATE usuarios SET sobre_mi = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt->execute([$sobre_mi, $id_usuario])) {
        die("Error al actualizar la sección 'Sobre Mí': " . print_r($stmt->errorInfo(), true));
    }
}

// Guardar o actualizar datos de educación
if (isset($_POST['institucion'])) {
    $instituciones = $_POST['institucion'];
    $titulos = $_POST['titulo_carrera'];
    $fechas_inicio = $_POST['fecha_inicio'];
    $fechas_fin = $_POST['fecha_fin'];
    $actualidades = $_POST['actualidad'] ?? [];
    $niveles = $_POST['nivel_estudio'];
    $ids = $_POST['id_edu'];

    foreach ($instituciones as $index => $institucion) {
        $titulo = $titulos[$index];
        $fecha_inicio = $fechas_inicio[$index];
        $fecha_fin = $fechas_fin[$index];
        $actualidad = in_array($index, $actualidades) ? 1 : 0;
        $nivel = $niveles[$index];
        $id = intval($ids[$index]);

        if ($id == 0) {
            $sql = "INSERT INTO educacion (id_usuario, institucion, titulo_carrera, fecha_inicio, fecha_fin, actualidad, nivel_estudio) VALUES (?, ?, ?, ?, ?, ?, ?)";
        } else {
            $sql = "UPDATE educacion SET institucion = ?, titulo_carrera = ?, fecha_inicio = ?, fecha_fin = ?, actualidad = ?, nivel_estudio = ? WHERE id_educacion = ? AND id_usuario = ?";
        }

        $stmt = $conexion->prepare($sql);
        $params = $id == 0 ? [$id_usuario, $institucion, $titulo, $fecha_inicio, $fecha_fin, $actualidad, $nivel] : [$institucion, $titulo, $fecha_inicio, $fecha_fin, $actualidad, $nivel, $id, $id_usuario];
        if (!$stmt->execute($params)) {
            die("Error al guardar la educación: " . print_r($stmt->errorInfo(), true));
        }
    }
}

// Guardar o actualizar datos de experiencia laboral
if (isset($_POST['puesto'])) {
    $puestos = $_POST['puesto'];
    $empresas = $_POST['empresa'];
    $fechas_inicio = $_POST['fecha_inicio'];
    $fechas_fin = $_POST['fecha_fin'];
    $actualidades = $_POST['actualidad'] ?? [];
    $tareas = $_POST['tareas'];
    $ids = $_POST['id_exp'];

    foreach ($puestos as $index => $puesto) {
        $empresa = $empresas[$index];
        $fecha_inicio = $fechas_inicio[$index];
        $fecha_fin = $fechas_fin[$index];
        $actualidad = in_array($index, $actualidades) ? 1 : 0;
        $tarea = $tareas[$index];
        $id = intval($ids[$index]);

        if ($id == 0) {
            $sql = "INSERT INTO experiencia_laboral (id_usuario, puesto, empresa, fecha_inicio, fecha_fin, actualidad, tareas) VALUES (?, ?, ?, ?, ?, ?, ?)";
        } else {
            $sql = "UPDATE experiencia_laboral SET puesto = ?, empresa = ?, fecha_inicio = ?, fecha_fin = ?, actualidad = ?, tareas = ? WHERE id_experiencia = ? AND id_usuario = ?";
        }

        $stmt = $conexion->prepare($sql);
        $params = $id == 0 ? [$id_usuario, $puesto, $empresa, $fecha_inicio, $fecha_fin, $actualidad, $tarea] : [$puesto, $empresa, $fecha_inicio, $fecha_fin, $actualidad, $tarea, $id, $id_usuario];
        if (!$stmt->execute($params)) {
            die("Error al guardar la experiencia laboral: " . print_r($stmt->errorInfo(), true));
        }
    }
}

// Guardar o actualizar datos de idiomas
if (isset($_POST['idioma'])) {
    $idiomas = $_POST['idioma'];
    $niveles_competencia = $_POST['nivel_competencia'];
    $niveles_habilidad = $_POST['nivel_habilidad'];
    $ids = $_POST['id_idioma'];

    foreach ($idiomas as $index => $idioma) {
        $nivel_competencia = $niveles_competencia[$index];
        $nivel_habilidad = $niveles_habilidad[$index];
        $id = intval($ids[$index]);

        if ($id == 0) {
            $sql = "INSERT INTO idiomas (id_usuario, idioma, nivel_competencia, nivel_habilidad) VALUES (?, ?, ?, ?)";
        } else {
            $sql = "UPDATE idiomas SET idioma = ?, nivel_competencia = ?, nivel_habilidad = ? WHERE id_idioma = ? AND id_usuario = ?";
        }

        $stmt = $conexion->prepare($sql);
        $params = $id == 0 ? [$id_usuario, $idioma, $nivel_competencia, $nivel_habilidad] : [$idioma, $nivel_competencia, $nivel_habilidad, $id, $id_usuario];
        if (!$stmt->execute($params)) {
            die("Error al guardar el idioma: " . print_r($stmt->errorInfo(), true));
        }
    }
}

// Comprobar si se ha subido un nuevo archivo de CV
if (!empty($_FILES['cv_pdf']['name'])) {
    $cv_pdf = $_FILES['cv_pdf'];
    $cv_pdf_nombre = $cv_pdf['name'];
    $cv_pdf_temp = $cv_pdf['tmp_name'];
    $cv_pdf_destino = 'uploads/' . $cv_pdf_nombre;

    // Mover el archivo CV a la carpeta de destino
    if (move_uploaded_file($cv_pdf_temp, $cv_pdf_destino)) {
        // Actualizar la ruta del CV en la base de datos si se ha subido uno nuevo
        $sql = "UPDATE usuarios SET cv_pdf = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$cv_pdf_destino, $id_usuario]);
    } else {
        die("Error al mover el archivo CV.");
    }
} else {
    // No se ha subido un nuevo archivo, mantener el CV actual
    // Aquí no se realiza ningún cambio en la base de datos respecto al CV
}

// Comprobar si se ha subido una nueva foto de perfil
if (!empty($_FILES['foto_perfil']['name'])) {
    $foto_perfil = $_FILES['foto_perfil'];
    $foto_nombre = $foto_perfil['name'];
    $foto_temp = $foto_perfil['tmp_name'];
    $foto_destino = 'uploads/' . $foto_nombre;

    // Mover la imagen a la carpeta de destino
    if (move_uploaded_file($foto_temp, $foto_destino)) {
        // Actualizar la ruta de la foto en la base de datos
        $sql = "UPDATE usuarios SET foto_perfil = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$foto_destino, $id_usuario]);

        // Actualizar la sesión con la nueva ruta de la foto de perfil
        $_SESSION['usuario']['foto_perfil'] = $foto_destino;
    } else {
        die("Error al mover la imagen.");
    }
}
// Redirigir al perfil del postulante o a otra página según sea necesario
header("Location: perfil_postulante.php");
exit();
?>