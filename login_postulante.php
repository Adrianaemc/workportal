<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Empresas</title>
    <link rel="stylesheet" href="styles/style_login_postulantes.css">
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
                <a href="recuperacion_contraseña.php" style="margin-top: 10px;">¿Olvidaste tu contraseña?</a>
                <a href="alta_postulante.php">¿No tienes una cuenta? Regístrate aquí.</a>
            </form>
        </div>
        <img src="img/postulate.png" alt="Descripción de la imagen" class="imagen">
    </div>
    <a href="login_empresa.php" class="btn-soy-empresa">Soy una empresa</a>
    <?php include 'templates/footer.php'; ?>
</body>

</html>
