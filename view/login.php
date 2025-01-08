<?php
// Iniciar la sesión al comienzo del archivo
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../model/UserModel.php';
$userModel = new UserModel();
$loginError = '';
$registerError = '';
$registerSuccess = false;

// Iniciar sesión solo si el formulario de inicio de sesión fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Verificar si se han enviado los campos email y password
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email']; // Ahora se toma el valor de 'email' correctamente
        $password = $_POST['password'];

        // Obtener los datos del usuario
        $user = $userModel->login($email, $password);

        if ($user !== false && is_array($user)) { // Verificar que $user es un arreglo
            // Iniciar sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id']; // Guardar el ID del usuario en la sesión
            $_SESSION['email'] = $email; // Guardar el email del usuario en la sesión
            $_SESSION['role'] = $user['rol']; // Guardar el rol del usuario en la sesión
        
            // Redirigir según el rol
            switch ($user['rol']) {
                case 'admin':
                    header("Location: ../Adm/index.php");
                    break;
                case 'editor':
                    header("Location: editor.php");
                    break;
                case 'usuario':
                    header("Location: perfil.php");
                    break;
                default:
                    $loginError = "Acceso denegado. No tienes permisos suficientes.";
            }
            exit();
        } else {
            $loginError = "Usuario o contraseña incorrectos.";
        }    
    } else {
        $loginError = "Por favor ingresa tu correo y contraseña.";
    }
}

// Manejar registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $nombre = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cifrar la contraseña antes de guardarla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $registerResult = $userModel->register($nombre, $email, $hashedPassword);

    if ($registerResult === true) {
        $registerSuccess = true; // Registro exitoso
        $_SESSION['register_message'] = "¡Registro exitoso! Ahora puedes iniciar sesión.";
        header("Location: " . $_SERVER['PHP_SELF']); // Recargar para mostrar mensaje
        exit();
    } elseif ($registerResult === "duplicate_email") {
        $registerError = "<script>alert('El correo que ingresaste ya esta en uso!');</script>";
    } else {
        $registerError = "Error al registrarse.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<?php include 'modulos/head.php'; ?>
<body>

   <?php include 'modulos/navegador3.php'; ?>

    <div id="hero" class="hero overlay subpage-hero contact-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Autenticación</h1>
            </div><!-- /.hero-text -->
        </div><!-- /.hero-content -->
    </div><!-- /.hero -->

    <main id="main" class="site-main">
        <section class="site-section subpage-site-section section-contact-us">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <!-- Formularios de Autenticación -->
                        <div id="auth-forms">
                            <!-- Formulario de Inicio de Sesión -->
                            <div id="login-form">
                                <h2>Iniciar Sesión</h2>

                                <!-- Mostrar mensajes de éxito o error -->
                                <?php if ($loginError): ?>
                                    <div class="alert alert-danger"><?php echo $loginError; ?></div>
                                <?php elseif (isset($_SESSION['register_message'])): ?>
                                    <div class="alert alert-success"><?php echo $_SESSION['register_message']; ?></div>
                                    <?php unset($_SESSION['register_message']); ?>
                                <?php endif; ?>

                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="email">Correo:</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Contraseña:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="login" class="btn btn-fill mb-10">Iniciar Sesión</button>
                                        <p style="font-size: 1.0em; font-weight: bold; color: black;">¿No tienes una cuenta? <a href="#" id="show-register" style="font-size: 1.2em; font-weight: bold; color: black;">Regístrate aquí</a></p>
                                    </div>
                                </form>
                            </div>

                            <!-- Formulario de Registro -->
                            <div id="register-form" style="display: none;">
                                <h2>Registrarse</h2>

                                <?php if ($registerError): ?>
                                    <div class="alert alert-danger"><?php echo $registerError; ?></div>
                                <?php endif; ?>

                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="register-username">Ingresa tu nombre:</label>
                                        <input type="text" class="form-control" id="register-username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Correo:</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="register-password">Contraseña:</label>
                                        <input type="password" class="form-control" id="register-password" name="password" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="register" class="btn btn-fill mb-10">Registrarse</button>
                                        <p style="font-size: 1.0em; font-weight: bold; color: black;">¿Ya tienes una cuenta? <a href="#" id="show-login" style="font-size: 1.2em; font-weight: bold; color: black;">Inicia Sesión</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="contact-info">
                            <p style="font-size: 1.2em; color: black;">- Puedes registrarte o iniciar sesión para agendar una visita.</p>
                        </div><!-- /.contact-info -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.site-section -->
    </main><!-- /.site-main -->

    <?php include 'modulos/footer.php'; ?>

    <!-- Scripts para alternar entre formularios -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showRegisterLink = document.getElementById('show-register');
            const showLoginLink = document.getElementById('show-login');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');

            if (showRegisterLink && loginForm && registerForm) {
                showRegisterLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    loginForm.style.display = 'none';
                    registerForm.style.display = 'block';
                });
            }

            if (showLoginLink && loginForm && registerForm) {
                showLoginLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    registerForm.style.display = 'none';
                    loginForm.style.display = 'block';
                });
            }
        });
    </script>
</body>
</html>
