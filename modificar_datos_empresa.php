<?php
// Incluir el archivo de conexión a la base de datos
require_once "bd.php";

// Iniciar sesión si aún no está iniciada
session_start();

// Supongamos que el ID de la empresa está almacenado en $_SESSION['empresa']['id_empresa']
$id_empresa = $_SESSION['empresa']['id_empresa'];

// Recuperar los datos de la empresa de la base de datos
$sql = "SELECT nombre_empresa, cuit, telefono, descripcion, foto_perfil FROM empresas WHERE id_empresa = :id";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $id_empresa);
$stmt->execute();

// Obtener los datos de la empresa
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        textarea {
            resize: vertical;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modificar Perfil de la Empresa</h1>
        <form action="procesar_mod_datos_empresa.php" method="POST" enctype="multipart/form-data">
            <label for="nombre_empresa">Nombre de la Empresa:</label>
            <input type="text" id="nombre_empresa" name="nombre_empresa" value="<?php echo htmlspecialchars($empresa['nombre_empresa']); ?>">

            <label for="cuit_empresa">CUIT:</label>
            <input type="text" id="cuit_empresa" name="cuit_empresa" value="<?php echo htmlspecialchars($empresa['cuit']); ?>" readonly>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($empresa['telefono']); ?>">

            <label for="descripcion">Descripción de la Empresa:</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($empresa['descripcion']); ?></textarea>

            <label for="foto_perfil">Foto de Perfil:</label>
            <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">

            <input type="submit" value="Guardar Cambios">
        </form>
       
    </div>
    
</body>

</html>
