<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es"> <!-- Cambié el idioma a español -->
<head>
    <?php include 'view/modulos/head.php'; ?>
    <style>
        /* Estilo para la barra de desplazamiento en las listas desplegables */
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }
        /* Estilos para el contenedor de Google Maps */
        #map {
            height: 500px; 
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
    <!-- Agrega el script de Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCo1oHYJioGF166p-0bCikgDH6PmZ6sjYw&callback=initMap" async defer></script>
</head>
<body>
    <?php include 'view/modulos/navegador2.php'; ?>

    <div id="hero" class="hero overlay subpage-hero blog-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Culturas de México</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Culturas</li>
                </ol>
            </div>
        </div>
    </div>

    <main id="main" class="site-main">  
        <section class="site-section subpage-site-section section-portfolio">
            <ul class="portfolio-sorting list-inline text-center">
                <span>Filtrar por:</span>
                <!-- Opciones de filtro... -->
            </ul>

            <div class="container">
                <?php
                // Código para mostrar culturas (lo mantengo como en tu código original)
                ?>
                
                <!-- Contenedor para Google Maps -->
                <div id="map"></div> <!-- Aquí se cargará el mapa -->

                <div class="ui-pagination mt-50">
                    <!-- Paginación -->
                </div>
            </div>
        </section>
    </main>

    <?php include 'view/modulos/footer.php'; ?>

    <script>
        function initMap() {
            // Define la ubicación inicial (cambiar coordenadas según zona arqueológica)
            const ubicacion = { lat: 20.6829, lng: -88.5695 }; // Ejemplo: Chichén Itzá

            // Inicializa el mapa
            const map = new google.maps.Map(document.getElementById("map"), {
                center: ubicacion,
                zoom: 14,
            });

            // Configura Street View
            const panorama = new google.maps.StreetViewPanorama(
                document.getElementById("map"), {
                    position: ubicacion,
                    pov: {
                        heading: 34,
                        pitch: 10,
                    },
                    zoom: 1
                }
            );

            // Vincula Street View con el mapa
            map.setStreetView(panorama);
        }
    </script>
</body>
</html>
