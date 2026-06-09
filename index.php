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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Miscelánea Mimin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="fachada-letrero">
        <div class="fachada-titulo">
            Abarrotes Miscelánea Mimin 
            <img src="https://logodownload.org/wp-content/uploads/2014/04/coca-cola-logo-1-1.png" alt="Logo Coca Cola" class="logo-header">
        </div>
    </header>
    
    <nav class="menu-tienda">
        <a href="index.php">🏠 Ver Mostrador</a>
        <a href="registro.php">📦 Surtir Tienda (Registrar)</a>
    </nav>

    <div class="hero-banner">
        <div class="hero-content">
            <h1>Todo lo que necesitas, cerca de ti.</h1>
            <p>Abarrotes, botanas, limpieza y más. Frescura y calidad todos los días.</p>
        </div>
    </div>

    <div class="contenedor-principal">
        
        <main class="mostrador">
            <div class="header-mostrador">
                <h2 class="seccion-letrero">Catálogo de Productos</h2>
                
                <div class="menu-esquina">
                    <label for="filtro-departamento">🔍 Departamentos:</label>
                    <select id="filtro-departamento">
                        <option value="todos">Todos los productos</option>
                        <option value="bebidas">Bebidas y Refrescos</option>
                        <option value="panaderia">Panadería y Dulces</option>
                        <option value="lacteos">Lácteos y Huevos</option>
                        <option value="botanas">Botanas y Semillas</option>
                        <option value="limpieza">Limpieza del Hogar</option>
                    </select>
                </div>
            </div>
            
            <div class="estanteria-grid">
                <?php
                if ($resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()) {
                        
                        $nombre_prod = strtolower($fila['descripcion']);
                        $cat_prod = strtolower($fila['nombre_categoria']);
                        $marca_prod = strtolower($fila['nombre_marca']);
                        
                        $url_imagen = "https://placehold.co/400x300/f4f6f8/e50000?text=" . urlencode($fila['descripcion']);

                        if (strpos($nombre_prod, 'coca') !== false || strpos($nombre_prod, 'refresco') !== false) {
                            $url_imagen = "https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=400&q=80"; 
                        } elseif (strpos($nombre_prod, 'pan') !== false || strpos($nombre_prod, 'bimbo') !== false) {
                            $url_imagen = "https://images.unsplash.com/photo-1598373182133-52452f7691ef?w=400&q=80"; 
                        } elseif (strpos($nombre_prod, 'leche') !== false || strpos($nombre_prod, 'lala') !== false || strpos($cat_prod, 'lacteos') !== false) {
                            $url_imagen = "https://images.unsplash.com/photo-1563636619-e9143da7973b?w=400&q=80"; 
                        } elseif (strpos($nombre_prod, 'frijol') !== false || strpos($cat_prod, 'legumbres') !== false) {
                            $url_imagen = "https://images.unsplash.com/photo-1551462147-16fabc0837f1?w=400&q=80"; 
                        } elseif (strpos($nombre_prod, 'chetto') !== false || strpos($nombre_prod, 'cheeto') !== false || strpos($cat_prod, 'botana') !== false || strpos($marca_prod, 'sabritas') !== false) {
                            $url_imagen = "https://images.unsplash.com/photo-1599599811440-20e408d6c70d?w=400&q=80"; 
                        } elseif (strpos($nombre_prod, 'fabuloso') !== false || strpos($cat_prod, 'limpieza') !== false) {
                            $url_imagen = "https://images.unsplash.com/photo-1584820927498-cafe5c152912?w=400&q=80"; 
                        } elseif (strpos($nombre_prod, 'tequila') !== false || strpos($nombre_prod, 'whisky') !== false || strpos($cat_prod, 'licor') !== false) {
                            $url_imagen = "https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=400&q=80"; 
                        }
                ?>
                        <div class="producto-tarjeta">
                            <div class="tarjeta-header">
                                <span class="producto-categoria"><?php echo htmlspecialchars($fila['nombre_categoria']); ?></span>
                                <span class="producto-stock"><?php echo $fila['stock']; ?> pzas</span>
                            </div>
                            
                            <img src="<?php echo $url_imagen; ?>" alt="Imagen de <?php echo htmlspecialchars($fila['descripcion']); ?>" class="producto-img" loading="lazy">
                            
                            <div class="producto-info">
                                <p class="producto-marca"><?php echo htmlspecialchars($fila['nombre_marca']); ?></p>
                                <h3 class="producto-nombre"><?php echo htmlspecialchars($fila['descripcion']); ?></h3>
                                <div class="contenedor-precio-btn">
                                    <p class="producto-precio">$<?php echo number_format($fila['precio_venta'], 2); ?></p>
                                    <button class="btn-comprar" onclick="abrirModal('<?php echo htmlspecialchars($fila['descripcion']); ?>', <?php echo $fila['precio_venta']; ?>)">Vender</button>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<div class='alerta-vacia'>El mostrador está vacío. ¡Ve a surtir la tienda!</div>";
                }
                ?>
            </div>
        </main>
    </div>

    <footer class="footer-tienda">
        <p>&copy; 2026 Abarrotes Miscelánea Mimin. Todos los derechos reservados.</p>
    </footer>

    <div id="modalCheckout" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="modal-body">
                <h2>Finalizar Venta</h2>
                <div class="resumen-pedido">
                    <p><strong>Producto:</strong> <span id="modal-producto-nombre"></span></p>
                    <p><strong>Total a cobrar:</strong> <span class="precio-destacado">$<span id="modal-producto-precio"></span></span></p>
                </div>
                
                <form id="form-checkout" onsubmit="procesarVentaFingida(event)">
                    <div class="form-group">
                        <label>Dirección de Envío:</label>
                        <input type="text" required placeholder="Ej. Centro 123">
                    </div>
                    <div class="form-group">
                        <label>Método de Pago:</label>
                        <select required>
                            <option value="">Selecciona un método...</option>
                            <option value="efectivo">Efectivo contra entrega</option>
                            <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                            <option value="transferencia">Transferencia BBVA / Spin by OXXO</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-comprar btn-confirmar">Confirmar Pedido</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("modalCheckout");
        const contenidoOriginal = document.getElementById("modal-body").innerHTML;

        function abrirModal(nombreProducto, precioProducto) {
            document.getElementById("modal-body").innerHTML = contenidoOriginal;
            document.getElementById("modal-producto-nombre").innerText = nombreProducto;
            document.getElementById("modal-producto-precio").innerText = precioProducto.toFixed(2);
            modal.style.display = "flex";
        }

        function cerrarModal() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                cerrarModal();
            }
        }

        function procesarVentaFingida(event) {
            event.preventDefault(); 
            const modalBody = document.getElementById("modal-body");
            modalBody.innerHTML = `
                <div style="text-align: center; padding: 20px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Éxito" style="width: 80px; margin-bottom: 15px;">
                    <h2 style="color: #2e7d32;">¡Pedido Registrado!</h2>
                    <p style="color: #555; margin-bottom: 20px;">La venta simulada se realizó con éxito. El paquete está listo para envío.</p>
                    <button onclick="cerrarModal()" class="btn-comprar" style="width: 100%;">Volver al mostrador</button>
                </div>
            `;
        }
    </script>
</body>
</html>