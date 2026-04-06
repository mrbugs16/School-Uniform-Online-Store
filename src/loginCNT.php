<?php
// ─── CONTROLADOR 
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

require_once "models/Validator.php";
require_once "models/Usuario.php";
include_once "db_cnx.php";

$usuario  = trim($_POST["usuario"]  ?? "");
$password = trim($_POST["password"] ?? "");

if (!Validator::texto($usuario) || !Validator::texto($password)) {
    $_SESSION["errmsg"] = "Usuario y contraseña son obligatorios.";
    header("Location: login.php");
    exit;
}

// BUSCAR USUARIO EN BD 
$row = Usuario::getByUsuario($cnx, $usuario);

if ($row === false) {
    $_SESSION["errmsg"] = "Las credenciales no son válidas.";
    header("Location: login.php");
    exit;
}

// VERIFICAR CONTRASEÑA CON PASSWORD_VERIFY
if (!password_verify($password, $row["password"])) {
    $_SESSION["errmsg"] = "Las credenciales no son válidas.";
    header("Location: login.php");
    exit;
}

// GUARDAR DATOS EN SESION
$_SESSION["id_usuario"] = $row["id_usuario"];
$_SESSION["usuario"]    = $row["usuario"];
$_SESSION["nombre"]     = $row["nombre"];
$_SESSION["rol"]        = $row["rol"];

header("Location: catalogo.php");
exit;
