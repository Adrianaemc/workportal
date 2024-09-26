<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORKPORTAL</title>
    <link rel="stylesheet" href="styles/index.css">
    
</head>
<body>
    <header>
        
        <img src="img/logo.png" alt="logo" class="logo">
        <!-- Botón "Empresa" que redirige al registro de empresas -->
        <a href="login_empresa.php" class="boton-empresa">Publicar oferta</a>
        <!-- Botón "Ingresar" para la opción "Postulantes" -->
        <a href="login_postulante.php" class="boton-ingresar">Postulate</a>
    </header>
    <main>
        <section>
        <!-- Contenedor principal -->
            <div class="container">
                <!-- Contenedor del texto y el formulario -->
                <div class="texto-formulario-container">
                    <h2>¡Encontrá el trabajo de tus sueños!</h2>
                    <!-- Formulario de búsqueda -->
                    <form action="motor_busqueda.php" method="GET">
                        <input type="text" name="busqueda" placeholder="Buscar vacantes...">
                        <br>
                        <input type="submit" value="Buscar">
                    </form>
                </div>
                <!-- Contenedor de la imagen -->
                <div class="imagen-container">
                    <img src="img/trabajadores.png" alt="Descripción de la imagen" class="imagen">
                </div>
            </div>
        </section>    
    </main>
    <footer><?php include 'templates/footer.php'; ?></footer>
</body>
</html>
