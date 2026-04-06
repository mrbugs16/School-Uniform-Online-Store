<?php
// ─── CONTROLADOR 
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

// MARCAR PEDIDO COMO PAGADO
$stmt = $cnx->prepare("UPDATE pedidos SET estado = 'pagado' WHERE id_pedido = ?");
$stmt->execute([$_SESSION["id_pedido"]]);

// LIMPIAR PEDIDO DE LA SESION PARA QUE EL USUARIO PUEDA HACER UNO NUEVO
unset($_SESSION["id_pedido"]);

$_SESSION["errmsg_success"] = "¡Pedido confirmado! Tu uniforme está en proceso.";
header("Location: catalogo.php");
exit;
