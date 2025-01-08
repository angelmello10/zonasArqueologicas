<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../model/conexion.php'; // Incluir el archivo de conexión

class CulturaController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $accion = $_POST['accion'];

            if ($accion == 'crear') {
                $this->agregarCultura();
            } elseif ($accion == 'eliminar') {
                $this->eliminarCultura();
            } elseif ($accion == 'editar') {
                $this->editarCultura();
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['accion']) && $_GET['accion'] == 'obtener') {
                $this->obtenerCultura();
            }
        }
    }

    private function agregarCultura() {
        $nombreCultura = $_POST['nombreCultura'];
        $descripcion = $_POST['descripcion'];
        $ubicacion = $_POST['ubicacion'];
        $idEstado = $_POST['idEstado'];
        $informacion = $_POST['informacion'];

        if (isset($_FILES['imagenCultura']) && $_FILES['imagenCultura']['error'] == UPLOAD_ERR_OK) {
            $imagenCultura = file_get_contents($_FILES['imagenCultura']['tmp_name']);
        } else {
            echo "<script>alert('Imagen requerida o error en carga.'); window.location.href = '../view/editor.php';</script>";
            return;
        }

        $stmt = $this->conn->prepare("INSERT INTO Culturas (nombreCultura, descripcion, ubicacion, idEstado, informacion, imagenCultura) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombreCultura, $descripcion, $ubicacion, $idEstado, $informacion, $imagenCultura);

        if ($stmt->execute()) {
            echo "<script>alert('Cultura creada exitosamente.'); window.location.href = '../view/editor.php?mensaje=creado';</script>";
            exit;
        } else {
            echo "<script>alert('Error al crear cultura: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    private function eliminarCultura() {
        $idCulturaEliminar = $_POST['idCulturaEliminar'];

        $stmt = $this->conn->prepare("DELETE FROM Culturas WHERE idCultura = ?");
        $stmt->bind_param("i", $idCulturaEliminar);

        if ($stmt->execute()) {
            echo "<script>alert('Cultura eliminada exitosamente.'); window.location.href = '../view/editor.php?mensaje=eliminado';</script>";
            exit;  
        } else {
            echo "<script>alert('Error al eliminar cultura: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    public function editarCultura() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    
        if (empty($_POST['idCultura']) || empty($_POST['nombreCultura']) || empty($_POST['descripcion']) || 
            empty($_POST['ubicacion']) || empty($_POST['idEstado']) || empty($_POST['informacion'])) {
            echo "<script>alert('Error: Uno o más campos obligatorios están vacíos.');</script>";
            return;
        }
    
        $idCultura = (int)$_POST['idCultura'];
        $nombreCultura = $_POST['nombreCultura'];
        $descripcion = $_POST['descripcion'];
        $ubicacion = $_POST['ubicacion'];
        $idEstado = (int)$_POST['idEstado'];
        $informacion = $_POST['informacion'];
    
        try {
            $stmtCheck = $this->conn->prepare("SELECT * FROM Culturas WHERE idCultura = ?");
            $stmtCheck->bind_param("i", $idCultura);
            $stmtCheck->execute();
            $result = $stmtCheck->get_result();
    
            if ($result->num_rows === 0) {
                echo "<script>alert('Error: No se encontró la cultura con el ID $idCultura.');</script>";
                return;
            }
    
            if (isset($_FILES['imagenCulturaEditar']) && $_FILES['imagenCulturaEditar']['error'] == UPLOAD_ERR_OK) {
                $imagenCultura = file_get_contents($_FILES['imagenCulturaEditar']['tmp_name']);
                $stmt = $this->conn->prepare("UPDATE Culturas SET nombreCultura=?, descripcion=?, ubicacion=?, idEstado=?, informacion=?, imagenCultura=? WHERE idCultura=?");
                $stmt->bind_param("ssssssi", $nombreCultura, $descripcion, $ubicacion, $idEstado, $informacion, $imagenCultura, $idCultura);
            } else {
                $stmt = $this->conn->prepare("UPDATE Culturas SET nombreCultura=?, descripcion=?, ubicacion=?, idEstado=?, informacion=? WHERE idCultura=?");
                $stmt->bind_param("sssssi", $nombreCultura, $descripcion, $ubicacion, $idEstado, $informacion, $idCultura);
            }
    
            if ($stmt->execute()) {
                echo "<script>alert('Cultura actualizada exitosamente.'); window.location.href='../view/editor.php';</script>";
                exit;
            } else {
                echo "<script>alert('Error al actualizar cultura: " . $stmt->error . "');</script>"; 
            }
    
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    
        if (isset($stmt) && $stmt) {
            $stmt->close();
        }
    }

    public function obtenerCultura() {
        if (!isset($_GET['idCultura'])) {
            echo json_encode(['error' => 'ID de cultura no proporcionado.']);
            exit;
        }
    
        $idCultura = intval($_GET['idCultura']);
        if ($idCultura <= 0) {
            echo json_encode(['error' => 'ID de cultura no válido.']);
            exit;
        }
    
        $stmt = $this->conn->prepare("
            SELECT C.idCultura, C.nombreCultura, C.descripcion, C.ubicacion, C.informacion, C.imagenCultura, C.idEstado, E.nombreEstado 
            FROM Culturas AS C
            LEFT JOIN Estados AS E ON C.idEstado = E.idEstado
            WHERE C.idCultura = ?
        ");
        
        if (!$stmt) {
            echo json_encode(['error' => 'Error en la preparación de la consulta.']);
            exit;
        }
    
        $stmt->bind_param("i", $idCultura);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $cultura = $resultado->fetch_assoc();
            $cultura['imagenCultura'] = $cultura['imagenCultura'] ? base64_encode($cultura['imagenCultura']) : null;
            echo json_encode($cultura);
        } else {
            echo json_encode(['error' => 'Cultura no encontrada.']);
        }
    
        $stmt->close();
        exit;
    }

    public function obtenerCulturas() {
        $query = "SELECT * FROM Culturas";
        $resultado = $this->conn->query($query);
        $culturas = [];

        while ($row = $resultado->fetch_assoc()) {
            $culturas[] = $row;
        }
        return $culturas;
    }
}

$controller = new CulturaController($conn);
$controller->handleRequest();
