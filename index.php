<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORKPORTAL</title>
    <style>
        /* Estilos para el header */
        header {
            background-color: #EAF3FF; /* Fondo cabecera*/
            color: black; /* Texto  */
            padding: 20px; /* Espaciado interno  */
            display: flex; /* Utilizamos flexbox para alinear elementos */
            justify-content: space-between; /* Alinea los elementos al principio y al final del header */
            align-items: center; /* Alinea los elementos verticalmente */
        }
        /* Estilos para el logo */
        .logo {
            width: 200px; /* Ajusta el tamaño del logo  */
            height: auto; /* ajuste automático de la altura */
        }
        /* Estilos CSS para los botones */
        .boton-ingresar  {
            background-color: #41628F; /* Fondo  postulate*/
            color: white; /* Texto */
            padding: 12px 16px; /* Espaciado interno */
            border: none; /* Sin borde */
            cursor: pointer; /* Cursor tipo mano */
            text-decoration: none; /* Sin subrayado */
        }
        .boton-ingresar:hover, .boton-empresa:hover {
            background-color: #87CEEB; /* Cambia el color de fondo al pasar el mouse */
        }
        /* Ajusta la posición del botón "Empresa" */
        .boton-empresa {
            background-color: #2682FC; /* color del fondo */
            color: #fff ; /* color del txto */
            padding: 12px 13px; /* Espaciado interno */
            border: none; /* Sin borde */
            cursor: pointer; /* Cursor tipo mano */
            text-decoration: none; /* Sin subrayado */
            margin-left: 790px; /* Ajusta el margen izquierdo del botón */
        }
        /* Estilos para el contenedor principal */
        .container {
            display: flex; /* Utilizamos flexbox para alinear elementos */
            justify-content: space-between; /* Alinea los elementos al principio y al final del contenedor */
            align-items: center; /* Alinea los elementos verticalmente */
            margin-top: 50px; /* Espaciado superior */
        }
        /* Estilos para el contenedor de la imagen */
        .imagen-container {
            flex: 1; /* El contenedor de la imagen ocupará el 50% del espacio */
            text-align: center; /* Alinea el contenido al centro */
        }
        .imagen {
            max-width: 80%; /* Ancho máximo de la imagen */
            height: auto; /* Altura automática */
            border-radius: 10px; /* Bordes redondeados */
        }
        /* Estilos para el contenedor del texto y el formulario */
        .texto-formulario-container {
            flex: 1; /* El contenedor del texto y el formulario ocupará el 50% del espacio */
            display: flex; /* Utilizamos flexbox para alinear elementos */
            flex-direction: column; /* Los elementos se apilan verticalmente */
            justify-content: center; /* Alinea los elementos al centro verticalmente */
            align-items: center; /* Alinea los elementos al centro horizontalmente */
        }
        /* Estilos para el formulario de búsqueda */
        form {
            text-align: center; /* Alinea el contenido del formulario al centro */
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-bottom: 20px; /* Espaciado inferior */
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        /* Estilos para el texto */
        h2 {
            color: #2F4F4F; /* Color del texto */
        }
    </style>
</head>
<body style="background-color:#F0F8FF;">
    <header>
        <!-- El logo se coloca a la izquierda -->
        <img src="img/logo.png" alt="logo" class="logo">
        <!-- Botón "Empresa" que redirige al registro de empresas -->
        <a href="login_empresa.php" class="boton-empresa">Publicar oferta</a>
        <!-- Botón "Ingresar" para la opción "Postulantes" -->
        <a href="login_postulante.php" class="boton-ingresar">Postulate</a>
    </header>

    <!-- Contenedor principal -->
    <div class="container">
        <!-- Contenedor del texto y el formulario -->
        <div class="texto-formulario-container">
            
            <h2>¡Encontrá el trabajo de tus sueños!</h2>
            <!-- Formulario de búsqueda -->
            <form action="#" method="GET">
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
</body>
</html>
<?php include("templates/footer.php"); ?>
