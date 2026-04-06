<?php
// ─── Prenda.php ───────────────────────────────────────────────────────────────
// Modelo de la entidad Prenda.
// ─────────────────────────────────────────────────────────────────────────────

class Prenda {

    // ── Propiedades ──────────────────────────────────────────────────────────
    public int    $id_prenda;
    public int    $id_categoria;
    public string $nombre;
    public float  $precio;
    public ?string $imagen;
    public bool   $tiene_talla;

    // ── Constructor ──────────────────────────────────────────────────────────
    public function __construct(array $data) {
        $this->id_prenda    = $data['id_prenda'];
        $this->id_categoria = $data['id_categoria'];
        $this->nombre       = $data['nombre'];
        $this->precio       = (float)$data['precio'];
        $this->imagen       = $data['imagen'] ?? null;
        $this->tiene_talla  = (bool)$data['tiene_talla'];
    }

    // ── Métodos estáticos (consultas) ─────────────────────────────────────────

    // Obtener todas las prendas
    public static function getAll($cnx) {
        $stmt = $cnx->query("SELECT * FROM prendas ORDER BY id_categoria, nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener prendas por categoría
    public static function getByCategoria($cnx, int $id_categoria) {
        $stmt = $cnx->prepare("SELECT * FROM prendas WHERE id_categoria = ? ORDER BY nombre");
        $stmt->execute([$id_categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener prenda por ID
    public static function getById($cnx, int $id) {
        $stmt = $cnx->prepare("SELECT * FROM prendas WHERE id_prenda = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
