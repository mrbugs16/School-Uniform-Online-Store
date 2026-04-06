<?php
// ─── VISTA catalogo.php ───────────────────────────────────────────────────────
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

require_once "models/Categoria.php";
require_once "models/Prenda.php";
include_once "db_cnx.php";

// ── Lógica del controlador (obtener datos con los modelos) ────────────────────
$categorias = Categoria::getAll($cnx);

// Filtro de categoría por GET (igual que tables1_css_get.php del repo)
$filtro = isset($_GET["categoria"]) && is_numeric($_GET["categoria"])
        ? (int)$_GET["categoria"]
        : 0;

if ($filtro > 0) {
    $prendas = Prenda::getByCategoria($cnx, $filtro);
} else {
    $prendas = Prenda::getAll($cnx);
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Uniformes — Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Uniformes Escolares</span>
    <div>
        <span class="text-white me-3">Hola, <?= htmlspecialchars($_SESSION["nombre"]) ?></span>
        <?php if ($_SESSION["rol"] === "superusuario"): ?>
            <a class="btn btn-warning btn-sm me-2" href="admin/usuarios.php">Admin</a>
        <?php endif; ?>
        <a class="btn btn-outline-light btn-sm me-2" href="carrito.php">🛒 Carrito</a>
        <a class="btn btn-danger btn-sm" href="logout.php">Salir</a>
    </div>
</nav>

<main class="container mt-4">

    <!-- Filtros de categoría -->
    <div class="mb-3">
        <a class="btn btn-outline-secondary btn-sm me-1 <?= $filtro === 0 ? 'active' : '' ?>"
           href="catalogo.php">Todos</a>
        <?php foreach ($categorias as $cat): ?>
            <a class="btn btn-outline-secondary btn-sm me-1 <?= $filtro === (int)$cat['id_categoria'] ? 'active' : '' ?>"
               href="catalogo.php?categoria=<?= $cat['id_categoria'] ?>">
                <?= htmlspecialchars($cat['nombre']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Tabla de prendas -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Prenda</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Talla</th>
                <th>Cantidad</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($prendas) === 0): ?>
                <tr><td colspan="6">No hay prendas en esta categoría.</td></tr>
            <?php else: ?>
                <?php foreach ($prendas as $prenda): ?>
                    <tr>
                        <td><?= htmlspecialchars($prenda['nombre']) ?></td>
                        <td>
                            <?php
                            // Nombre de categoría sin consulta extra
                            foreach ($categorias as $cat) {
                                if ($cat['id_categoria'] === $prenda['id_categoria']) {
                                    echo htmlspecialchars($cat['nombre']);
                                    break;
                                }
                            }
                            ?>
                        </td>
                        <td>$ <?= number_format($prenda['precio'], 2) ?> MXN</td>
                        <td>
                            <?php if ($prenda['tiene_talla']): ?>
                                <form method="POST" action="carritoCNT.php" style="display:inline">
                                    <input type="hidden" name="id_prenda"
                                           value="<?= $prenda['id_prenda'] ?>">
                                    <select name="talla" class="form-select form-select-sm" required>
                                        <option value="">--</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                            <?php else: ?>
                                <form method="POST" action="carritoCNT.php" style="display:inline">
                                    <input type="hidden" name="id_prenda"
                                           value="<?= $prenda['id_prenda'] ?>">
                                    <input type="hidden" name="talla" value="">
                                    <span class="text-muted">Sin talla</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="number" name="cantidad" value="1"
                                   min="1" max="10" class="form-control form-control-sm"
                                   style="width:70px">
                        </td>
                        <td>
                                <button type="submit" class="btn btn-success btn-sm">
                                    Agregar
                                </button>
                                </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>
