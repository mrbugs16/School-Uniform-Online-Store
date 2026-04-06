<?php
class Usuario {

    
    public int    $id_usuario;
    public string $nombre;
    public string $email;
    public string $usuario;
    public string $password;
    public string $rol;
    public bool   $suscripcion;

    // CONSTRUCTOR
    public function __construct(array $data) {
        $this->id_usuario  = $data['id_usuario'];
        $this->nombre      = $data['nombre'];
        $this->email       = $data['email'];
        $this->usuario     = $data['usuario'];
        $this->password    = $data['password'];
        $this->rol         = $data['rol'];
        $this->suscripcion = (bool)$data['suscripcion'];
    }

    // OBTENER TODOS LOS USUARIOS
    public static function getAll($cnx) {
        $stmt = $cnx->query("SELECT id_usuario, nombre, email, usuario, rol
                             FROM usuarios
                             ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // BUSCAR USUARIO POR NOMBRE DE USUARIO (PARA LOGIN)
    public static function getByUsuario($cnx, string $usuario) {
        $stmt = $cnx->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // REGISTRAR NUEVO USUARIO
    public static function crear($cnx, string $nombre, string $email,
                                  string $usuario, string $password,
                                  bool $suscripcion) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $cnx->prepare(
            "INSERT INTO usuarios (nombre, email, usuario, password, suscripcion)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$nombre, $email, $usuario, $hash, $suscripcion]);
        return $cnx->lastInsertId();
    }

    // VERIFICAR SI EL USUARIO LOGUEADO ES SUPERUSUARIO
    public static function esSuperUsuario(array $session): bool {
        return isset($session['rol']) && $session['rol'] === 'superusuario';
    }
}
