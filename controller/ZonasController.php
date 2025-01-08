<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../model/conexion.php'; 

class ZonaController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $accion = $_POST['accion'];

            if ($accion == 'crear') {
                $this->agregarZona();
            } elseif ($accion == 'eliminar') {
                $this->eliminarZona();
            } elseif ($accion == 'editar') {
                $this->editarZona();
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['accion']) && $_GET['accion'] == 'obtener') {
                $this->obtenerZona();
            }
        }
    }

    private function agregarZona() {
        $nombreZona= $_POST['nombreZona'];
        $descripcion = $_POST['descripcion'];
        $informacion = $_POST['informacion'];
        $idEstado = $_POST['idEstado'];
        $horarioApertura = $_POST['horarioApertura'];
        $horarioCierre = $_POST['horarioCierre'];
        $diasApertura = $_POST['diasApertura'];
        $costoEntrada = $_POST['costoEntrada'];
        $ubicacion = $_POST['ubicacion'];
        if (isset($_FILES['imagenZona']) && $_FILES['imagenZona']['error'] == UPLOAD_ERR_OK) {
            $imagenZona = file_get_contents($_FILES['imagenZona']['tmp_name']);
        } else {
            echo "<script>alert('Imagen requerida o error en carga.'); window.location.href = '../view/editor.php';</script>";
            return;
        }
        $idCultura = $_POST['idCultura'];
        $datosContacto = $_POST['datosContacto'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];

        

        $stmt = $this->conn->prepare("INSERT INTO ZonasArqueologicas (nombreZona, descripcion, informacion, idEstado, horarioApertura, horarioCierre,
        diasApertura, costoEntrada, ubicacion, imagenZona, idCultura, datosContacto, latitud, longitud) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissssssisss", $nombreZona, $descripcion, $informacion, $idEstado, $horarioApertura, $horarioCierre, $diasApertura, $costoEntrada, $ubicacion,
                                                $imagenZona, $idCultura, $datosContacto, $latitud, $longitud);

        if ($stmt->execute()) {
            echo "<script>alert('Zona Arqueológica creada exitosamente.'); window.location.href = '../view/editor.php?mensaje=creado';</script>";
            exit;
        } else {
            echo "<script>alert('Error al crear cultura: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

            private function eliminarZona() {
                $idZonaEliminar = $_POST['idZonaEliminar'];

                $stmt = $this->conn->prepare("DELETE FROM ZonasArqueologicas WHERE idZona = ?");
                $stmt->bind_param("i", $idZonaEliminar);

                if ($stmt->execute()) {
                    echo "<script>alert('Zona eliminada exitosamente.'); window.location.href = '../view/editor.php?mensaje=eliminado';</script>";
                    exit;  
                } else {
                    echo "<script>alert('Error al eliminar cultura: " . $stmt->error . "');</script>";
                }

                $stmt->close();
            }

            public function editarZona() {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
            
                // Recoger datos del formulario
                $idZona = (int)$_POST['idZona'];
                $nombreZona = $_POST['nombreZona'];
                $descripcion = $_POST['descripcion'];
                $ubicacion = $_POST['ubicacion'];
                $idEstado = (int)$_POST['idEstado'];
                $informacion = $_POST['informacion'];
                $horarioApertura = $_POST['horarioApertura'];
                $horarioCierre = $_POST['horarioCierre'];
                $diasApertura = $_POST['diasApertura'];
                $costoEntrada = $_POST['costoEntrada'];
                $latitud = $_POST['latitud'];
                $longitud = $_POST['longitud'];
                $datosContacto = $_POST['datosContacto'];
                $idCultura = (int)$_POST['idCultura'];
            
                try {
                    // Verificar si existe la zona arqueológica
                    $stmtCheck = $this->conn->prepare("SELECT * FROM ZonasArqueologicas WHERE idZona = ?");
                    $stmtCheck->bind_param("i", $idZona);
                    $stmtCheck->execute();
                    $result = $stmtCheck->get_result();
            
                    if ($result->num_rows === 0) {
                        echo "<script>alert('Error: No se encontró la zona arqueológica con el ID $idZona.');</script>";
                        return;
                    }
            
                    // Verificar si se subió una nueva imagen
                    if (isset($_FILES['imagenZonaEditar']) && $_FILES['imagenZonaEditar']['error'] == UPLOAD_ERR_OK) {
                        // Validar el tipo de archivo (opcional)
                        $fileType = $_FILES['imagenZonaEditar']['type'];
                        if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
                            echo "<script>alert('Error: Solo se permiten imágenes JPG, PNG o GIF.');</script>";
                            return;
                        }
            
                        // Leer la imagen como BLOB
                        $imagenZona = file_get_contents($_FILES['imagenZonaEditar']['tmp_name']);
                        // Consulta SQL con imagen
                        $stmt = $this->conn->prepare("UPDATE ZonasArqueologicas SET 
                                                        nombreZona=?, descripcion=?, ubicacion=?, 
                                                        idEstado=?, informacion=?, horarioApertura=?, 
                                                        horarioCierre=?, diasApertura=?, costoEntrada=?, 
                                                        latitud=?, longitud=?, datosContacto=?, 
                                                        idCultura=?, imagenZona=? WHERE idZona=?");
                        // Vincular los parámetros
                        $stmt->bind_param("sssissssssssssi", $nombreZona, $descripcion, $ubicacion, $idEstado, 
                                                        $informacion, $horarioApertura, $horarioCierre, 
                                                        $diasApertura, $costoEntrada, $latitud, 
                                                        $longitud, $datosContacto, $idCultura, 
                                                        $imagenZona, $idZona);
                    } else {
                        // Si no hay imagen, solo actualizar los demás campos
                        $stmt = $this->conn->prepare("UPDATE ZonasArqueologicas SET 
                                                        nombreZona=?, descripcion=?, ubicacion=?, 
                                                        idEstado=?, informacion=?, horarioApertura=?, 
                                                        horarioCierre=?, diasApertura=?, costoEntrada=?, 
                                                        latitud=?, longitud=?, datosContacto=?, 
                                                        idCultura=? WHERE idZona=?");
                        // Vincular los parámetros (sin la imagen)
                        $stmt->bind_param("sssisssssssssi", $nombreZona, $descripcion, $ubicacion, $idEstado, 
                                                        $informacion, $horarioApertura, $horarioCierre, 
                                                        $diasApertura, $costoEntrada, $latitud, 
                                                        $longitud, $datosContacto, $idCultura, $idZona);
                    }
            
                    // Ejecutar la consulta
                    if ($stmt->execute()) {
                        echo "<script>alert('Zona arqueológica actualizada exitosamente.'); window.location.href='../view/editor.php';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Error al actualizar zona arqueológica: " . $stmt->error . "');</script>";
                    }
            
                } catch (Exception $e) {
                    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
                }
            
                // Cerrar el statement
                if (isset($stmt) && $stmt) {
                    $stmt->close();
                }
            }
            
            
            
            

            public function obtenerZona() {
                
                if (!isset($_GET['idZona'])) {
                    echo json_encode(['error' => 'ID de Zona no proporcionado.']);
                    exit;
                }
            
                $idZona = intval($_GET['idZona']);
                if ($idZona <= 0) {
                    echo json_encode(['error' => 'ID de Zona no válido.']);
                    exit;
                }
            
                $stmt = $this->conn->prepare("
                    SELECT 
                        z.idZona,
                        z.nombreZona, 
                        z.descripcion, 
                        z.informacion, 
                        z.horarioApertura, 
                        z.horarioCierre, 
                        z.diasApertura, 
                        z.costoEntrada, 
                        z.ubicacion, 
                        z.imagenZona,
                        z.fecha_creacion, 
                        z.datosContacto, 
                        z.latitud, 
                        z.longitud, 
                        e.nombreEstado,
                        c.nombreCultura
                    FROM 
                        ZonasArqueologicas z
                    JOIN 
                        Estados e ON z.idEstado = e.idEstado
                    JOIN 
                        Culturas c ON z.idCultura = c.idCultura
                    WHERE 
                        z.idZona = ?" );
            
                if (!$stmt) {
                    echo json_encode(['error' => 'Error en la preparación de la consulta.']);
                    exit;
                }
            
                $stmt->bind_param("i", $idZona);
                $stmt->execute();
                $resultado = $stmt->get_result();
            
                if ($resultado->num_rows > 0) {
                    $zona = $resultado->fetch_assoc();
                    $zona['imagenZona'] = $zona['imagenZona'] ? base64_encode($zona['imagenZona']) : null;
                    echo json_encode($zona);
                } else {
                    echo json_encode(['error' => 'Zona no encontrada.']);
                }
            
                $stmt->close();
                exit;
            }
              
            

    public function obtenerZonas() {
        $query = "SELECT * FROM ZonasArqueologicas";
        $resultado = $this->conn->query($query);
        $culturas = [];

        while ($row = $resultado->fetch_assoc()) {
            $culturas[] = $row;
        }
        return $culturas;
    }
}

$controller = new ZonaController($conn);
$controller->handleRequest();
