<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  
                </div>

                <!-- Formulario para agregar nueva cultura -->
                <div id="formAgregar" class="formulario-cultura" style="display: none;">
                    <h4>Añadir Nueva Cultura</h4>
                    <form action="../controller/CulturaController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="accion" value="crear">
                        <div class="form-group">
                            <label for="nombreCultura">Nombre de la Cultura</label>
                            <input type="text" class="form-control" name="nombreCultura" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Información sobre su ubicación</label>
                            <textarea class="form-control" name="ubicacion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="idEstado">Estado Principal</label>
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
                            <label for="informacion">Información</label>
                            <textarea class="form-control" name="informacion" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagenCultura">Imagen</label>
                            <input type="file" class="form-control" name="imagenCultura" id="imagenCultura" accept="image/*" onchange="previewImage(event)">
                        </div>
                        <div class="form-group">
                            <img id="preview" src="#" alt="Vista previa de la imagen" style="display: none; width: 200px; margin-top: 10px;">
                        </div>
                        <button type="submit" class="btn btn-primary">Añadir Cultura</button>
                    </form>
                </div>

                <!-- Formulario para ver culturas -->
                <div id="formVerCulturas" class="formulario-cultura" style="display: none;">
                    <h4>Ver Culturas Añadidas</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Ubicación</th>
                                <th>Información</th>
                                <th>Estado</th>
                                <th>Imagen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Modificando la consulta para obtener el nombre del estado
                            $query = "
                                SELECT c.idCultura, c.nombreCultura, c.descripcion, c.ubicacion, c.informacion, c.imagenCultura, e.nombreEstado
                                FROM Culturas c
                                JOIN Estados e ON c.idEstado = e.idEstado
                            ";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['idCultura']}</td>
                                        <td>" . htmlspecialchars($row['nombreCultura']) . "</td>
                                        <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                        <td>" . htmlspecialchars($row['ubicacion']) . "</td>
                                        <td>" . htmlspecialchars($row['informacion']) . "</td>
                                        <td>" . htmlspecialchars($row['nombreEstado']) . "</td>
                                        <td><img src='data:image/jpeg;base64," . base64_encode($row['imagenCultura']) . "' alt='Imagen' style='width: 50px;'></td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Formulario para eliminar cultura -->
                <div id="formEliminar" class="formulario-cultura" style="display: none;">
                                <h4>Eliminar Cultura</h4>
                                <form id="formEliminarCultura" action="../controller/CulturaController.php" method="POST" onsubmit="return confirmarEliminacion();">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <div class="form-group">
                                        <label for="idCulturaEliminar">Seleccionar Cultura</label>
                                        <select class="form-control" name="idCulturaEliminar" required>
                                            <option value="">Seleccione una Cultura</option>
                                            <?php
                                            $query = "SELECT idCultura, nombreCultura FROM Culturas";
                                            $result = $conn->query($query);
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['idCultura']}'>" . htmlspecialchars($row['nombreCultura']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Eliminar Cultura</button>
                                </form>
                    </div>

                                <script>
                    function confirmarEliminacion() {
                            return confirm('¿Estás seguro de que deseas eliminar esta cultura?');
                                }
                    </script>


                <!-- Formulario para editar cultura -->
                <div id="formEditar" class="formulario-cultura" style="display: none;">
                    <h4>Editar Cultura</h4>
                    <div class="form-group">
                        <label for="idCulturaEditar">Seleccionar Cultura</label>
                        <select class="form-control" id="selectCultura" onchange="cargarDatosCultura(this.value)" required>
                            <option value="">Seleccione una Cultura</option>
                            <?php
                            $query = "SELECT idCultura, nombreCultura FROM Culturas";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['idCultura']}'>" . htmlspecialchars($row['nombreCultura']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar">Editar Cultura</button>
                </div>

            <!-- Modal para editar cultura -->
                    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditarLabel">Editar Cultura</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formEditarCultura" action="../controller/CulturaController.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="accion" value="editar">
                                        <input type="hidden" id="idCultura" name="idCultura" value="">
                                        <div class="form-group">
                                            <label for="nombreCulturaEditar">Nombre de la Cultura</label>
                                            <input type="text" class="form-control" id="nombreCulturaEditar" name="nombreCultura" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcionEditar">Descripción</label>
                                            <textarea class="form-control" id="descripcionEditar" name="descripcion"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="ubicacionEditar">Ubicación</label>
                                            <textarea class="form-control" id="ubicacionEditar" name="ubicacion"></textarea>
                                        </div>
                                       <div class="form-group">
                                            <label for="idEstadoEditar">Estado Principal</label>
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
                                            <label for="informacionEditar">Información</label>
                                            <textarea class="form-control" id="informacionEditar" name="informacion" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="imagenCulturaEditar">Imagen (opcional)</label>
                                            <input type="file" class="form-control" name="imagenCulturaEditar" id="imagenCulturaEditar" accept="image/*" onchange="previewImageEdit(event)">
                                        </div>
                                        <div class="form-group">
                                            <img id="previewEdit" src="#" alt="Vista previa de la imagen" style="display: none; width: 200px; margin-top: 10px;">
                                        </div>
                                        <button type="submit" class="btn btn-success">Actualizar Cultura</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    