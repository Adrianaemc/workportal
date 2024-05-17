<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Empresas</title>
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
            position: relative;
            z-index: 1; 
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
        /* Estilos para la imagen postulante */
        .imagen {
            position: relative;
            z-index: 0; /* Colocar la imagen por debajo del formulario */
            max-width: 275px; /* Ancho máximo de la imagen */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-left: 30px; /* Ajustar el margen izquierdo para mover hacia la derecha */
        }
        /* Estilos para el botón "Soy una empresa" */
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
            z-index: 1; /* Asegurar que esté por encima del formulario */
        }
        .btn-soy-empresa:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="main-container">
        <div class="form-container">
            <form action="procesar_login_postulante.php" method="POST">
                <h2 style="text-align: center; margin-bottom: 20px;">Iniciar Sesión - POSTULANTE</h2>
                <label for="email">Correo Electrónico:</label>
                <input type="text" id="email" name="email" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="contrasena" required>
                <input type="submit" value="Iniciar Sesión">
                <a href="#" style="margin-top: 10px;">¿Olvidaste tu contraseña?</a>
                <a href="alta_postulante.php">¿No tienes una cuenta? Regístrate aquí.</a>
            </form>
        </div>
        <img src="img/postulate.png" alt="Descripción de la imagen" class="imagen">
    </div>
    <a href="login_empresa.php" class="btn-soy-empresa">Soy una empresa</a>
</body>
</html>
