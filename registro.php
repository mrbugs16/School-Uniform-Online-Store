<?php
// ─── VISTA ────────────────────────────────────────────────────────────────────
session_start();
$errmsg = $_SESSION["errmsg"] ?? null;
unset($_SESSION["errmsg"]);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Uniformes — Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container" style="min-height:100vh;display:flex;flex-direction:column;justify-content:center;">

    <h1 class="text-center my-4">Crear cuenta</h1>

    <section class="row justify-content-center">
        <form method="POST" class="col-12 col-md-5" action="registroCNT.php">

            <?php if ($errmsg): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errmsg) ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input class="form-control" id="nombre" name="nombre"
                       placeholder="Ingrese su nombre" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input class="form-control" id="email" name="email" type="email"
                       placeholder="Ingrese su correo" required>
            </div>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input class="form-control" id="usuario" name="usuario"
                       placeholder="Ingrese su usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input class="form-control" id="password" name="password"
                       type="password" placeholder="Mínimo 6 caracteres" required>
            </div>

            <div class="mb-3">
                <label for="confirma" class="form-label">Confirmar contraseña</label>
                <input class="form-control" id="confirma" name="confirma"
                       type="password" placeholder="Repita su contraseña" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1"
                       name="suscripcion" id="suscripcion">
                <label class="form-check-label" for="suscripcion">
                    Deseo recibir notificaciones por correo
                </label>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrarse</button>

            <div class="text-center mt-3">
                <a href="login.php">Ya tengo cuenta</a>
            </div>
        </form>
    </section>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>
