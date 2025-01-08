<!DOCTYPE html>
<html lang="en">
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
<?php
include('view/modulos/head.php');
include('model/conexion.php');

// Obtener estados y culturas
$estadosQuery = "SELECT DISTINCT e.idEstado, e.nombreEstado FROM ZonasArqueologicas z JOIN estados e ON z.idEstado = e.idEstado;";
$estadosResult = $conn->query($estadosQuery);

$culturasQuery = "SELECT idCultura, nombreCultura FROM Culturas";
$culturasResult = $conn->query($culturasQuery);

// Obtener zonas arqueológicas con filtros
$idEstado = isset($_GET['estado']) ? (int)$_GET['estado'] : 0;
$idCultura = isset($_GET['cultura']) ? (int)$_GET['cultura'] : 0;

$query = "
    SELECT z.idZona, z.nombreZona, z.imagenZona, e.nombreEstado 
    FROM ZonasArqueologicas z
    JOIN Estados e ON z.idEstado = e.idEstado
    WHERE 1=1";

if ($idEstado > 0) {
    $query .= " AND z.idEstado = $idEstado";
}
if ($idCultura > 0) {
    $query .= " AND z.idCultura = $idCultura";
}

$result = $conn->query($query);
?>
<body>
    <?php include('view/modulos/navegador2.php'); ?>

    <div id="hero" class="hero overlay subpage-hero portfolio-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Zonas Arqueológicas</h1>
            </div>
        </div>
    </div>

    <main id="main" class="site-main">
        <section class="site-section subpage-site-section section-portfolio">
            <div class="container">
                <ul class="portfolio-sorting list-inline text-center">
                    <span>Filtrar por:</span>
                    
                    <li class="dropdown">
                        <a href="#" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Estados</a>
                        <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                            <?php while ($estado = $estadosResult->fetch_assoc()): ?>
                                <li><a href="?estado=<?php echo $estado['idEstado']; ?>&cultura=<?php echo $idCultura; ?>"><?php echo $estado['nombreEstado']; ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Culturas</a>
                        <ul class="dropdown-menu">
                            <?php while ($cultura = $culturasResult->fetch_assoc()): ?>
                                <li><a href="?cultura=<?php echo $cultura['idCultura']; ?>&estado=<?php echo $idEstado; ?>"><?php echo $cultura['nombreCultura']; ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                    <li><a href="zonasArq.php" class="btn btn-gray" data-group="all">Ver todo</a></li>
                </ul>

                <div class="row">
                    <?php
                    // Verificar si se obtuvieron resultados
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Crear una URL para la imagen
                            $imagen = 'data:image/jpeg;base64,' . base64_encode($row['imagenZona']); // Ajusta el tipo de imagen si es necesario

                            echo '<div class="col-lg-3 col-md-4 col-xs-6" data-groups="[\'webdesign\']" id="zona-' . $row['idZona'] . '">';
                            echo '    <div class="portfolio-item">';
                            echo '        <img src="' . $imagen . '" class="img-res" alt="Imagen de ' . htmlspecialchars($row['nombreZona']) . '">';
                            echo '        <h4 class="portfolio-item-title">' . htmlspecialchars($row['nombreZona']) . '</h4>';
                            echo '        <p><strong>Estado:</strong> ' . htmlspecialchars($row['nombreEstado']) . '</p>'; // Aquí se muestra el estado
                            echo '        <a href="view/infoZona.php?id=' . $row['idZona'] . '"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
                            echo '        <input type="hidden" class="idZona" value="' . $row['idZona'] . '">';
                            echo '    </div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No se encontraron zonas arqueológicas.</p>';
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </div>

                

            </div>
        </section>

    </main>

    <?php include('view/modulos/footer.php'); ?>

</body>
</html>
