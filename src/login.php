<?php
// ─── VISTA 
session_start();
$errmsg = $_SESSION["errmsg"] ?? null;
unset($_SESSION["errmsg"]);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Uniformes — Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container" style="min-height:100vh;display:flex;flex-direction:column;justify-content:center;">

    <h1 class="text-center my-4">Uniformes Escolares</h1>
    <h2 class="text-center mb-4 text-secondary fs-5">Iniciar sesión</h2>

    <section class="row justify-content-center">
        <form method="POST" class="col-12 col-md-4" action="loginCNT.php">

            <?php if ($errmsg): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errmsg) ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input class="form-control" id="usuario" name="usuario"
                       placeholder="Ingrese su usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input class="form-control" id="password" name="password"
                       type="password" placeholder="Ingrese su contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>

            <div class="text-center mt-3">
                <a href="registro.php">Crear cuenta nueva</a>
            </div>
        </form>
    </section>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>
