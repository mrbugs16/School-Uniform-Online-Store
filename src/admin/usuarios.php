<?php
// ─── VISTA admin/usuarios.php ────────────────────────────────────────────────
// Solo accesible para superusuario
session_start();

require_once "../models/Usuario.php";

// Verificar que sea superusuario antes de mostrar nada
if (!Usuario::esSuperUsuario($_SESSION)) {
    header("Location: ../login.php");
    exit;
}

include_once "../db_cnx.php";

$usuarios = Usuario::getAll($cnx);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Admin — Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-dark bg-warning px-3">
    <span class="navbar-brand text-dark">Panel de Administración</span>
    <div>
        <a class="btn btn-outline-dark btn-sm me-2" href="../catalogo.php">← Catálogo</a>
        <a class="btn btn-danger btn-sm" href="../logout.php">Salir</a>
    </div>
</nav>

<main class="container mt-4">
    <h2>Usuarios registrados</h2>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['id_usuario']) ?></td>
                    <td><?= htmlspecialchars($u['nombre'])     ?></td>
                    <td><?= htmlspecialchars($u['email'])      ?></td>
                    <td><?= htmlspecialchars($u['usuario'])    ?></td>
                    <td>
                        <?php if ($u['rol'] === 'superusuario'): ?>
                            <span class="badge bg-warning text-dark">Superusuario</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Usuario</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>
