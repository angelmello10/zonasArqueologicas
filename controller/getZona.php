<?php

header('Content-Type: application/json'); // Indicamos que se devolverá una respuesta en formato JSON

require '../model/conexion.php'; // Cambia esta ruta a la conexión de tu base de datos
require 'ZonasController.php'; 

// Creamos una instancia del controlador
$controller = new ZonaController($conn);

// Ejecutamos la función para obtener los datos de la cultura
$controller->obtenerZona();
