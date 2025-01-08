<!DOCTYPE html>
<html lang="en">
<?php 
    include 'modulos/head.php';  // Incluye los scripts de la cabecera

    // Conexión a la base de datos
    include('../model/conexion.php'); 

    // Obtener el ID de la zona desde la URL
    $idZona = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Consulta para obtener los datos de la zona arqueológica, incluyendo datos de contacto y coordenadas
    $query = "
        SELECT z.nombreZona, z.descripcion, z.horarioApertura, z.horarioCierre, z.costoEntrada, z.ubicacion, 
               z.datosContacto, z.diasApertura, z.informacion, e.nombreEstado, z.latitud, z.longitud
        FROM ZonasArqueologicas z
        JOIN Estados e ON z.idEstado = e.idEstado
        WHERE z.idZona = $idZona";
    $result = $conn->query($query);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombreZona = $row['nombreZona'];
        $descripcion = $row['descripcion'];
        $horarioApertura = $row['horarioApertura'];
        $horarioCierre = $row['horarioCierre'];
        $costoEntrada = $row['costoEntrada'];
        $ubicacion = $row['ubicacion'];
        $datosContacto = $row['datosContacto'];  // Nuevo campo de datos de contacto
        $diasApertura = $row['diasApertura']; // Nuevo campo para los días de apertura
        $informacion = $row['informacion']; // Nuevo campo para la información
        $nombreEstado = $row['nombreEstado']; // Nuevo campo para el nombre del estado
        $latitud = $row['latitud']; // Nueva variable para la latitud
        $longitud = $row['longitud']; // Nueva variable para la longitud
    } else {
        // Si no se encuentra la zona, puedes redirigir o mostrar un mensaje
        echo "<p>No se encontraron detalles para esta zona arqueológica.</p>";
        exit; // Termina la ejecución si no hay datos
    }

    // Cerrar la conexión
    $conn->close();
?>
<body>

    <?php include 'modulos/navegador3.php'; ?>  <!-- Navegador -->

    <div id="hero" class="hero overlay subpage-hero portfolio-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1><?php echo $nombreZona; ?></h1>  <!-- Título de la zona -->
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="zonasArq.php">Zonas Arqueológicas</a></li>
                  <li class="breadcrumb-item active"><?php echo $nombreZona; ?></li>
                </ol>
            </div><!-- /.hero-text -->
        </div><!-- /.hero-content -->
    </div><!-- /.hero -->

    <main id="main" class="site-main">

        <section class="site-section subpage-site-section section-project">
            <div class="container">
                <div class="row">
                        <div class="col-md-8">
                            <div class="project-img">
                                <!-- Vista de Google Street View -->
                                <iframe
                                    width="100%"
                                    height="500"
                                    frameborder="0"
                                    style="border:0"
                                    src="https://www.google.com/maps/embed/v1/streetview?key=AIzaSyCo1oHYJioGF166p-0bCikgDH6PmZ6sjYw&location=<?php echo $latitud; ?>,<?php echo $longitud; ?>&heading=210&pitch=10&fov=35"
                                    allowfullscreen>
                                </iframe>
                            </div><!-- /.project-img -->    
                        </div>

                    <aside class="col-md-4">
                        <div class="project-info">
                            <div class="project-date-category">
                                <!-- Horarios de apertura y cierre -->
                                <h4>Horario:</h4>
                                <p><span><?php echo $diasApertura; ?> de:</span> <span><?php echo $horarioApertura; ?> a: <?php echo $horarioCierre; ?> horas</span></p>
                                <!-- Costo de entrada --><br>
                                <h4>Costo de entrada:</h4>
                                <p><span><?php echo $costoEntrada; ?></span></p><br>
                                <!-- Ubicación -->
                                <h4>Ubicación:</h4>
                                <p><span><?php echo $ubicacion; ?></span></p>
                                <!-- Estado -->
                                <h4>Estado donde se encuentra:</h4>
                                <p><span><?php echo $nombreEstado; ?></span></p> <!-- Mostrar el estado -->
                            </div><!-- /.project-cat -->

                        </div><!-- /.project-info -->
                    </aside>
                </div>
            </div>
        </section><!-- /.section-project -->

        <section class="site-section subpage-site-section section-related-projects">
            <div class="container">

                <h3>Descripción de la zona:</h3>
                <p class="project-description" style="white-space: pre-wrap;"><?php echo $descripcion; ?></p>
                
                <h3>Información de la Zona arqueológica</h3>
                <p class="project-description" style="white-space: pre-wrap;"><?php echo $informacion; ?></p>
                
                <div class="text-left">
                    <h2>Otras zonas recomendadas</h2>
                </div>
                <div class="row">
                    <?php
                    // Conexión a la base de datos
                    include('../model/conexion.php');

                    // Consulta para obtener zonas arqueológicas, excluyendo la actual
                    $queryRelacionados = "SELECT idZona, nombreZona, imagenZona 
                                        FROM ZonasArqueologicas 
                                        WHERE idZona != $idZona LIMIT 4"; // Limitamos a 4 resultados para mostrar
                    $resultRelacionados = $conn->query($queryRelacionados);

                    // Verificar si se obtuvieron resultados
                    if ($resultRelacionados->num_rows > 0) {
                        // Iterar sobre los resultados y generar los elementos HTML dinámicamente
                        while ($row = $resultRelacionados->fetch_assoc()) {
                            // Convertir la imagen en base64 si tiene datos
                            $imagenRelacionada = !empty($row['imagenZona']) 
                                ? 'data:image/jpeg;base64,' . base64_encode($row['imagenZona']) 
                                : '../assets/img/default-image.jpg'; // Imagen predeterminada

                            echo '<div class="col-md-3">';
                            echo '    <div class="portfolio-item">';
                            echo '        <img src="' . $imagenRelacionada . '" class="img-res" alt="Imagen de ' . htmlspecialchars($row['nombreZona']) . '">';
                            echo '        <h4 class="portfolio-item-title">' . htmlspecialchars($row['nombreZona']) . '</h4>';
                            echo '        <a href="infoZona.php?id=' . $row['idZona'] . '"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>'; // Enlace a la información de la zona
                            echo '    </div><!-- /.portfolio-item -->';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No se encontraron proyectos relacionados.</p>";
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </div>

            </div>
        </section><!-- /.section-portfolio -->

    </main><!-- /#main -->

    <?php include 'modulos/footer.php'; ?>  <!-- Footer -->
  
</body>
</html>
