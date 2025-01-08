<?php
// Iniciar la sesión al principio del archivo
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}
$idUsuario = $_SESSION['user_id'];

// Aquí debes realizar una consulta para obtener la información del usuario de la base de datos
include '../model/conexion.php'; // Archivo que incluye la conexión a la base de datos

$sql = "SELECT nombre, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Inicializar la variable de error
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesar el formulario de actualización
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password']; // La contraseña puede ser opcional
    $confirmPassword = $_POST['confirm_password']; // Nueva contraseña confirmada

    // Validar si se ha proporcionado una nueva contraseña
    if (!empty($password)) {
        // Verificar que las contraseñas coincidan
        if ($password !== $confirmPassword) {
            // Asignar mensaje de error
            $errorMessage = 'Las contraseñas no coinciden.';
        } else {
            // Si las contraseñas coinciden, la encriptamos
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nombre = ?, email = ?, contraseña = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $nombre, $email, $hashedPassword, $idUsuario);
        }
    } else {
        // Si la contraseña está vacía, no la actualizamos
        $sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $email, $idUsuario);
    }

    // Ejecutar la consulta
    if (empty($errorMessage) && $stmt->execute()) {
        echo "<script>alert('Información actualizada con éxito.'); window.location.href='perfil.php';</script>";
    } else {
        // Puedes mostrar un mensaje de error si la actualización falla
        if (empty($errorMessage)) {
            $errorMessage = 'Error al actualizar la información.';
        }
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
            <h1>Bienvenido</h1>
        </div><!-- /.hero-text -->
    </div><!-- /.hero-content -->
</div><!-- /.hero -->

<main id="main" class="site-main">
    <section class="site-section subpage-site-section section-contact-us">
        <div class="container my-5">
            <h2 class="text-center">Mi Perfil</h2>

            <div class="card mt-4">
                <div class="card-header bg-primary text-white text-center">
                    Información del Perfil
                </div>

                <div class="card-body">
                    <form method="POST" id="editForm">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($userData['nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Dejar vacío si no desea cambiarla">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar nueva contraseña">
                            <?php if (!empty($errorMessage)): ?>
                                <div class="text-danger mt-2"><?php echo $errorMessage; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-3">Guardar Cambios</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <a href="eliminar_usuario.php?id=<?php echo $idUsuario; ?>" class="btn btn-danger mt-3" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?');">
                            <i class="fas fa-trash-alt"></i> Eliminar Cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.section-contact-us -->
</main><!-- /#main -->

</body>
<?php include 'modulos/footer.php'; ?>
</html>
