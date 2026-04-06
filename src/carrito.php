<?php
// ─── VISTA 
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

require_once "models/Pedido.php";
include_once "db_cnx.php";

$detalle = [];
$total   = 0.00;

if (isset($_SESSION["id_pedido"])) {
    $detalle = Pedido::getDetalle($cnx, (int)$_SESSION["id_pedido"]);
    foreach ($detalle as $item) {
        $total += $item['cantidad'] * $item['precio_unitario'];
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Uniformes — Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Uniformes Escolares</span>
    <div>
        <a class="btn btn-outline-light btn-sm me-2" href="catalogo.php">← Catálogo</a>
        <a class="btn btn-danger btn-sm" href="logout.php">Salir</a>
    </div>
</nav>

<main class="container mt-4">
    <h2>Tu carrito</h2>

    <?php if (isset($_SESSION["errmsg"])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION["errmsg"]) ?></div>
        <?php unset($_SESSION["errmsg"]); ?>
    <?php endif; ?>

    <?php if (count($detalle) === 0): ?>
        <div class="alert alert-info">No tienes prendas en el carrito aún.</div>
        <a href="catalogo.php" class="btn btn-primary">Ir al catálogo</a>
    <?php else: ?>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Prenda</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalle as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td><?= $item['talla'] ? htmlspecialchars($item['talla']) : '—' ?></td>
                        <td><?= htmlspecialchars($item['cantidad']) ?></td>
                        <td>$ <?= number_format($item['precio_unitario'], 2) ?> MXN</td>
                        <td>$ <?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?> MXN</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-success">
                    <td colspan="4"><strong>Total</strong></td>
                    <td><strong>$ <?= number_format($total, 2) ?> MXN</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex gap-2">
            <a href="catalogo.php" class="btn btn-outline-secondary">Seguir comprando</a>
            <form method="POST" action="pagarCNT.php">
                <button type="submit" class="btn btn-success">Confirmar y pagar</button>
            </form>
        </div>

    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>
