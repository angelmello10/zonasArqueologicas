<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'view/modulos/head.php'; ?>
    <style>
        /* Estilo para la barra de desplazamiento en las listas desplegables */
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }
        .img-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);
        }
    </style>
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
                <li class="dropdown">
                    <a href="#" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cultura</a>
                    <ul class="dropdown-menu">
                        <?php 
                        include('model/conexion.php');
                        $query = "SELECT idCultura, nombreCultura FROM Culturas";
                        $result = $conn->query($query);

                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $idCultura = $row['idCultura'];
                                $cultura = htmlspecialchars($row['nombreCultura']);
                                echo "<li><a href='?idCultura={$idCultura}&page=1' data-group='cultura'>{$cultura}</a></li>";
                            }
                        } else {
                            echo "<li><a href='#'>Error al cargar culturas</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Estado</a>
                    <ul class="dropdown-menu">
                        <?php 
                        $estadoQuery ="SELECT DISTINCT e.idEstado, e.nombreEstado FROM Culturas z JOIN Estados e ON z.idEstado = e.idEstado;";
                        $estadoResult = $conn->query($estadoQuery);

                        if ($estadoResult) {
                            while ($row = $estadoResult->fetch_assoc()) {
                                $idEstado = $row['idEstado'];
                                $estado = htmlspecialchars($row['nombreEstado']);
                                echo "<li><a href='?idEstado={$idEstado}&page=1' data-group='estado'>{$estado}</a></li>";
                            }
                        } else {
                            echo "<li><a href='#'>Error al cargar estados</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="?page=1" class="btn btn-gray active" data-group="all">Limpiar filtro</a></li>
            </ul>
            <br><br>           
            <div class="container">
                <?php
                include('controller/culturaCtr.php');
                $culturaController = new CulturaController($conn);

                $resultsPerPage = 3;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                $idCulturaFiltrar = isset($_GET['idCultura']) ? (int)$_GET['idCultura'] : null;
                $idEstadoFiltrar = isset($_GET['idEstado']) ? (int)$_GET['idEstado'] : null;

                $culturas = $culturaController->mostrarCulturas($page, $resultsPerPage, $idCulturaFiltrar, $idEstadoFiltrar);
                $totalResults = $culturaController->contarCulturas($idCulturaFiltrar, $idEstadoFiltrar);
                $totalPages = ceil($totalResults / $resultsPerPage);

                if ($culturas && $culturas->num_rows > 0) {
                    while ($row = $culturas->fetch_assoc()) {
                        $idCultura = $row['idCultura'];
                        $nombreCultura = htmlspecialchars($row['nombreCultura']);
                        $descripcion = htmlspecialchars($row['descripcion'] ?? 'Descripción no disponible');
                        $fechaCreacion = htmlspecialchars($row['fecha_creacion'] ?? 'Fecha no disponible');
                        $imagenCultura = 'assets/img/default-image.jpg'; // Ruta por defecto

                        // Verificar si 'imagenCultura' existe y tiene un valor
                        if (isset($row['imagenCultura']) && !empty($row['imagenCultura'])) {
                            $imagenCultura = 'data:image/jpeg;base64,' . base64_encode($row['imagenCultura']);
                        } 

                        echo '<article class="blog-post" style="text-align: center;">'; // Centrar el contenido del artículo
                        echo "<h3 class='post-title'>{$nombreCultura}</h3><br>";
                        echo "<p style='color: black; font-size: 18px; text-align: justify;'>{$descripcion}</p><br>";
                        echo "<img src='{$imagenCultura}' class='img-center' alt='Imagen de {$nombreCultura}' width='800' height='200' style='object-fit: contain; width: 50%; height: auto; max-height: 400px;'>";
                        echo "<br><span class='post-author'>Última actualización: {$fechaCreacion}</span><br>";
                        echo '<div class="text-right">';
                        echo "<a class='read-more' href='view/infoCultura.php?idCultura={$idCultura}'><strong>Leer sobre esta cultura</strong></a>";
                        echo '</div>';
                        echo '</article><br>';
                    }
                } else {
                    echo "<p>No se encontraron culturas.</p>";
                }
                ?>
                <div class="ui-pagination mt-50">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <ul class="pagination">
                                <?php if ($page > 1): ?>
                                    <li>
                                        <a href="?page=<?php echo $page - 1; ?>
                                            <?php if ($idCulturaFiltrar !== null) echo "&idCultura=" . $idCulturaFiltrar; ?>
                                            <?php if ($idEstadoFiltrar !== null) echo "&idEstado=" . $idEstadoFiltrar; ?>">
                                            &lt;
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a href="?page=<?php echo $i; ?>
                                            <?php if ($idCulturaFiltrar !== null) echo "&idCultura=" . $idCulturaFiltrar; ?>
                                            <?php if ($idEstadoFiltrar !== null) echo "&idEstado=" . $idEstadoFiltrar; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li>
                                        <a href="?page=<?php echo $page + 1; ?>
                                            <?php if ($idCulturaFiltrar !== null) echo "&idCultura=" . $idCulturaFiltrar; ?>
                                            <?php if ($idEstadoFiltrar !== null) echo "&idEstado=" . $idEstadoFiltrar; ?>">
                                            &gt;
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>               
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'view/modulos/footer.php'; ?>
</body>
</html>
