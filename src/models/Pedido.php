<?php
class Pedido {

    
    public int    $id_pedido;
    public int    $id_usuario;
    public string $fecha_pedido;
    public float  $total;
    public string $estado;

    // CONSTRUCTOR
    public function __construct(array $data) {
        $this->id_pedido    = $data['id_pedido'];
        $this->id_usuario   = $data['id_usuario'];
        $this->fecha_pedido = $data['fecha_pedido'];
        $this->total        = (float)$data['total'];
        $this->estado       = $data['estado'];
    }

    // CREAR UN PEDIDO NUEVO 
    public static function crear($cnx, int $id_usuario): int {
        $stmt = $cnx->prepare(
            "INSERT INTO pedidos (id_usuario) VALUES (?)"
        );
        $stmt->execute([$id_usuario]);
        return (int)$cnx->lastInsertId();
    }

    // AGREGAR UNA PRENDA AL DETALLE DEL PEDIDO
    public static function agregarDetalle($cnx, int $id_pedido, int $id_prenda,
                                           ?string $talla, int $cantidad,
                                           float $precio_unitario) {
        $stmt = $cnx->prepare(
            "INSERT INTO detalle_pedido (id_pedido, id_prenda, talla, cantidad, precio_unitario)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$id_pedido, $id_prenda, $talla, $cantidad, $precio_unitario]);
    }

    // ACTUALIZAR EL TOTAL DEL PEDIDO SUMANDO SU DETALLE
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

    // OBTENER PEDIDOS DE UN USUARIO
    public static function getByUsuario($cnx, int $id_usuario) {
        $stmt = $cnx->prepare(
            "SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY fecha_pedido DESC"
        );
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER EL DETALLE (PRENDAS) DE UN PEDIDO
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
