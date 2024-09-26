<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea eliminar la cookie de sesión, es probable que también se deba eliminar la cookie
// Tenga en cuenta que esto destruirá la sesión y no la información de la sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir a la página de inicio de sesión u otra página deseada
header("Location: index.php");
exit();
?>
