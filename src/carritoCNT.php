<?php
// ─── CONTROLADOR 
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: catalogo.php");
    exit;
}

require_once "models/Validator.php";
require_once "models/Prenda.php";
require_once "models/Pedido.php";
include_once "db_cnx.php";

$id_prenda = $_POST["id_prenda"] ?? "";
$talla     = $_POST["talla"]     ?? null;
$cantidad  = $_POST["cantidad"]  ?? "";

// VALIDACIONES CON VALIDATOR
if (!Validator::numero($id_prenda)) {
    $_SESSION["errmsg"] = "Prenda inválida.";
    header("Location: catalogo.php");
    exit;
}

if (!Validator::cantidad($cantidad)) {
    $_SESSION["errmsg"] = "La cantidad debe ser al menos 1.";
    header("Location: catalogo.php");
    exit;
}

// VERIFICAR PRENDA EN BD
$prenda = Prenda::getById($cnx, (int)$id_prenda);
if (!$prenda) {
    $_SESSION["errmsg"] = "La prenda no existe.";
    header("Location: catalogo.php");
    exit;
}

// Si la prenda tiene talla, validarla
if ($prenda['tiene_talla'] && !Validator::talla($talla)) {
    $_SESSION["errmsg"] = "Selecciona una talla válida (S, M, L, XL).";
    header("Location: catalogo.php");
    exit;
}

// SI NO TIENE TALLA
if (!$prenda['tiene_talla']) {
    $talla = null;
}

// CREAR O REUTILIZAR PEDIDO PENDIENTE EN SESION
if (!isset($_SESSION["id_pedido"])) {
    $id_pedido = Pedido::crear($cnx, (int)$_SESSION["id_usuario"]);
    $_SESSION["id_pedido"] = $id_pedido;
}

// AGREGAR AL DETALLE
Pedido::agregarDetalle(
    $cnx,
    (int)$_SESSION["id_pedido"],
    (int)$id_prenda,
    $talla,
    (int)$cantidad,
    (float)$prenda['precio']
);

// ACTUALIZAR TOTAL
Pedido::actualizarTotal($cnx, (int)$_SESSION["id_pedido"]);

header("Location: carrito.php");
exit;
