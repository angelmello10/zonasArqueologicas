<?php
session_start();
include '../model/conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No estás autorizado.']);
    exit;
}

// Obtener el ID del usuario de la sesión
$idUsuario = $_SESSION['user_id'];

// Verificar si se recibió la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];

    // Actualizar la base de datos
    if ($campo === 'contraseña') {
        // Hash de la nueva contraseña
        $valor = password_hash($valor, PASSWORD_DEFAULT); 
        $sql = "UPDATE usuarios SET $campo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $valor, $idUsuario);
    } else {
        $sql = "UPDATE usuarios SET $campo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $valor, $idUsuario);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la información.']);
    }

    $stmt->close();
}
?>
