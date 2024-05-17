<?php
// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'C:/xampp/htdocs/sitioweb/bd.php'; // Asegúrate de reemplazar 'ruta_a_tu_archivo' con la ubicación real de tu archivo bd.php
    
    // Obtener los datos del formulario
    $nombre_empresa = $_POST["nombre_empresa"];
    $cuit = $_POST["cuit"];
    $contrasena = $_POST["contrasena"];
    $repetir_contrasena = $_POST["repetir_contrasena"];
    $correo_electronico = $_POST["correo_electronico"];
    $domicilio = $_POST["domicilio"];
    $pais = $_POST["pais"];
    $telefono = $_POST["telefono"];

    // Verifica si las contraseñas coinciden
    if ($contrasena !== $repetir_contrasena) {
        $mensaje_error = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Inserción en la base de datos
        $query = "INSERT INTO empresas (nombre_empresa, cuit, contrasena, correo_electronico, domicilio, pais, telefono) VALUES (:nombre_empresa, :cuit, :contrasena, :correo, :domicilio, :pais, :telefono)";
        $statement = $conexion->prepare($query);
        $statement->bindParam(':nombre_empresa', $nombre_empresa);
        $statement->bindParam(':cuit', $cuit);
        $statement->bindParam(':contrasena', $contrasena);
        $statement->bindParam(':correo', $correo_electronico);
        $statement->bindParam(':domicilio', $domicilio);
        $statement->bindParam(':pais', $pais);
        $statement->bindParam(':telefono', $telefono);
        
        if ($statement->execute()) {
            // Registro exitoso
            $registro_exitoso = true;
        } else {
            $mensaje_error = "Error al registrar la empresa. Por favor, inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        
        }
        /* Estilos para el botón */
        .btn-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #3AA0DD;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <!-- Botón en la esquina superior derecha -->
    <div class="btn-container">
        <a href="login_postulante.php" class="btn">Soy postulante</a>
    </div>

    <div class="container">
        <h2>Registra tu empresa y publicá tus ofertas laborales gratis</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nombre_empresa">Nombre de la Empresa:</label>
            <input type="text" id="nombre_empresa" name="nombre_empresa" required><br>

            <label for="cuit">CUIT:</label>
            <input type="text" id="cuit" name="cuit" required><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required><br>

            <label for="repetir_contrasena">Repetir Contraseña:</label>
            <input type="password" id="repetir_contrasena" name="repetir_contrasena" required><br>

            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" id="correo_electronico" name="correo_electronico" required><br>

            <label for="domicilio">Domicilio:</label>
            <input type="text" id="domicilio" name="domicilio" required><br>

            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais" required><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required><br>

            <input type="submit" value="Registrarse">
        </form>

        <?php if (isset($mensaje_error)): ?>
            <div class="error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>

        <?php if (isset($registro_exitoso) && $registro_exitoso): ?>
            <div class="success">Registro exitoso. Redirigiendo al inicio de sesión...</div>
            <meta http-equiv="refresh" content="5;url=login_empresa.php">
        <?php endif; ?>
    </div>
</body>
</html>
