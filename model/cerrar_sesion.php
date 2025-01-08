<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
$_SESSION = array(); // Limpia la variable de sesión

// Si se desea destruir la sesión completamente, se puede usar:
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params(); // Obtener los parámetros de la cookie
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]); // Destruir la cookie
}

// Finalmente, destruir la sesión
session_destroy();

// Establecer un mensaje de cierre de sesión exitoso
$_SESSION['logout_message'] = "Has cerrado sesión exitosamente.";

// Mostrar una alerta y redirigir
echo "<script>
        alert('".$_SESSION['logout_message']."');
        window.location.href = '../view/login.php'; // Redirigir a la página de inicio
      </script>";
exit();
?>
