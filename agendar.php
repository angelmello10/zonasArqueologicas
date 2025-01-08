<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1); 
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    echo '<script>
            alert("Para agendar una visita primero debes Iniciar Sesión");
            setTimeout(function() {
                window.location.href = "view/login.php";
            });
          </script>';
    exit();
}

// Obtenemos el ID del usuario logueado desde la sesión
$id_usuario = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="es">
<?php include 'view/modulos/head.php'; ?>
<body>

   <?php 
   include 'view/modulos/navegador2.php';
   include 'model/conexion.php';    
   ?>

    <div id="hero" class="hero overlay subpage-hero contact-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Agenda una visita</h1>
            </div>
        </div>
    </div>

    <main id="main" class="site-main">

        <section class="site-section subpage-site-section section-contact-us">

            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <h2>Reservación</h2>

                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Recogemos los datos del formulario
                            $nombre = $_POST['nombre'];
                            $telefono = $_POST['telefono'];
                            $fechaVisita = $_POST['fechaVisita'];
                            $horaVisita = $_POST['horaVisita'];
                            $numeroPersonas = $_POST['numeroPersonas'];
                            $guia = $_POST['guia'];
                            $zonaId = $_POST['zona'];
                            $costoTotal = $numeroPersonas * 100;
                            $estadoReserva = 'pendiente';

                            // Obtener el nombre de la zona arqueológica
                            $sqlZona = "SELECT nombreZona FROM ZonasArqueologicas WHERE idZona = ?";
                            $stmtZona = $conn->prepare($sqlZona);
                            $stmtZona->bind_param("i", $zonaId);
                            $stmtZona->execute();
                            $stmtZona->bind_result($nombreZona);
                            $stmtZona->fetch();
                            $stmtZona->close();

                            if (isset($_POST['confirmar'])) {
                                // Consulta para insertar la reserva, incluyendo `id_usuario`
                                $sql = "INSERT INTO reservas (nombre, telefono, fecha_visita, hora_visita, numero_personas, guia, costo_total, estado_reserva, idZona, id_usuario) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("ssssisssii", $nombre, $telefono, $fechaVisita, $horaVisita, $numeroPersonas, $guia, $costoTotal, $estadoReserva, $zonaId, $id_usuario);

                                if ($stmt->execute()) {
                                    echo "<div class='alert alert-success'>¡Reserva realizada con éxito! - En espera de confirmación</div>";
                                    echo "<h4>Detalles de tu reserva:</h4>";
                                    echo "<h5>Nombre: $nombre</h5>";
                                    echo "<h5>Teléfono: $telefono</h5>";
                                    echo "<h5>Fecha de la visita: $fechaVisita</h5>";
                                    echo "<h5>Hora de la visita: $horaVisita</h5>";
                                    echo "<h5>Número de personas: $numeroPersonas</h5>";
                                    echo "<h5>Zona arqueológica: $nombreZona</h5>";
                                    echo "<h5>Costo total: $" . number_format($costoTotal, 2) . "</h5>";
                                    echo '<div class="text-center">
                                            <a href="view/reservas.php" class="btn btn-fill mb-10">Ir a Mis reservas</a>
                                            <a href="index.php" class="btn btn-fill mb-10">Ir a Inicio</a>
                                          </div>';
                                } else {
                                    echo "<div class='alert alert-danger'>Error en la reserva: " . $stmt->error . "</div>";
                                }

                                $stmt->close();
                            } else {
                                // Mostrar el resumen para confirmación
                                echo "<h4>Costo total: $" . number_format($costoTotal, 2) . "</h4>";
                                echo "<h5>Nombre: $nombre</h5>";
                                echo "<h5>Teléfono: $telefono</h5>";
                                echo "<h5>Fecha de la visita: $fechaVisita</h5>";
                                echo "<h5>Hora de la visita: $horaVisita</h5>";
                                echo "<h5>Número de personas: $numeroPersonas</h5>";
                                echo "<h5>Zona arqueológica: $nombreZona</h5>";

                                echo "<form method='POST' action=''>";
                                echo "<input type='hidden' name='nombre' value='" . htmlspecialchars($nombre, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='telefono' value='" . htmlspecialchars($telefono, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='fechaVisita' value='" . htmlspecialchars($fechaVisita, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='horaVisita' value='" . htmlspecialchars($horaVisita, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='numeroPersonas' value='" . htmlspecialchars($numeroPersonas, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='guia' value='" . htmlspecialchars($guia, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='zona' value='" . htmlspecialchars($zonaId, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='nombreZona' value='" . htmlspecialchars($nombreZona, ENT_QUOTES) . "'>";
                                echo "<input type='hidden' name='costoTotal' value='" . htmlspecialchars($costoTotal, ENT_QUOTES) . "'>";
                                echo "<button type='submit' name='confirmar' class='btn btn-fill mb-10'>Confirmar Reserva</button>";
                                echo "<a href='agendar.php' class='btn btn-border mb-10'>Regresar</a>";
                                echo "</form>";
                            }
                        } else {
                        ?>

                        <!-- Formulario de reserva -->
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" placeholder="A este nombre se registra la reserva" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" placeholder="10 dígitos" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="form-group">
                                <label for="fechaVisita">Fecha de la visita:</label>
                                <input type="date" class="form-control" id="fechaVisita" name="fechaVisita" required>
                            </div>
                            <div class="form-group">
                                <label for="horaVisita">Hora de la visita:</label>
                                <input type="time" class="form-control" id="horaVisita" name="horaVisita" required>
                            </div>
                            <div class="form-group">
                                <label for="numeroPersonas">Número de personas:</label>
                                <input type="number" class="form-control" id="numeroPersonas" name="numeroPersonas" min="1" required>
                            </div>

                            <div class="col-sm-12">
                                <select class="selectpicker" id="guia" name="guia" required>
                                    <option value="" disabled selected>¿Requieres un guía oficial?</option>                                 
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                           
                            <div class="col-sm-12">
                                <select class="selectpicker" name="zona" required>
                                    <option value="" disabled selected>Selecciona una Zona Arqueológica: </option>
                                    <?php
                                    $resultado = $conn->query("SELECT idZona, nombreZona FROM ZonasArqueologicas");
                                    while ($fila = $resultado->fetch_assoc()) {
                                        echo "<option value='" . $fila['idZona'] . "'>" . htmlspecialchars($fila['nombreZona'], ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>                            
                            </div>                          
                            <div class="text-center">
                                <button type="submit" class="btn btn-fill mb-10">Continuar</button>
                            </div>
                        </form>
                        <?php
                        }
                        ?>

                    </div>
                    <div class="col-sm-5">
                        <div class="contact-info">
                            <h2>Información importante:</h2>
                            <p style="font-size: 1.2em; color: black;">- El guía se te asignará al momento de tu llegada y lo conocerás en recepción.</p>
                            <p style="font-size: 1.2em; color: black;">- Una vez completada la reservación deberás dirigirte a la sección de Mis Reservas para ver el estado de tu reservación.</p>
                            <p style="font-size: 1.2em; color: black;">- Costo por persona $100 Entrada General.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php include 'view/modulos/footer.php'; ?>

</body>
</html>
