<?php
include 'conexion.php'; // Incluir la conexión a la base de datos

class UserModel {
    private $conn;

    public function __construct() {
        global $conn; // Usar la conexión global definida en conexion.php
        $this->conn = $conn;
    }

    // Método para iniciar sesión
    public function login($email, $password) {
        // Consulta para obtener la información del usuario según su email
        $sql = "SELECT id, contraseña, rol FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si se encuentra el usuario, verificamos la contraseña
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['contraseña'])) {
                // Si la contraseña es correcta, retornamos los datos del usuario
                return $user;
            } else {
                // Si la contraseña es incorrecta
                return "wrong_password";
            }
        }
        // Si el usuario no se encuentra
        return "user_not_found";
    }

    // Método para registrar un nuevo usuario
    public function register($nombre, $email, $password) {
        // Verificar si el email ya existe en la base de datos
        $sqlCheck = "SELECT id FROM usuarios WHERE email = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        
        if ($resultCheck->num_rows > 0) {
            // Si el email ya existe, retornamos un mensaje específico
            return "duplicate_email";
        }
    
        // Cifrar la contraseña antes de insertarla
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Inserción de datos en la base de datos
        $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $email, $hashedPassword);
        
        // Ejecutamos la inserción y retornamos un resultado
        if ($stmt->execute()) {
            return true; // Registro exitoso
        } else {
            return false; // Error al registrar
        }
    }
}
?>
