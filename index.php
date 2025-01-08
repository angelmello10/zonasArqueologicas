<!DOCTYPE html>
<html lang="en">
<?php 
        include('view/modulos/head.php');
?>
<body>
    <!--Navegador Principal-->
        <?php 
        include('view/modulos/navegadorInd.php');
        ?>

    <div id="hero" class="hero overlay">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Un viaje al pasado te espera...</h1>
                <p></p>
                <a href="zonasArq.php" class="btn btn-border">Leer más...</a>
            </div><!-- /.hero-text -->
        </div><!-- /.hero-content -->
    </div><!-- /.hero -->

    <main id="main" class="site-main">

        <section class="site-section section-features">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                    <h2>Descubre más de la historia de México</h2>
                        <p>
                            Sumérgete en la fascinante historia de las civilizaciones que dieron forma a México, desde los antiguos mayas y aztecas hasta las culturas menos conocidas pero igualmente influyentes. Explora templos, pirámides y artefactos que han resistido el paso del tiempo, y conoce las historias y misterios que aún perduran en estas zonas arqueológicas llenas de legado cultural.
                        </p>

                    </div>
                    <div class="col-sm-7 hidden-xs">
                        <img src="assets/img/museo1.jpg" style="border-radius: 10px;  box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.8);">
                    </div>
                </div>
            </div>
        </section><!-- /.section-features -->

        <section class="site-section section-services gray-bg text-center">
            <div class="container">
                <h2 class="heading-separator">Acerca de nuestros servicios</h2>
                <p class="subheading-text">Acercando a nuestra gente a nuestra historia. </p>
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                              </div><!-- /.service -->
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                            <img src="assets/img/bycicle.svg" alt="">
                            <h3 class="service-title">Recorridos en las zonas arqueológicas</h3>
                            <p class="service-info">Consulta los sitios y costos</p>
                        </div><!-- /.service -->
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                           
                        <img src="assets/img/photo.svg" alt="">
                            <h3 class="service-title">Galería</h3>
                            <p class="service-info">Contamos con una galería en donde se muestran distintos sitios de México</p> </div><!-- /.service -->
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                           </div><!-- /.service -->
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                              </div><!-- /.service -->
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                            <img src="assets/img/rocket.svg" alt="">
                            <h3 class="service-title">Información sobre culturas</h3>
                            <p class="service-info">Aquí podras encontrar información sobre las culturas</p>
                        </div><!-- /.service -->
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                            <img src="assets/img/basket.svg" alt="">
                            <h3 class="service-title">Tienda de artíclos</h3>
                            <p class="service-info">Contamos con una tienda de artículos tradicionales mexicanos</p>
                        </div><!-- /.service -->
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="service">
                           
                        </div><!-- /.service -->
                    </div>
                </div>
            </div>
        </section><!-- /.section-services -->

        <section class="site-section section-map-feature text-center">

            <div class="container">
                <h2>Actualmente existen:</h2>
                <p>En México, la riqueza cultural es inmensa debido a la gran cantidad de civilizaciones y culturas que florecieron en el territorio antes de la llegada de los españoles y que siguen siendo parte de la identidad del país.</p>
                <a href="culturas.php" class="btn btn-fill">Ver Culturas</a>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="counter-item">
                            <p class="counter" data-to="193" data-speed="900">0</p>
                            <h3>Zonas arqueológicas</h3>
                        </div><!-- /.counter-item -->
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="counter-item">
                            <p class="counter" data-to="68" data-speed="900">0</p>       
                            <h3>Lenguas indígenas reconocidas oficialmente</h3>
                        </div> <!-- /.counter-item -->      
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="counter-item">
                            <p class="counter" data-to="71" data-speed="900">0</p>
                            <h3>Pueblos indígenas que México reconoce.</h3>
                        </div><!-- /.counter-item -->
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="counter-item">
                            <p class="counter" data-to="200" data-speed="1000">0</p>
                            <h3>Se estiman más de 200 tribus o grupos prehispánicos</h3>
                        </div><!-- /.counter-item -->
                    </div>
                </div>
            </div>
            
        </section><!-- /.section-map-feature -->

        <section class="site-section section-portfolio">
    <div class="container">
        <div class="text-center">
            <h2 class="heading-separator">Culturas</h2>
            <p class="subheading-text">Da clic en cualquier imagen ver mas información</p>
        </div>
        <div class="row">
            <?php
            // Incluye la conexión y el controlador
            include('model/conexion.php');
            include('controller/culturaCtr.php');

            $culturaController = new CulturaController($conn);
            $resultsPerPage = 6; // Mostrar solo 6 culturas
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            // Obtener las culturas (puedes filtrar si es necesario)
            $culturas = $culturaController->mostrarCulturas($page, $resultsPerPage);
            
            if ($culturas && $culturas->num_rows > 0) {
                while ($row = $culturas->fetch_assoc()) {
                    $idCultura = $row['idCultura'];
                    $nombreCultura = htmlspecialchars($row['nombreCultura']);
                    $imagenCultura = 'assets/img/default-image.jpg'; // Ruta por defecto

                    // Verificar si 'imagenCultura' existe y tiene un valor
                    if (isset($row['imagenCultura']) && !empty($row['imagenCultura'])) {
                        $imagenCultura = 'data:image/jpeg;base64,' . base64_encode($row['imagenCultura']);
                    } 

                    echo '<div class="col-lg-4 col-md-6 col-xs-12">'; // Ajusta las clases para el tamaño
                    echo '<div class="portfolio-item">';
                    echo "<img src='{$imagenCultura}' class='img-res' alt='Imagen de {$nombreCultura}'>";
                    echo "<h4 class='portfolio-item-title'>{$nombreCultura}</h4>";
                    echo "<a href='view/infoCultura.php?idCultura={$idCultura}'><i class='fa fa-arrow-right' aria-hidden='true'></i></a>";
                    echo '</div>'; // /.portfolio-item
                    echo '</div>'; // /.col
                }
            } else {
                echo "<p>No se encontraron culturas.</p>";
            }
            ?>
        </div>
    </div>
</section><!-- /.section-portfolio -->


       

    </main><!-- /#main -->

<?php 

 include('view/modulos/footer.php');   
?>
</body>
</html>
