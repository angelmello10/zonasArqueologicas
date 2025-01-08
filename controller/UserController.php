<?php
include 'model/UserModel.php'; // Asegúrate de que la ruta sea correcta
include 'model/conexion.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function handleRequest() {
        // Iniciar sesión antes de manejar las solicitudes
        session_start(); 

        $error = ''; // Inicializar variable de error

        // Manejar inicio de sesión
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['login'])) {
                $email = $_POST['username'] ?? ''; // Usar null coalescing para evitar errores
                $password = $_POST['password'] ?? '';

                // Intenta iniciar sesión
                $userId = $this->userModel->login($email, $password);
                if ($userId) {
                    // Almacenar el ID del usuario y la sesión de inicio de sesión
                    $_SESSION['user_id'] = $userId; // Guardar el ID en la sesión
                    $_SESSION['loggedin'] = true; // Marcar la sesión como iniciada
                    // Redirigir a la página principal
                    header("Location: /index.php");
                    exit();
                } else {
                    $error = "Usuario o contraseña incorrectos.";
                }
            } elseif (isset($_POST['register'])) {
                $nombre = $_POST['username'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                // Intenta registrar al usuario
                if ($this->userModel->register($nombre, $email, $password)) {
                    // Redirigir a la página principal o mostrar un mensaje de éxito
                    header("Location: /index.php");
                    exit();
                } else {
                    $error = "Error al registrarse.";
                }
            }
        }

        // Cargar la vista de autenticación, pasando el error si existe
        include 'view/auth.php'; // Asegúrate de que la ruta sea correcta
    }
}

// Crear una instancia del controlador y manejar la solicitud
$controller = new UserController();
$controller->handleRequest();
?>
