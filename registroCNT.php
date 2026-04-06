<?php
// ─── CONTROLADOR registroCNT.php ─────────────────────────────────────────────
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: registro.php");
    exit;
}

require_once "models/Validator.php";
require_once "models/Usuario.php";
include_once "db_cnx.php";

$nombre      = trim($_POST["nombre"]   ?? "");
$email       = trim($_POST["email"]    ?? "");
$usuario     = trim($_POST["usuario"]  ?? "");
$password    = $_POST["password"]      ?? "";
$confirma    = $_POST["confirma"]      ?? "";
$suscripcion = isset($_POST["suscripcion"]) ? 1 : 0;

// ── Validaciones con Validator ────────────────────────────────────────────────
if (!Validator::nombre($nombre)) {
    $_SESSION["errmsg"] = "El nombre solo puede contener letras y espacios.";
    header("Location: registro.php");
    exit;
}

if (!Validator::email($email)) {
    $_SESSION["errmsg"] = "El correo electrónico no es válido.";
    header("Location: registro.php");
    exit;
}

if (!Validator::texto($usuario)) {
    $_SESSION["errmsg"] = "El usuario es obligatorio.";
    header("Location: registro.php");
    exit;
}

if (!Validator::password($password)) {
    $_SESSION["errmsg"] = "La contraseña debe tener al menos 6 caracteres.";
    header("Location: registro.php");
    exit;
}

if ($password !== $confirma) {
    $_SESSION["errmsg"] = "Las contraseñas no coinciden.";
    header("Location: registro.php");
    exit;
}

// ── Insertar usando el modelo ─────────────────────────────────────────────────
try {
    $id = Usuario::crear($cnx, $nombre, $email, $usuario, $password, $suscripcion);

    $_SESSION["id_usuario"] = $id;
    $_SESSION["usuario"]    = $usuario;
    $_SESSION["nombre"]     = $nombre;
    $_SESSION["rol"]        = "usuario";

    header("Location: catalogo.php");
    exit;

} catch (Exception $e) {
    $_SESSION["errmsg"] = "El usuario o correo ya están registrados.";
    header("Location: registro.php");
    exit;
}
