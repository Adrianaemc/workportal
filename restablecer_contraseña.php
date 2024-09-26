<?php
require_once "bd.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $token = $_GET["token"];

    // Primero, busca el token en la tabla de usuarios
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE token = ?");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra en la tabla de usuarios, busca en la tabla de empresas
    if (!$usuario) {
        $stmt = $conexion->prepare("SELECT * FROM empresas WHERE token = ?");
        $stmt->execute([$token]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mostrar el formulario de restablecimiento de contraseña si se encuentra el token
    if ($usuario || $empresa) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Restablecer Contraseña</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    height: 100vh;
                    justify-content: center;
                }
                header {
                    width: 100%;
                    background-color: #fff;
                    padding: 10px 0;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    margin-bottom: 20px;
                }
                header img {
                    max-height: 50px;
                }
                .container {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    width: 300px;
                }
                h2 {
                    margin-bottom: 20px;
                    text-align: center;
                }
                label {
                    display: block;
                    margin-bottom: 5px;
                }
                input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
                button {
                    width: 100%;
                    padding: 10px;
                    background-color: #1c75bc;
                    color: #fff;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
                button:hover {
                    background-color: #155e93;
                }
            </style>
        </head>
        <body>
        <?php include 'templates/header.php'; ?>
            <div class="container">
                <h2>Restablecer Contraseña</h2>
                <form action="procesar_restablecer.php" method="post">
                    <label for="contrasena">Nueva Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                    <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                    <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button type="submit">Restablecer Contraseña</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Enlace de recuperación inválido o expirado.";
    }
}
?>
