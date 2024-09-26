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

// Preparar la consulta SQL para obtener las vacantes publicadas por la empresa
require_once "bd.php"; 
$sql_vacantes = "SELECT * FROM vacantes WHERE id_empresa = ?";
$stmt_vacantes = $conexion->prepare($sql_vacantes);
$stmt_vacantes->bindParam(1, $empresa['id_empresa']); 
$stmt_vacantes->execute();
$vacantes = $stmt_vacantes->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Empresa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos adicionales personalizados */
        #perfil-empresa {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        #imagen-empresa {
            width: 150px; /* Ajustar el tamaño de la imagen según sea necesario */
            height: auto; /* Mantener la proporción de la imagen */
        }

        #datos-empresa {
            margin-left: 20px;
        }

        #nombre-empresa {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        #descripcion-empresa {
            font-size: 18px;
            margin-top: 0;
        }

        .vacante {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .btn-publicar-vacante {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-publicar-vacante:hover {
            background-color: #0056b3;
        }

        .btn-modificar, .btn-eliminar {
            margin-right: 10px;
        }

        .vacante .row {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <div class="container">
        <div id="perfil-empresa">
            <!-- Mostrar la imagen de la empresa -->
            <img src="<?php echo htmlspecialchars($ruta_imagen_empresa); ?>" alt="Foto de la empresa" id="imagen-empresa">

            <!-- Mostrar el nombre y descripción de la empresa al lado de la foto -->
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
            <h2>Vacantes Publicadas <a href="publicar_vacante.php" class="btn btn-publicar-vacante">Nueva Vacante</a></h2>
            <?php foreach ($vacantes as $vacante): ?>
                <div class="vacante">
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
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
