<?php
include 'conexion.php';

$marcas_query = $conexion->query("SELECT * FROM marcas");
$categorias_query = $conexion->query("SELECT * FROM categorias");
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST['descripcion'];
    $id_marca = $_POST['id_marca'];
    $id_categoria = $_POST['id_categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if (!empty($descripcion) && !empty($id_marca) && !empty($id_categoria) && !empty($precio) && !empty($stock)) {
        
        $sql_producto = "INSERT INTO productos (descripcion, id_marca, id_categoria) VALUES ('$descripcion', '$id_marca', '$id_categoria')";
        
        if ($conexion->query($sql_producto) === TRUE) {
            $id_nuevo_producto = $conexion->insert_id;
            $sql_inventario = "INSERT INTO inventario (id_producto, precio_venta, stock) VALUES ('$id_nuevo_producto', '$precio', '$stock')";
            
            if ($conexion->query($sql_inventario) === TRUE) {
                $mensaje = "<div class='alert alert-success'>¡Listo! Mercancía anotada en el inventario.</div>";
            } else {
                $mensaje = "<div class='alert alert-error'>Error: " . $conexion->error . "</div>";
            }
        } else {
            $mensaje = "<div class='alert alert-error'>Error: " . $conexion->error . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-error'>Tienes que llenar todos los datos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Surtir Tienda - Miscelánea Mimin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="fachada-letrero">
        <div class="fachada-titulo">Abarrotes Miscelánea Mimin <span>Coca-Cola</span></div>
    </header>
    
    <nav class="menu-tienda">
        <a href="index.php">← Volver al Mostrador</a>
    </nav>

    <div class="formulario-caja">
        <h2>Surtir Nuevo Producto</h2>
        
        <?php echo $mensaje; ?>

        <form action="registro.php" method="POST">
            <div class="form-group">
                <label>¿Qué producto llegó?:</label>
                <input type="text" name="descripcion" placeholder="Ej. Refrescos de Sabor" required>
            </div>

            <div class="form-group">
                <label>Marca Proveedora:</label>
                <select name="id_marca" required>
                    <option value="">-- Selecciona --</option>
                    <?php while($m = $marcas_query->fetch_assoc()): ?>
                        <option value="<?php echo $m['id_marca']; ?>"><?php echo $m['nombre_marca']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Sección / Categoría:</label>
                <select name="id_categoria" required>
                    <option value="">-- Selecciona --</option>
                    <?php while($c = $categorias_query->fetch_assoc()): ?>
                        <option value="<?php echo $c['id_categoria']; ?>"><?php echo $c['nombre_categoria']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Precio al público ($):</label>
                <input type="number" step="0.01" name="precio" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label>¿Cuántas cajas/piezas llegaron?:</label>
                <input type="number" name="stock" placeholder="Cantidad" required>
            </div>

            <button type="submit" class="btn-registrar">Guardar en Mostrador</button>
        </form>
    </div>

</body>
</html>