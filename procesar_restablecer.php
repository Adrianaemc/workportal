<?php
require_once "bd.php";

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $token = $_POST['token'];

    if ($contrasena === $confirmar_contrasena) {
        // Intentar actualizar en la tabla de usuarios primero
        $stmt = $conexion->prepare("UPDATE usuarios SET contrasena = ?, token = NULL WHERE token = ?");
        $stmt->execute([$contrasena, $token]);

        if ($stmt->rowCount() === 0) {
            // Si no se actualizó nada, intentar actualizar en la tabla de empresas
            $stmt = $conexion->prepare("UPDATE empresas SET contrasena = ?, token = NULL WHERE token = ?");
            $stmt->execute([$contrasena, $token]);
        }

        // Verificar si se actualizó alguna fila en alguna de las tablas
        if ($stmt->rowCount() > 0) {
            // Redirigir al usuario al index.php
            header("Location: index.php");
            exit(); // Asegúrate de salir del script después de la redirección
        } else {
            // Si no se pudo restablecer la contraseña, mostrar un mensaje de error
            $error_message = "No se pudo restablecer la contraseña. Por favor, inténtalo de nuevo.";
        }
    } else {
        // Mostrar un mensaje de error si las contraseñas no coinciden
        $error_message = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    }
}
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
        p.error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <form action="procesar_restablecer.php" method="post">
            <label for="contrasena">Nueva Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <label for="confirmar_contrasena">Confirmar Contraseña:</label>
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_POST['token']); ?>">
            <button type="submit">Restablecer Contraseña</button>
        </form>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
