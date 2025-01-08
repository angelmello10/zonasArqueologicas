<?php 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    echo '<script>
            alert("Para ver tus reservas debes Iniciar Sesión");
            setTimeout(function() {
                window.location.href = "login.php";});
          </script>';
    exit();
}

// Obtener el ID del usuario logueado desde la sesión
$id_usuario = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="es">
<?php include 'modulos/head.php'; ?>
<body>

   <?php 
   include 'modulos/navegador3.php'; 
   include '../model/conexion.php';    
   ?>

    <div id="hero" class="hero overlay subpage-hero contact-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Mis Reservas</h1>
            </div><!-- /.hero-text -->
        </div><!-- /.hero-content -->
    </div><!-- /.hero -->

    <main id="main" class="site-main">

        <section class="site-section subpage-site-section section-contact-us">

            <div class="container">
                <div class="row">
                    <!-- Aquí comienza la sección para mostrar las reservas -->
                    <div class="col-sm-12">
                        <h2>Tus Reservas</h2>
                        <?php
                        // Consulta para obtener las reservas del usuario logueado
                        $sqlReservas = "SELECT r.id, r.nombre, r.telefono, r.fecha_visita, r.hora_visita, r.numero_personas, r.guia, 
                                        r.costo_total, r.estado_reserva, z.nombreZona 
                                        FROM Reservas r 
                                        JOIN ZonasArqueologicas z ON r.idZona = z.idZona
                                        WHERE r.id_usuario = ?";

                        // Preparar la consulta para evitar inyecciones SQL
                        $stmt = $conn->prepare($sqlReservas);
                        $stmt->bind_param("i", $id_usuario);  // Pasar el ID del usuario logueado
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo "<table class='table table-striped table-hover'>";
                            echo "<thead class='thead-dark'>";
                            echo "<tr>";
                            echo "<th>Código de tu reserva</th>";
                            echo "<th>Reserva a nombre de:</th>";
                            echo "<th>Fecha de Visita</th>";
                            echo "<th>Hora de Visita</th>";
                            echo "<th>Número de Personas</th>";
                            echo "<th>Guía turístico</th>";
                            echo "<th>Costo Total</th>";
                            echo "<th>Zona Arqueológica</th>";
                            echo "<th>Estado de Reserva</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            
                            // Recorrer resultados de la consulta
                            while ($fila = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $fila['id'] . "</td>";
                                echo "<td>" . $fila['nombre'] . "</td>";                               
                                echo "<td>" . $fila['fecha_visita'] . "</td>";
                                echo "<td>" . $fila['hora_visita'] . "</td>";
                                echo "<td>" . $fila['numero_personas'] . "</td>";
                                echo "<td>" . ($fila['guia'] == 'si' ? 'Sí' : 'No') . "</td>";
                                echo "<td>$" . number_format($fila['costo_total'], 2) . "</td>";                            
                                echo "<td>" . $fila['nombreZona'] . "</td>";
                                echo "<td>" . ucfirst($fila['estado_reserva']) . "</td>";
                                echo "</tr>";
                            }
                            
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<div class='alert alert-info'>Parece que aún no has realizado ninguna reserva!</div>";
                        }
                        ?>
                       <h5 style="color: blue;">La confirmación se realizará como máximo 24 horas antes de la fecha de tu reserva!</h5>
                    </div>
                    <!-- Aquí termina la sección para mostrar las reservas -->
                </div>
            </div>
        </section>
    </main>

    <?php include 'modulos/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>
