<?php
require_once "bd.php";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mensaje = '';

    // Verificar si el correo electrónico está registrado en la tabla de usuarios
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo_electronico = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra en la tabla de usuarios, verificar en la tabla de empresas
    if (!$usuario) {
        $stmt = $conexion->prepare("SELECT * FROM empresas WHERE correo_electronico = ?");
        $stmt->execute([$email]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Generar un token y actualizar la tabla correspondiente
    if ($usuario || $empresa) {
        $token = bin2hex(random_bytes(16));
        
        if ($usuario) {
            $stmt = $conexion->prepare("UPDATE usuarios SET token = ? WHERE correo_electronico = ?");
            $stmt->execute([$token, $email]);
        } else if ($empresa) {
            $stmt = $conexion->prepare("UPDATE empresas SET token = ? WHERE correo_electronico = ?");
            $stmt->execute([$token, $email]);
        }

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'soportportalwork@gmail.com';
        $mail->Password = 'vvhosafbfhihngzs';
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('soportportalwork@gmail.com', 'Work portal');
        $mail->addAddress($email);
        $mail->Subject = 'Recuperar';
        $mail->Body = '¿Querés cambiar tu contraseña? haz clic en el siguiente enlace para restablecer tu contraseña: http://localhost/sitioweb/restablecer_contraseña.php?token=' . $token;

        if ($mail->send()) {
            $mensaje = "Te enviamos un enlace de recuperación a tu correo electrónico. Ingresa y elige una nueva contraseña.";
            $mensaje_tipo = "success";
        } else {
            $mensaje = "Error al enviar el correo electrónico. Por favor, inténtalo de nuevo.";
            $mensaje_tipo = "error";
        }
    } else {
        $mensaje = "Correo electrónico no registrado.";
        $mensaje_tipo = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        header {
            width: 100%;
            background-color: #fff;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #1c75bc;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #155e93;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <?php if (isset($mensaje)): ?>
            <div class="message <?php echo $mensaje_tipo; ?>">
                <?php echo $mensaje; ?>
            </div>
            <button onclick="window.location.href='index.php'">Volver al inicio</button>
        <?php endif; ?>
    </div>
</body>
</html>
