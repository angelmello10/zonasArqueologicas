<!DOCTYPE html>
<html lang="en">
<?php include 'modulos/head.php'; ?>

<body>
    <?php include 'modulos/navegador3.php'; ?>

    <div id="hero" class="hero overlay subpage-hero blog-hero">
        <div class="hero-content">
            <div class="hero-text">
                <?php
                // Conexión a la base de datos
                include('../model/conexion.php');

                // Obtener el ID de la cultura desde la URL
                $idCultura = isset($_GET['idCultura']) ? (int)$_GET['idCultura'] : 0;

                // Consultar los datos de la cultura, incluyendo 'informacion' y los estados relacionados
                $query = "
                    SELECT c.nombreCultura, c.informacion, c.ubicacion, c.imagenCultura, c.fecha_creacion, 
                           GROUP_CONCAT(e.nombreEstado SEPARATOR ', ') AS estados
                    FROM Culturas c
                    LEFT JOIN cultura_estado ce ON c.idCultura = ce.idCultura
                    LEFT JOIN Estados e ON ce.idEstado = e.idEstado
                    WHERE c.idCultura = ?
                    GROUP BY c.idCultura";

                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("i", $idCultura);
                    $stmt->execute();
                    $stmt->bind_result($nombreCultura, $informacion, $ubicacion, $imagenCultura, $fechaCreacion, $estados);
                    $stmt->fetch();
                    $stmt->close();
                } else {
                    echo "<h1>Error al consultar la cultura: " . htmlspecialchars($conn->error) . "</h1>";
                    exit; // Detener la ejecución si hay un error
                }

                // Verificar si se obtuvieron resultados
                if (!$nombreCultura) {
                    echo "<h1>Error: Cultura no encontrada.</h1>";
                    exit; // Detener la ejecución si no se encontró la cultura
                }
                ?>
                <h1><?php echo htmlspecialchars($nombreCultura); ?></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="../culturas.php">Culturas</a></li>
                </ol>
                                </div><!-- /.hero-text -->
                            </div><!-- /.hero-content -->
                        </div><!-- /.hero -->

                        <main id="main" class="site-main">
                            <section class="site-section subpage-site-section section-blog">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <article class="blog-post">
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <?php 
                            // Verificar si 'imagenCultura' no está vacío
                            if (!empty($imagenCultura)) {
                                // Si la imagen es un BLOB, deberías estar almacenando los datos correctamente
                                // Si la imagen está en formato BLOB, codificarla en base64
                                $imageType = gettype($imagenCultura);
                                echo "<!-- Tipo de dato de la imagen: $imageType -->"; // Debug: tipo de dato de la imagen
                                if ($imageType === 'string' && strpos($imagenCultura, 'data:image/') === 0) {
                                    // Imagen ya en formato base64
                                    echo '<img src="' . htmlspecialchars($imagenCultura) . '" class="img-res" style="max-width: 80%; height: auto; border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);">';
                                } elseif (is_resource($imagenCultura) || (is_string($imagenCultura) && strlen($imagenCultura) > 0)) {
                                    // Si es un recurso o string válido
                                    $imagenCulturaBase64 = 'data:image/jpeg;base64,' . base64_encode($imagenCultura);
                                    echo '<img src="' . htmlspecialchars($imagenCulturaBase64) . '" class="img-res" style="max-width: 80%; height: auto; border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);">';
                                } else {
                                    // Mostrar imagen por defecto
                                    echo '<img src="assets/img/default-image.jpg" class="img-res" style="max-width: 80%; height: auto; border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);">';
                                }
                            } else {
                                // Usar imagen por defecto si no hay imagen
                                echo '<img src="assets/img/default-image.jpg" class="img-res" style="max-width: 80%; height: auto; border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);">';
                            }
                            ?>
                        </div>
                        
                        <div class="post-content">
                            <h4>Acerca de esta cultura:</h4>
                            <p><?php echo nl2br(htmlspecialchars($informacion)); ?></p><br>
                            <h4>¿Dónde se ubicaban?</h4>
                            <p><?php echo htmlspecialchars($ubicacion); ?></p>
                            
                            <br><h4>Estados relacionados:</h4>
                            <p><?php echo htmlspecialchars($estados ? $estados : 'No se encontraron estados relacionados.'); ?></p>

                            <p><strong>Última actualización: </strong> <?php echo htmlspecialchars($fechaCreacion); ?></p>
                        </div><!-- /.post-content -->
                    </article><!-- /.blog-post -->

                    </div>
                </div>
            </div>
        </section><!-- /.section-portfolio -->
    </main><!-- /#main -->
    
    <?php include 'modulos/footer.php'; ?>
</body>
</html>