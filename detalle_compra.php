<?php
// detalle_compra.php
$conn = new mysqli('localhost', 'root', '', 'tienda1');

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener los IDs de los productos desde la URL
$productData = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];

$totalPrice = 0; // Para calcular el precio total

// Crear una consulta para obtener los detalles de los productos
if (!empty($productData)) {
    $ids = [];
    $quantities = [];
    
    // Descomponer los datos en IDs y cantidades
    foreach ($productData as $data) {
        list($id, $quantity) = explode(':', $data);
        $ids[] = intval($id);
        $quantities[] = intval($quantity);
    }

    $idsString = implode(',', $ids);
    $sql = "SELECT * FROM productos WHERE productoID IN ($idsString)";
    $result = $conn->query($sql);
} else {
    echo '<p>No hay productos en el carrito.</p>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de Compra</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AY0sgZdY8ejr1ufv11KbXnY9WgCXwMU83Nr2dmS5rqU2hn1yJ9XVbBlbJwQW4kpMrHi1GDOCeRr-yqwj"></script>
</head>
<?php include 'view/modulos/head.php'; ?>
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

<div class="container">
    <h2>Detalle de Compra</h2>
    <ul class="list-group">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Obtener la cantidad correspondiente
                $index = array_search($row['productoID'], $ids);
                $quantity = $index !== false ? $quantities[$index] : 0;

                echo '<li class="list-group-item">';
                echo $row["nombre"] . ' - $' . $row["precio"] . ' (Cantidad: ' . $quantity . ')';
                $totalPrice += $row["precio"] * $quantity; // Sumar al total usando la cantidad
                echo '</li>';
            }
            echo '<li class="list-group-item"><strong>Total: $' . $totalPrice . '</strong></li>';
        } else {
            echo '<li class="list-group-item">No se encontraron productos.</li>';
        }
        ?>
    </ul>

    <div id="paypal-button-container"></div> <!-- Contenedor para el botón de PayPal -->
</div>

<script>
    // Integración de PayPal
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $totalPrice; ?>' // Total a pagar
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Gracias por su compra, ' + details.payer.name.given + '!');
            });
        },
        onError: function(err) {
            console.error(err);
        }
    }).render('#paypal-button-container'); // Renderiza el botón en el contenedor
</script>

<?php 
    // Cerrar conexión
    $conn->close(); 
?>

<?php include 'view/modulos/footer.php'; ?>
</body>
</html>