<?php
// ─── CONTROLADOR loginCNT.php ─────────────────────────────────────────────────
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

// Validar que no estén vacíos
if (!Validator::texto($usuario) || !Validator::texto($password)) {
    $_SESSION["errmsg"] = "Usuario y contraseña son obligatorios.";
    header("Location: login.php");
    exit;
}

// Buscar usuario en BD usando el modelo
$row = Usuario::getByUsuario($cnx, $usuario);

if ($row === false) {
    $_SESSION["errmsg"] = "Las credenciales no son válidas.";
    header("Location: login.php");
    exit;
}

// Verificar contraseña con password_verify (igual que en el repo)
if (!password_verify($password, $row["password"])) {
    $_SESSION["errmsg"] = "Las credenciales no son válidas.";
    header("Location: login.php");
    exit;
}

// Guardar datos en sesión
$_SESSION["id_usuario"] = $row["id_usuario"];
$_SESSION["usuario"]    = $row["usuario"];
$_SESSION["nombre"]     = $row["nombre"];
$_SESSION["rol"]        = $row["rol"];

header("Location: catalogo.php");
exit;
