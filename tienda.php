<?php 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <?php include 'view/modulos/head.php'; ?>
        <style>
        /* Estilos para los libros */

        .portfolio-item {
            position: relative;
            overflow: hidden;
            text-align: center;
            margin-bottom: 30px; /* Espacio entre las tarjetas */
            border: 1px solid #ddd; /* Borde alrededor de las tarjetas */
            border-radius: 5px; /* Bordes redondeados */
            transition: box-shadow 0.3s; /* Transición suave para sombra */
        }

        .portfolio-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra al pasar el mouse */
        }

        .portfolio-item img {
            width: 100%; /* Imagen ocupa el 100% del contenedor */
            height: auto; /* Mantiene la proporción */
            transition: transform 0.3s; /* Transición suave para la imagen */
        }

        .portfolio-item:hover img {
            transform: scale(1.1); /* Efecto de zoom al pasar el mouse */
        }

        .info {
            position: absolute;
            bottom: 0; /* Posiciona la información en la parte inferior */
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7); /* Fondo semi-transparente */
            color: white; /* Color del texto */
            padding: 15px; /* Espaciado interno */
            opacity: 0; /* Inicialmente oculto */
            transition: opacity 0.3s; /* Transición suave para la opacidad */
        }

        .portfolio-item:hover .info {
            opacity: 1; /* Muestra la información al pasar el mouse */
        }

        .portfolio-item-title {
            margin: 0; /* Sin margen para el título */
        }

        .portfolio-item-price,
        .portfolio-item-author {
            margin: 5px 0; /* Espaciado para el precio y autor */
        }

        .portfolio-item a {
            display: inline-block; /* Asegura que el enlace sea un bloque */
            margin-top: 10px; /* Espaciado superior */
            background: #0d6efd; /* Color de fondo para el botón */
            color: white; /* Color del texto */
            padding: 10px 15px; /* Espaciado */
            border-radius: 5px; /* Bordes redondeados */
            text-decoration: none; /* Sin subrayado */
            transition: background 0.3s; /* Transición suave para el hover */
        }

        .portfolio-item a:hover {
            background: #0056b3; /* Cambia el fondo al pasar el mouse */
        }

        #hero {
    background-image: url('assets/img/banner-tienda.jpg'); /* Cambia esta ruta a tu nueva imagen */
    background-size: cover;
    background-position: center;
    height: 400px; /* Ajusta según sea necesario */
}

#cartModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            padding: 20px;
        }
        #cartModalHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
        }
        #cartItems {
            list-style: none;
            padding: 0;
            max-height: 300px;
            overflow-y: auto;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 900;
        }
        .modal-footer { text-align: right; }
        .modal-footer button { padding: 10px; cursor: pointer; 
        
        }

        .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Ajusta la opacidad aquí */
    display: none;
    z-index: 900;
}

.modal {
    background-color: #fff; /* Asegúrate de que el fondo del modal sea blanco */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Sombra para el modal */
}

/* Estilos para el modal de cantidad */
#quantityModal {
    display: none; /* Por defecto, el modal está oculto */
    position: fixed; /* Posicionamiento fijo para que permanezca en su lugar */
    top: 50%; /* Centrado verticalmente */
    left: 50%; /* Centrado horizontalmente */
    transform: translate(-50%, -50%); /* Centrado usando transformación */
    width: 80%; /* Ancho del modal */
    max-width: 400px; /* Ancho máximo del modal */
    background-color: #fff; /* Color de fondo */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Sombra para el modal */
    z-index: 1000; /* Z-index alto para que se superponga a otros elementos */
    padding: 20px; /* Espaciado interno */
}

#cartModalHeader {
    display: flex; /* Flexbox para alinear el contenido */
    justify-content: space-between; /* Espacio entre los elementos */
    align-items: center; /* Alinear verticalmente al centro */
    font-size: 1.5em; /* Tamaño de fuente para el título */
    font-weight: bold; /* Negrita para el título */
    color: #333; /* Color del texto */
}

.modal-body {
    margin-top: 10px; /* Margen superior para separar del header */
}

.modal-footer {
    text-align: right; /* Alinear el texto del footer a la derecha */
}

.modal-footer button {
    padding: 10px; /* Espaciado interno para los botones */
    cursor: pointer; /* Cambiar cursor a puntero */
}

/* Estilos para la superposición del modal */
.modal-overlay {
    position: fixed; /* Posicionamiento fijo */
    top: 0; /* Cubrir todo desde la parte superior */
    left: 0; /* Cubrir todo desde la parte izquierda */
    width: 100%; /* Ancho total */
    height: 100%; /* Altura total */
    background: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
    display: none; /* Oculto por defecto */
    z-index: 900; /* Z-index ligeramente menor que el modal */
}

/* Estilos para el input de cantidad */
input[type="number"] {
    width: 100%; /* Ancho total del input */
    padding: 10px; /* Espaciado interno */
    border: 1px solid #ccc; /* Borde gris */
    border-radius: 4px; /* Bordes redondeados */
    margin-top: 10px; /* Margen superior */
}


        
    </style>
</head>
<body>
    <?php include 'view/modulos/navegador2.php'; ?>

    <div id="hero" class="hero overlay subpage-hero blog-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>TIENDA</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Tienda</li>
                </ol>
            </div><!-- /.hero-text -->
        </div><!-- /.hero-content -->
    </div><!-- /.hero -->

    <!-- Libros -->
<?php
    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'tienda1');

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consultar los libros
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);
?>

<div style="text-align: right; margin-bottom: 20px;"> <!-- Contenedor alineado a la derecha -->
    <button class="btn btn-light text-primary" id="cartButton">
        <i class="fas fa-shopping-cart"></i>
    </button>
</div>



<div id="cartModal">
    <div id="cartModalHeader">
        <span>Carrito de Compras</span>
        <button onclick="closeCart()">✖</button>
    </div>
    <ul id="cartItems" class="list-group mb-3"></ul>
    <div class="modal-footer">
    <button class="btn btn-light text-primary" onclick="buyNow()">Comprar Ahora</button>
        <button class="btn btn-light text-primary" onclick="clearCart()">Vaciar Carrito</button>
    </div>
</div>
<div class="modal-overlay" onclick="closeCart()"></div>

<!-- Modal para ingresar la cantidad -->
<div id="quantityModal" class="modal">
    <div id="cartModalHeader">
        <span>Cantidad</span>
        <button onclick="closeQuantityModal()">✖</button>
    </div>
    <div class="modal-body">
        <label for="quantity">Ingrese la cantidad:</label>
        <input type="number" id="quantity" class="form-control" value="1" min="1">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light text-primary" id="confirmAddToCart">Añadir al carrito</button>
    </div>
</div>
<div class="modal-overlay" onclick="closeQuantityModal()"></div>



<section class="site-section section-portfolio">
    <div class="container">
        <div class="text-center">
            <h2 class="heading-separator">Nuestros Productos</h2>
            <p class="subheading-text">Explora los Productos más Interesantes de Nuestras Culturas Magnificas</p>
        </div>
        <div class="row">
            <?php
           if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Convertir el BLOB a una cadena base64
                $imagenBase64 = base64_encode($row["foto"]);
                $tipoImagen = 'image/jpeg'; // Cambia esto si tus imágenes son de otro tipo
        
                echo '<div class="col-lg-3 col-md-4 col-xs-6">';
                echo '<div class="portfolio-item">';
                echo '<img src="data:' . $tipoImagen . ';base64,' . $imagenBase64 . '" class="img-res" alt="' . $row["categoria"] . '">';
                echo '<div class="info">'; // Contenedor para la información
                echo '<p class="portfolio-item-author">' . $row["categoria"] . '</p>';
                echo '<p class="portfolio-item-price">$' . $row["precio"] . '</p>'; // Precio
                echo '<p class="portfolio-item-author">' . $row["descripcion"] . '</p>'; // Autor
                echo '</div>'; // Cierra info
                echo '</div><!-- /.portfolio-item -->';
                echo '<button class="btn btn-light text-primary add-to-cart" 
                    data-id="' . $row['productoID'] . '" 
                    data-title="' . $row['categoria'] . '" 
                    data-price="' . $row['precio'] . '">Añadir al carrito</button>'; // Botón de añadir al carrito
                echo '</div>'; // Cierra col
            }
        } else {
            echo '<p>No hay libros disponibles.</p>';
        }
            ?>
        </div>
    </div>
</section><!-- /.section-portfolio -->


<?php 
    // Cerrar conexión
    $conn->close();
    ?>   
</section>
<?php include 'view/modulos/footer.php'; ?>


<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    // Variables del carrito y elementos HTML
    let cart = [];
    const cartModal = document.getElementById('cartModal');
    const quantityModal = document.getElementById('quantityModal');
    const cartButton = document.getElementById('cartButton');
    const overlay = document.querySelector('.modal-overlay');

    function buyNow() {
        if (cart.length === 0) {
            alert('El carrito está vacío. Agrega productos antes de comprar.');
            return;
        }

        // Crea una cadena con los IDs de los productos en el carrito
        // Modifica la parte donde se redirige a detalle_compra.php
const productIds = cart.map(item => `${item.id}:${item.quantity}`).join(','); // Cambia esto


        // Redirige a detalle_compra.php pasando los IDs
        window.location.href = `detalle_compra.php?ids=${productIds}`;
    }

    function updateCartModal() {
        const cartItems = document.getElementById('cartItems');
        cartItems.innerHTML = ''; 
        let totalPrice = 0; // Inicializa el total de precios
        let totalQuantity = 0; // Inicializa el total de cantidad

        cart.forEach(item => {
            const li = document.createElement('li');
            li.textContent = `${item.title} - $${item.price} (Cantidad: ${item.quantity})`; // Muestra la cantidad
            cartItems.appendChild(li);
            totalPrice += parseFloat(item.price); // Sumar al total el precio del artículo
            totalQuantity += parseInt(item.quantity); // Sumar al total la cantidad
        });

        // Mostrar el total de productos y el total del precio
        const totalDiv = document.createElement('div');
        totalDiv.innerHTML = `<strong>Total de Productos: ${totalQuantity}</strong><br>
                              <strong>Total Precio: $${totalPrice.toFixed(2)}</strong>`;
        cartItems.appendChild(totalDiv); // Agregar al final de la lista
    }

    // Función para abrir el modal del carrito
    function openCart() {
        cartModal.style.display = 'block';
        overlay.style.display = 'block';
        updateCartModal();
    }

    // Función para cerrar el modal del carrito
    function closeCart() {
        cartModal.style.display = 'none';
        overlay.style.display = 'none';
    }

    // Función para abrir el modal de cantidad
    function openQuantityModal() {
        quantityModal.style.display = 'block';
        overlay.style.display = 'block';
    }

    // Función para cerrar el modal de cantidad
    function closeQuantityModal() {
        quantityModal.style.display = 'none';
        overlay.style.display = 'none';
    }

    // Vaciar carrito
    function clearCart() {
        cart = [];
        updateCartModal();
    }

    // Manejo de la adición de productos al carrito
    $(document).ready(function() {
        let currentProductId;
        let currentProductTitle;
        let currentProductPrice;

        // Al hacer clic en el botón "Añadir al carrito"
        $('.add-to-cart').click(function() {
            currentProductId = $(this).data('id');
            currentProductTitle = $(this).data('title');
            currentProductPrice = $(this).data('price');
            openQuantityModal(); // Muestra el modal
        });

        // Al hacer clic en "Añadir al carrito" en el modal
        $('#confirmAddToCart').click(function() {
            const quantity = $('#quantity').val();

            // Verifica si el producto ya está en el carrito
            const existingItem = cart.find(item => item.id === currentProductId);
            
            if (existingItem) {
                // Si ya existe, aumenta la cantidad
                existingItem.quantity = parseInt(existingItem.quantity) + parseInt(quantity);
                existingItem.price = (parseFloat(existingItem.price) + (currentProductPrice * quantity)).toFixed(2);
            } else {
                // Si no existe, añade el nuevo producto
                const totalPrice = (currentProductPrice * quantity).toFixed(2); // Calcular el precio total por la cantidad

                cart.push({ 
                    id: currentProductId, 
                    title: currentProductTitle, 
                    price: totalPrice, 
                    quantity: quantity 
                });
            }

            // Actualiza el carrito
            updateCartModal(); // Asegúrate de que esta función esté disponible
            alert(`${currentProductTitle} añadido al carrito con cantidad: ${quantity}`);
            closeQuantityModal(); // Cierra el modal después de añadir
        });
    });

    cartButton.addEventListener('click', openCart);
</script>



</body>
</html>
