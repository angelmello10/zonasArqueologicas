<?php
// ReservaController.php

include 'model/conexion.php';

class ReservaController {
    public function procesarReserva() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Capturamos los datos del formulario
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $fechaVisita = $_POST['fechaVisita'];
            $horaVisita = $_POST['horaVisita'];
            $numeroPersonas = $_POST['numeroPersonas'];
            $guia = $_POST['guia'];
            $idZona = $_POST['zona']; // Asegúrate de que esto coincida con el nombre del campo

            // Definimos el costo total (puedes ajustar este cálculo según tu lógica)
            $costoPorPersona = 100; // Ejemplo de costo por persona
            $costoTotal = $costoPorPersona * $numeroPersonas;

            // Preparamos la consulta
            $stmt = $GLOBALS['conn']->prepare("INSERT INTO reservas (nombre, telefono, fecha_visita, hora_visita, numero_personas, guia, costo_total, idZona) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssiis", $nombre, $telefono, $fechaVisita, $horaVisita, $numeroPersonas, $guia, $costoTotal, $idZona);

            // Ejecutamos la consulta
            if ($stmt->execute()) {
                // Éxito: redirige o muestra un mensaje
                header("Location: confirmacion.php"); // Asegúrate de crear esta página
                exit();
            } else {
                // Error: manejar error
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

// Instanciamos el controlador y llamamos al método
$reservaController = new ReservaController();
$reservaController->procesarReserva();
?>
