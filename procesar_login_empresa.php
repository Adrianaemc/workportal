<?php
require_once "C:/xampp/htdocs/sitioweb/bd.php"; 

// Mensaje de error predeterminado
$mensaje_error = "";

// Verifica si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Prepara la consulta SQL para evitar inyección de SQL
    $stmt = $conexion->prepare("SELECT * FROM empresas WHERE correo_electronico=? AND contrasena=?");
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $contrasena);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtiene el resultado de la consulta
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si se encontró un registro coincidente
    if ($result) {
        // Guardar detalles de la empresa en la sesión
        session_start();
        $_SESSION['empresa'] = $result;
        
        // Redirigir al perfil de la empresa
        header("Location: perfil_empresa.php"); 
        exit();
    } else {
        // Si las credenciales son incorrectas, mostrar mensaje de error
        $mensaje_error = "Correo electrónico o contraseña incorrectos. Intente nuevamente.";
    }
} else {
    // Si alguien intenta acceder directamente a este archivo, redirige de vuelta al formulario de inicio de sesión
    header("Location: login_empresa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Empresas </title>
    <style>
        
        body {
            background-color: white; 
            color: black; /* Texto blanco */
            position: relative; /* Agrega posición relativa para el posicionamiento absoluto del botón */
        }
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: LightSteelBlue;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"],
        a {
            display: block;
            margin: 10px 0;
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        /* Estilos para el enlace "Soy Postulante" */
        .soy-postulante {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: #3AA0DD;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            max-width: 150px; /* Ancho máximo */
            text-align: center; /* Alinear texto al centro */
        }
        /* Estilos para la imagen de marcas */
        .imagen-container {
            text-align: center;
            margin-top: 50px;
        }
        .imagen {
            max-width: 300px; /* ajusta el ancho máximo según sea necesario */
            height: auto;
        }
        /* Estilos para el mensaje de error */
        .mensaje-error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <div style="text-align: center; margin-top: 20px;">
        <h3>¡PUBLICÁ LAS BUSQUEDAS DE TU EMPRESA!</h3>
    </div>
    
    <!-- Mostrar mensaje de error si existe -->
    <?php if ($mensaje_error): ?>
        <div class="mensaje-error"><?php echo $mensaje_error; ?></div>
    <?php endif; ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2 style="text-align: center;">Iniciar Sesión - Empresas</h2>
        <label for="email">Correo Electrónico:</label>
        <input type="text" id="email" name="email" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="contrasena" required>
        <input type="submit" value="Iniciar Sesión">
    </form>

    <a href="alta_empresa.php" style="text-align: center;">¿No tienes una cuenta? Regístrate aquí.</a>
    
    <!-- Enlace "Olvidó su contraseña" -->
    <a href="recuperacion_contraseña.php" style="text-align: center;">¿Olvidó su contraseña?</a>

    <!-- Botón "Soy Postulante" -->
    <a href="login_postulante.php" class="soy-postulante">Soy Postulante</a>
    
    <div class="imagen-container">
        <img src="img/marcas.png" alt="Descripción de la imagen" class="imagen">
    </div>
</body>
</html>
