<?php
// getCultura.php
header('Content-Type: application/json'); // Indicamos que se devolverá una respuesta en formato JSON

require '../model/conexion.php'; // Cambia esta ruta a la conexión de tu base de datos
require 'CulturaController.php'; // Asegúrate de que CulturaController.php esté en la misma ruta o ajústala

// Creamos una instancia del controlador
$controller = new CulturaController($conn);

// Ejecutamos la función para obtener los datos de la cultura
$controller->obtenerCultura();
