<?php
// MODEL DE LA ENTIDAD CATEGORIA
class Categoria {

    // PROPIEDADES
    public int    $id_categoria;
    public string $nombre;

    // CONSTRUCTOR
    public function __construct(array $data) {
        $this->id_categoria = $data['id_categoria'];
        $this->nombre       = $data['nombre'];
    }

    // OBTENER TODAS LAS CATEGORIAS
    public static function getAll($cnx) {
        $stmt = $cnx->query("SELECT * FROM categorias ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER CATEGORIA POR ID
    public static function getById($cnx, int $id) {
        $stmt = $cnx->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}