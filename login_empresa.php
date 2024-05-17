<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Empresas </title>
    <style>
        /* Estilos para el formulario */
        body {
            background-color: white; /* Fondo azul */
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
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <div style="text-align: center; margin-top: 20px;">
        <h3>¡PUBLICÁ LAS BUSQUEDAS DE TU EMPRESA!</h3>
    </div>
    <form action="procesar_login_Empresa.php" method="POST">
        <h2 style="text-align: center;">Iniciar Sesión - Empresas</h2>
        <label for="email">Correo Electrónico:</label>
        <input type="text" id="email" name="email" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="contrasena" required>
        <input type="submit" value="Iniciar Sesión">
    </form>

    <a href="alta_empresa.php" style="text-align: center;">¿No tienes una cuenta? Regístrate aquí.</a>
    
    <!-- Enlace "Olvidó su contraseña" -->
    <a href="recu_contraseña.php" style="text-align: center;">¿Olvidó su contraseña?</a>

    <!-- Botón "Soy Postulante" -->
    <a href="login_postulante.php" class="soy-postulante">Soy Postulante</a>
    
    <div class="imagen-container">
        <img src="img/marcas.png" alt="Descripción de la imagen" class="imagen">
    </div>
</body>
</html>
