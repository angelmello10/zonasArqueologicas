<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión y si tiene un rol permitido
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'editor') {
    // Mostrar alerta usando JavaScript y redirigir al login
    echo "<script>
        alert('Para acceder inicia sesión como EDITOR.');
        window.location.href = '../view/login.php'; // Redirigir al login
    </script>";
    exit(); // Terminar el script
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Contenido</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/edit.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
</head>
<body>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-sm-12" id="welcomeSection">
    <div class="welcome-section text-center" style="margin-top: 150px; background-color: #f4f6f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-left: 190px">
            <img src="../Adm/Vista/dist/img/logoDash.jpeg" alt="Admin Welcome" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px;">
            <h2 class="fw-bold" style="color: #343a40;">Bienvenido al Panel de Edición</h2>
            <p class="text-muted" style="margin-top: 20px; margin-bottom: 90px;">Aquí podrás gestionar la información de Culturas y Zonas Arqueológicas.</p>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar" style="position: fixed; top: 0; left: 0; height: 100vh; z-index: 1000; overflow-y: auto;">
            <div class="sidebar-sticky">
                <h4 class="text-white text-center py-3">Edición</h4>
                <div class="dropdown">
                    <button class="btn btn-secondary w-100 dropdown-toggle" type="button" id="culturasDropdown" onclick="toggleDropdown()">
                        Culturas
                    </button>
                    <div class="dropdown-menu w-100" id="dropdownMenu" style="display: none;">
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formAgregar')">Agregar</a>
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formEliminar')">Eliminar</a>
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formVerCulturas')">Ver Culturas</a>
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formEditar')">Editar</a>
                    </div>
                </div>
                <br>
            </div>
            <div class="sidebar-sticky">
                <div class="dropdown">
                    <button class="btn btn-primary w-100 dropdown-toggle" type="button" id="zonasDropdown" onclick="toggleDropdownzonas()">
                        Zonas Arqueológicas
                    </button>
                    <div class="dropdown-menu w-100" id="dropdownMenu2" style="display: none;">
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formAgregarZona')">Agregar</a>
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formEliminarZona')">Eliminar</a>
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formVerZonas')">Ver Zonas Arqueológicas</a>
                        <a class="dropdown-item" href="#" onclick="mostrarFormulario('formEditarZonas')">Editar</a>
                    </div>
                </div>
                
                <br>
                <div style="position: relative; min-height: 75vh;">
                    <a href="../index.php" class="btn btn-info w-100" role="button" target="_blank" target="_blank" style="position: absolute; bottom: 0; width: 100%;">Ir a Página Web</a>                
                    <a href="../model/cerrar_sesion.php" class="btn btn-danger" style="position: fixed; top: 10px; right: 10px; z-index: 1000;">Cerrar Sesión</a>

                </div>
            </div>
        </nav>

        <?php include 'form_cultura.php'; ?>
        <?php include 'form_zonas.php'; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById("dropdownMenu");
        dropdownMenu.style.display = dropdownMenu.style.display === "none" ? "block" : "none";
    }
    function toggleDropdownzonas() {
        const dropdownMenu = document.getElementById("dropdownMenu2");
        dropdownMenu.style.display = dropdownMenu.style.display === "none" ? "block" : "none";
    }

    function mostrarFormulario(formId) {
        ocultarWelcomeSection();
        ocultarTodosLosFormularios();
        document.getElementById(formId).style.display = "block";
    }

    function ocultarWelcomeSection() {
        const welcomeSection = document.getElementById('welcomeSection');
        if (welcomeSection) {
            welcomeSection.style.display = 'none';
        }
    }

    function ocultarTodosLosFormularios() {
        const formularios = document.querySelectorAll(".formulario-cultura, .formulario-zonas");
        formularios.forEach(form => form.style.display = "none");
    }
    function cargarDatosCultura(idCultura) {
    // Verifica que se haya seleccionado una cultura
    if (idCultura) {
        // Realizar una solicitud AJAX para obtener los datos de la cultura seleccionada
        fetch('../controller/getCultura.php?idCultura=' + idCultura) // Usamos el archivo correcto para obtener los datos
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Error: " + data.error);
                    alert("Error: " + data.error); // Puedes mostrar un mensaje de error al usuario
                } else {
                    // Rellenar el formulario con los datos obtenidos
                    document.getElementById('idCultura').value = data.idCultura;
                    document.getElementById('nombreCulturaEditar').value = data.nombreCultura;
                    document.getElementById('descripcionEditar').value = data.descripcion;
                    document.getElementById('ubicacionEditar').value = data.ubicacion;
                    document.getElementById('idEstadoEditar').value = data.idEstado;
                    document.getElementById('informacionEditar').value = data.informacion;

                    // Si la cultura tiene una imagen asociada, puedes mostrarla en la vista previa
                    if (data.imagenCultura) {
                        const preview = document.getElementById('previewEdit');
                        preview.src = 'data:image/jpeg;base64,' + data.imagenCultura; // Asumiendo que la imagen se pasa en formato base64
                        preview.style.display = 'block';
                    }

                    // Mostrar el modal de edición
                    $('#modalEditar').modal('show');
                }
            })
            .catch(error => {
                console.error("Error al cargar los datos:", error);
                alert("Ocurrió un error al intentar cargar los datos.");
            });
    } else {
        alert("Por favor, selecciona una cultura válida.");
    }
}
function cargarDatosZona(idZona) {
    // Verifica que se haya seleccionado una zona
    if (idZona) {
        // Realizar una solicitud AJAX para obtener los datos de la zona seleccionada
        fetch('../controller/getZona.php?idZona=' + idZona) // Usamos el archivo correcto para obtener los datos
            .then(response => response.json())
            .then(data => {
                console.log(data); // Para ver los datos completos
                if (data.error) {
                    console.error("Error: " + data.error);
                    alert("Error: " + data.error); // Puedes mostrar un mensaje de error al usuario
                } else {
                    // Rellenar el formulario con los datos obtenidos
                    document.getElementById('idZona').value = data.idZona;
                    document.getElementById('nombreZonaEditar').value = data.nombreZona;
                    document.getElementById('descripcion').value = data.descripcion;
                    document.getElementById('informacion').value = data.informacion;
                    document.getElementById('ubicacion').value = data.ubicacion;
                    document.getElementById('idEstadoEditar').value = data.idEstado;
                    document.getElementById('horarioAperturaEditar').value = data.horarioApertura;
                    document.getElementById('horarioCierreEditar').value = data.horarioCierre;
                    document.getElementById('diasAperturaEditar').value = data.diasApertura;
                    document.getElementById('costoEntradaEditar').value = data.costoEntrada;
                    document.getElementById('latitudEditar').value = data.latitud;
                    document.getElementById('longitudEditar').value = data.longitud;
                    document.getElementById('datosContactoEditar').value = data.datosContacto;
                    document.getElementById('idCultura').value = data.idCultura;

                    // Si la zona tiene una imagen asociada, puedes mostrarla en la vista previa
                    if (data.imagenZona) {
                        const preview = document.getElementById('previewEdit');
                        preview.src = 'data:image/jpeg;base64,' + data.imagenZona; // Asumiendo que la imagen se pasa en formato base64
                        preview.style.display = 'block';
                    }

                    // Mostrar el modal de edición
                    $('#modalEditarZona').modal('show');
                }
            })
            .catch(error => {
                console.error("Error al cargar los datos:", error);
                alert("Ocurrió un error al intentar cargar los datos.");
            });
    } else {
        alert("Por favor, selecciona una zona válida.");
    }
}





</script>
</body>
</html>
