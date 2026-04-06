<?php
// ─── Categoria.php ────────────────────────────────────────────────────────────
// Modelo de la entidad Categoría.
// ─────────────────────────────────────────────────────────────────────────────

class Categoria {

    // ── Propiedades ──────────────────────────────────────────────────────────
    public int    $id_categoria;
    public string $nombre;

    // ── Constructor ──────────────────────────────────────────────────────────
    public function __construct(array $data) {
        $this->id_categoria = $data['id_categoria'];
        $this->nombre       = $data['nombre'];
    }

    // ── Métodos estáticos (consultas) ─────────────────────────────────────────

    // Obtener todas las categorías
    public static function getAll($cnx) {
        $stmt = $cnx->query("SELECT * FROM categorias ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener categoría por ID
    public static function getById($cnx, int $id) {
        $stmt = $cnx->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}