
                <div id="formAgregarZona" class="formulario-zonas" style="display: none;">
                    <center>
                        <h5>Añadir Nueva Zona Arqueológica</h5>
                    </center>
                    <form action="../controller/ZonasController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="accion" value="crear">
                        <div class="form-group">
                            <label for="nombreZona">Nombre de la Zona Arqueológica</label>
                            <input type="text" class="form-control" name="nombreZona" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="informacion">Información</label>
                            <textarea class="form-control" name="informacion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="idEstado">Estado en el que se encuentra la zona:</label>
                            <select class="form-control" name="idEstado" required>
                                <option value="">Seleccione un Estado</option>
                                <?php
                                include '../model/conexion.php';
                                $query = "SELECT idEstado, nombreEstado FROM Estados";
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['idEstado']}'>{$row['nombreEstado']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="horarioApertura">Hora de Apertura:</label>
                            <input type="time" id="horarioApertura" name="horarioApertura" required>
                            <label for="horarioCierre">Hora de Cierre:</label>
                            <input type="time" id="horarioCierre" name="horarioCierre" required>
                        </div>
                        <!-- Horario de L a V-->
                        <div class="form-group">
                            <h6>Horario</h6>
                            <label for="diasAperturaInicio">De:</label>
                            <select id="diasAperturaInicio" name="diasAperturaInicio" required>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                            <label for="diasAperturaFin"> - </label>
                            <select id="diasAperturaFin" name="diasAperturaFin" required>
                                <option value="Lunes">a Lunes</option>
                                <option value="Martes">a Martes</option>
                                <option value="Miércoles">a Miércoles</option>
                                <option value="Jueves">a Jueves</option>
                                <option value="Viernes">a Viernes</option>
                                <option value="Sábado">a Sábado</option>
                                <option value="Domingo">a Domingo</option>
                            </select>
                            <input type="hidden" id="diasApertura" name="diasApertura">
                        </div>
                        <script>
                                // Capturar los valores de ambos select y concatenarlos
                                document.getElementById("diasAperturaInicio").addEventListener("change", actualizarDiasApertura);
                                document.getElementById("diasAperturaFin").addEventListener("change", actualizarDiasApertura);

                                function actualizarDiasApertura() {
                                    const inicio = document.getElementById("diasAperturaInicio").value;
                                    const fin = document.getElementById("diasAperturaFin").value;
                                    document.getElementById("diasApertura").value = inicio + " a " + fin;
                                }
                        </script>
                        <div class="form-group">
                            <label for="costoEntrada">Ingresa la información sobre los costos $</label>
                            <textarea class="form-control" name="costoEntrada"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Dirección de la Zona Arqueológica</label>
                            <textarea class="form-control" name="ubicacion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagenZona">Imagen de la Zona</label>
                            <input type="file" class="form-control" name="imagenZona" id="imagenZona" accept="image/*" onchange="previewImage(event)">
                        </div>
                        <div class="form-group">
                            <img id="preview" src="#" alt="Vista previa de la imagen" style="display: none; width: 200px; margin-top: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="idCultura">Cultura a la que pertenece:</label>
                            <select class="form-control" name="idCultura" required>
                                <option value="">Selecciona una Cultura</option>
                                <?php
                                include '../model/conexion.php';
                                $query = "SELECT idCultura, nombreCultura FROM Culturas";
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['idCultura']}'>{$row['nombreCultura']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="datosContacto">Ingresa la información de contacto</label>
                            <textarea class="form-control" name="datosContacto"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="latitud">Ingresa la latitud</label>
                            <textarea class="form-control" name="latitud"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="longitud">Ingresa la longitud</label>
                            <textarea class="form-control" name="longitud"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Añadir Zona</button>
                    </form>
                </div>

                <div id="formVerZonas" class="formulario-zonas" style="display: none;">
                    <h4>Ver Zonas Arqueológicas Añadidas</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Información</th>
                                <th>Estado</th>
                                <th>Horario de Apertura</th>
                                <th>Hora de Cierre</th>
                                <th>Días de Apertura</th>
                                <th>Costo de entrada</th>
                                <th>Ubicación</th>
                                <th>Imagen</th>
                                <th>Cultura</th>
                                <th>Fecha de edición</th>
                                <th>Datos de Contacto</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Modificando la consulta para obtener el nombre del estado
                            $query = "
                                SELECT 
                                    z.idZona, 
                                    z.nombreZona, 
                                    z.descripcion, 
                                    z.informacion, 
                                    z.horarioApertura, 
                                    z.horarioCierre, 
                                    z.diasApertura, 
                                    z.costoEntrada, 
                                    z.ubicacion, 
                                    z.imagenZona,
                                    z.fecha_creacion, 
                                    z.datosContacto, 
                                    z.latitud, 
                                    z.longitud, 
                                    e.nombreEstado,
                                    c.nombreCultura
                                FROM 
                                    ZonasArqueologicas z
                                JOIN 
                                    Estados e ON z.idEstado = e.idEstado
                                JOIN 
                                    Culturas c ON z.idCultura = c.idCultura;
                            ";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['idZona']}</td>
                                        <td>" . htmlspecialchars($row['nombreZona']) . "</td>
                                        <td>" . htmlspecialchars(substr($row['descripcion'], 0, 100)) . "...</td>
                                        <td>" . htmlspecialchars(substr($row['informacion'], 0, 100)) . "...</td>
                                        <td>" . htmlspecialchars(substr($row['nombreEstado'], 0, 100)) . "...</td>
                                        <td>" . htmlspecialchars($row['horarioApertura']) . "</td>
                                        <td>" . htmlspecialchars($row['horarioCierre']) . "</td>                                   
                                        <td>" . htmlspecialchars($row['diasApertura']) . "</td>
                                        <td>" . htmlspecialchars(substr($row['costoEntrada'], 0, 100)) . "</td>
                                        <td>" . htmlspecialchars($row['ubicacion']) . "</td>
                                        <td><img src='data:image/jpeg;base64," . base64_encode($row['imagenZona']) . "' alt='Imagen' style='width: 50px;'></td>
                                        <td>" . htmlspecialchars($row['nombreCultura']) . "</td>  
                                        <td>" . htmlspecialchars($row['fecha_creacion']) . "</td>
                                        <td>" . htmlspecialchars($row['datosContacto']) . "</td>  
                                        <td>" . htmlspecialchars($row['latitud']) . "</td>
                                        <td>" . htmlspecialchars($row['longitud']) . "</td>                                                                 
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

        
                <div id="formEliminarZona" class="formulario-zonas" style="display: none;">
                    <h4>Eliminar Cultura</h4>
                    <form id="formEliminarZona" action="../controller/ZonasController.php" method="POST" onsubmit="return confirmarEliminacion();">
                        <input type="hidden" name="accion" value="eliminar">
                        <div class="form-group">
                            <label for="idZonaEliminar">Seleccionar Cultura</label>
                            <select class="form-control" name="idZonaEliminar" required>
                                <option value="">Seleccione una Cultura</option>
                                <?php
                                $query = "SELECT idZona, nombreZona FROM ZonasArqueologicas";
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['idZona']}'>" . htmlspecialchars($row['nombreZona']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Eliminar Cultura</button>
                    </form>
                </div>

                <script>
                    function confirmarEliminacion() {
                        return confirm('¿Estás seguro de que deseas eliminar esta Zona?');
                    }
                </script>


                <!-- Formulario para editar  -->
                <div id="formEditarZonas" class="formulario-zonas" style="display: none;">
                    <h4>Editar Zona</h4>
                    <div class="form-group">
                        <label for="idZonaEditar">Seleccionar Zona Arqueológica</label>
                        <select class="form-control" id="selectZona" onchange="cargarDatosZona(this.value)" required>
                            <option value="">Seleccione una Zona</option>
                            <?php
                            $query = "SELECT idZona, nombreZona FROM ZonasArqueologicas";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['idZona']}'>" . htmlspecialchars($row['nombreZona']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarZona">Editar Zona</button>
                </div>


                <!-- Modal para editar zona -->
                <div class="modal fade" id="modalEditarZona" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditarLabel">Editar Zona</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditarZona" action="../controller/ZonasController.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="accion" value="editar">
                                    <input type="hidden" id="idZona" name="idZona" value="">
                                    <div class="form-group">
                                        <label for="nombreZonaEditar">Nombre de la Zona arqueológica</label>
                                        <input type="text" class="form-control" id="nombreZonaEditar" name="nombreZona" required>
                                    </div>
                                     <div class="form-group">
                                        <label for="descripcionEditar">Descripción</label>
                                         <input class="form-control" id="descripcion" name="descripcion" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="informacionEditar">Información de la Zona</label>
                                        <textarea class="form-control" id="informacion" name="informacion" required></textarea>
                                    </div>                                   
                                    <div class="form-group">
                                        <label for="idEstadoEditar">Estado donde se encuentra</label>
                                        <select class="form-control" id="idEstadoEditar" name="idEstado" required>
                                            <option value="">Seleccione un Estado</option>
                                            <?php
                                            $query = "SELECT idEstado, nombreEstado FROM Estados";
                                            $result = $conn->query($query);
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['idEstado']}'>{$row['nombreEstado']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="ubicacionEditar">Ubicación</label>
                                        <textarea class="form-control" id="ubicacion" name="ubicacion"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="idCultura">Cultura</label>
                                        <select class="form-control" id="idCulturaEditar" name="idCultura" required>
                                            <option value="">Seleccione una Cultura</option>
                                            <?php
                                            $query = "SELECT idCultura, nombreCultura FROM Culturas";
                                            $result = $conn->query($query);
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['idCultura']}'>{$row['nombreCultura']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="horarioAperturaEditar">Horario de apertura</label>
                                        <input type="time" class="form-control" id="horarioAperturaEditar" name="horarioApertura" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="horarioCierreEditar">Horario de cierre</label>
                                        <input type="time" class="form-control" id="horarioCierreEditar" name="horarioCierre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="diasAperturaEditar">Días de apertura</label>
                                        <input type="text" class="form-control" id="diasAperturaEditar" name="diasApertura" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="costoEntradaEditar">Costo de entrada</label>
                                        <input type="text" class="form-control" id="costoEntradaEditar" name="costoEntrada" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="latitudEditar">Latitud</label>
                                        <input type="text" class="form-control" id="latitudEditar" name="latitud" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="longitudEditar">Longitud</label>
                                        <input type="text" class="form-control" id="longitudEditar" name="longitud" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="datosContactoEditar">Datos de contacto</label>
                                        <input type="text" class="form-control" id="datosContactoEditar" name="datosContacto" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagenCulturaEditar">Imagen (opcional)</label>
                                        <input type="file" class="form-control" name="imagenCulturaEditar" id="imagenCulturaEditar" accept="image/*" onchange="previewImageEdit(event)">
                                    </div>
                                    <div class="form-group">
                                        <img id="previewEdit" src="#" alt="Vista previa de la imagen" style="display: none; width: 200px; margin-top: 10px;">
                                    </div>
                                    <button type="submit" class="btn btn-success">Actualizar Zona</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>