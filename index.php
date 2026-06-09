<?php
include 'conexion.php';

$sql = "SELECT p.id_producto, p.descripcion, m.nombre_marca, c.nombre_categoria, i.precio_venta, i.stock 
        FROM productos p
        JOIN marcas m ON p.id_marca = m.id_marca
        JOIN categorias c ON p.id_categoria = c.id_categoria
        JOIN inventario i ON p.id_producto = i.id_producto";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Abarrotes Miscelánea Mimin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="fachada-letrero">
        <div class="fachada-titulo">Abarrotes Miscelánea Mimin <span>Coca-Cola</span></div>
    </header>
    
    <nav class="menu-tienda">
        <a href="index.php">Ver Mostrador</a>
        <a href="registro.php">+ Surtir Tienda (Registrar)</a>
    </nav>

    <main class="mostrador">
        <h2 class="seccion-letrero">Productos en Existencia</h2>
        
        <div class="estanteria-grid">
            <?php
            if ($resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) {
            ?>
                    <div class="producto-tarjeta">
                        <span class="producto-categoria"><?php echo $fila['nombre_categoria']; ?></span>
                        
                        <div class="producto-icono">🥤</div>
                        
                        <div>
                            <p class="producto-marca"><?php echo $fila['nombre_marca']; ?></p>
                            <h3 class="producto-nombre"><?php echo $fila['descripcion']; ?></h3>
                        </div>
                        
                        <div>
                            <p class="producto-precio">$<?php echo number_format($fila['precio_venta'], 2); ?></p>
                            <p class="producto-stock">En Tienda: <?php echo $fila['stock']; ?> pzas</p>
                            <button class="btn-comprar">Vender pieza</button>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p style='grid-column: 1/-1; text-align: center; font-weight: bold;'>El mostrador está vacío. ¡Ve a surtir la tienda!</p>";
            }
            ?>
        </div>
    </main>

</body>
</html>