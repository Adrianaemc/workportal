<?php
require_once "C:/xampp/htdocs/sitioweb/bd.php"; 

// Mensaje de error predeterminado
$mensaje_error = "";

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Preparar la consulta SQL para evitar inyección de SQL
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo_electronico=? AND contrasena=?");
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $contrasena);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró un registro coincidente
    if ($result) {
        // Iniciar sesión y guardar detalles del usuario en la sesión
        session_start();
        $_SESSION['usuario'] = $result;
        
        // Redirigir al perfil del usuario
        header("Location: perfil_postulante.php");
        exit(); // Asegurar que el script se detenga después de la redirección
    } else {
        // Si las credenciales son incorrectas, mostrar mensaje de error
        $mensaje_error = "Correo electrónico o contraseña incorrectos. Intente nuevamente.";
    }
}

// Si alguien intenta acceder directamente a este archivo o si hay un error de inicio de sesión,
// mostrar el formulario de inicio de sesión junto con el mensaje de error
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Postulantes</title>
    <style>
        /* Estilos para el formulario */
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ajustar la altura al 100% del viewport */
        }
        .form-container {
            padding: 20px;
            border-radius: 8px;
            background-color: #B1D3FF;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-right: -20px; /* Ajustar el margen derecho para mover hacia la izquierda */
        }
        form {
            width: 350px; /* Ancho del formulario */
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #1c75bc;
            color: #fff;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #155e93;
        }
        .imagen {
            max-width: 275px; /* Ancho máximo de la imagen */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-left: 30px; /* Ajustar el margen izquierdo para mover hacia la derecha */
        }
        .btn-soy-empresa {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: #3AA0DD;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-soy-empresa:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="form-container">
            <?php if (!empty($mensaje_error)) : ?>
                <div class="error-message"><?php echo htmlspecialchars($mensaje_error); ?></div>
            <?php endif; ?>
            <form action="procesar_login_postulante.php" method="POST">
                <h2 style="text-align: center; margin-bottom: 20px;">Iniciar Sesión - POSTULANTE</h2>
                <label for="email">Correo Electrónico:</label>
                <input type="text" id="email" name="email" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="contrasena" required>
                <input type="submit" value="Iniciar Sesión">
                <a href="recuperacion_contraseña.php" style="margin-top: 10px;">¿Olvidaste tu contraseña?</a>
                <a href="alta_postulante.php">¿No tienes una cuenta? Regístrate aquí.</a>
            </form>
        </div>
        <img src="img/postulate.png" alt="Descripción de la imagen" class="imagen">
    </div>
    <a href="login_empresa.php" class="btn-soy-empresa">Soy una empresa</a>
</body>
</html>
