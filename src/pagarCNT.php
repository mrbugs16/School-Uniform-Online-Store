<?php
// ─── CONTROLADOR pagarCNT.php ─────────────────────────────────────────────────
session_start();

if (!isset($_SESSION["id_usuario"]) || !isset($_SESSION["id_pedido"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: carrito.php");
    exit;
}

include_once "db_cnx.php";

// Marcar el pedido como pagado
$stmt = $cnx->prepare("UPDATE pedidos SET estado = 'pagado' WHERE id_pedido = ?");
$stmt->execute([$_SESSION["id_pedido"]]);

// Limpiar el pedido de la sesión para que el usuario pueda hacer uno nuevo
unset($_SESSION["id_pedido"]);

$_SESSION["errmsg_success"] = "¡Pedido confirmado! Tu uniforme está en proceso.";
header("Location: catalogo.php");
exit;
