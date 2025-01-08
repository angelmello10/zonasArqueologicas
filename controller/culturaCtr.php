<?php
class CulturaController {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    // Función para mostrar culturas con paginación y filtrado por idCultura y idEstado
    public function mostrarCulturas($page, $resultsPerPage, $idCultura = null, $idEstado = null) {
        // Validar la página y resultados por página
        if ($page < 1) {
            $page = 1; // Asegurarse de que la página sea al menos 1
        }

        // Calcular el offset
        $offset = ($page - 1) * $resultsPerPage;

        // Consulta base
        $query = "SELECT idCultura, nombreCultura, descripcion, fecha_creacion, imagenCultura FROM Culturas WHERE 1=1";

        // Agregar cláusula WHERE si se especifica un idCultura
        if ($idCultura !== null) {
            $query .= " AND idCultura = ?";
        }

        // Agregar cláusula WHERE si se especifica un idEstado
        if ($idEstado !== null) {
            $query .= " AND idEstado = ?";
        }

        // Agregar la cláusula LIMIT
        $query .= " LIMIT ?, ?";

        // Preparar la consulta
        if ($stmt = $this->conn->prepare($query)) {
            // Vincular parámetros
            if ($idCultura !== null && $idEstado !== null) {
                $stmt->bind_param("iiii", $idCultura, $idEstado, $offset, $resultsPerPage);
            } elseif ($idCultura !== null) {
                $stmt->bind_param("iii", $idCultura, $offset, $resultsPerPage);
            } elseif ($idEstado !== null) {
                $stmt->bind_param("iii", $idEstado, $offset, $resultsPerPage);
            } else {
                $stmt->bind_param("ii", $offset, $resultsPerPage);
            }

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener resultados
                return $stmt->get_result();
            } else {
                error_log("Error en la ejecución de la consulta: " . $stmt->error);
                return null; // O manejar el error de otra forma
            }
        } else {
            error_log("Error en la preparación de la consulta: " . $this->conn->error);
            return null; // O manejar el error de otra forma
        }
    }

    // Función para contar el total de culturas, opcionalmente filtrando por idCultura y idEstado
    public function contarCulturas($idCultura = null, $idEstado = null) {
        $query = "SELECT COUNT(*) as total FROM Culturas WHERE 1=1";

        // Agregar cláusula WHERE si se especifica un idCultura
        if ($idCultura !== null) {
            $query .= " AND idCultura = ?";
        }

        // Agregar cláusula WHERE si se especifica un idEstado
        if ($idEstado !== null) {
            $query .= " AND idEstado = ?";
        }

        // Preparar la consulta
        if ($stmt = $this->conn->prepare($query)) {
            if ($idCultura !== null && $idEstado !== null) {
                $stmt->bind_param("ii", $idCultura, $idEstado);
            } elseif ($idCultura !== null) {
                $stmt->bind_param("i", $idCultura);
            } elseif ($idEstado !== null) {
                $stmt->bind_param("i", $idEstado);
            }

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result->fetch_assoc()['total'];
            } else {
                error_log("Error en la ejecución de la consulta: " . $stmt->error);
                return 0; // O manejar el error de otra forma
            }
        } else {
            error_log("Error en la preparación de la consulta: " . $this->conn->error);
            return 0; // O manejar el error de otra forma
        }
    }
}
?>
