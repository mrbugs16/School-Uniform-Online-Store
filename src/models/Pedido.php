<?php
// ─── Pedido.php ───────────────────────────────────────────────────────────────
// Modelo de las entidades Pedido y DetallePedido.
// ─────────────────────────────────────────────────────────────────────────────

class Pedido {

    // ── Propiedades ──────────────────────────────────────────────────────────
    public int    $id_pedido;
    public int    $id_usuario;
    public string $fecha_pedido;
    public float  $total;
    public string $estado;

    // ── Constructor ──────────────────────────────────────────────────────────
    public function __construct(array $data) {
        $this->id_pedido    = $data['id_pedido'];
        $this->id_usuario   = $data['id_usuario'];
        $this->fecha_pedido = $data['fecha_pedido'];
        $this->total        = (float)$data['total'];
        $this->estado       = $data['estado'];
    }

    // ── Métodos estáticos (consultas) ─────────────────────────────────────────

    // Crear un pedido nuevo (pendiente) para el usuario
    public static function crear($cnx, int $id_usuario): int {
        $stmt = $cnx->prepare(
            "INSERT INTO pedidos (id_usuario) VALUES (?)"
        );
        $stmt->execute([$id_usuario]);
        return (int)$cnx->lastInsertId();
    }

    // Agregar una prenda al detalle del pedido
    public static function agregarDetalle($cnx, int $id_pedido, int $id_prenda,
                                           ?string $talla, int $cantidad,
                                           float $precio_unitario) {
        $stmt = $cnx->prepare(
            "INSERT INTO detalle_pedido (id_pedido, id_prenda, talla, cantidad, precio_unitario)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$id_pedido, $id_prenda, $talla, $cantidad, $precio_unitario]);
    }

    // Actualizar el total del pedido sumando su detalle
    public static function actualizarTotal($cnx, int $id_pedido) {
        $stmt = $cnx->prepare(
            "UPDATE pedidos
             SET total = (
                 SELECT SUM(cantidad * precio_unitario)
                 FROM   detalle_pedido
                 WHERE  id_pedido = ?
             )
             WHERE id_pedido = ?"
        );
        $stmt->execute([$id_pedido, $id_pedido]);
    }

    // Obtener pedidos de un usuario
    public static function getByUsuario($cnx, int $id_usuario) {
        $stmt = $cnx->prepare(
            "SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY fecha_pedido DESC"
        );
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el detalle (prendas) de un pedido
    public static function getDetalle($cnx, int $id_pedido) {
        $stmt = $cnx->prepare(
            "SELECT dp.*, p.nombre, p.imagen
             FROM   detalle_pedido dp
             INNER JOIN prendas p ON p.id_prenda = dp.id_prenda
             WHERE  dp.id_pedido = ?"
        );
        $stmt->execute([$id_pedido]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
