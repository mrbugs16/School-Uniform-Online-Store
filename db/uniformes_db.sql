USE arqweb;

DROP TABLE IF EXISTS detalle_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS prendas;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;

-- ─── Tabla usuarios ──────────────────────────────────────────────────────────
CREATE TABLE usuarios (
    id_usuario  INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    usuario     VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    rol         ENUM('usuario','superusuario') NOT NULL DEFAULT 'usuario',
    suscripcion BOOLEAN NOT NULL DEFAULT FALSE
);

-- ─── Tabla categorias ────────────────────────────────────────────────────────
CREATE TABLE categorias (
    id_categoria INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100) NOT NULL
);

-- ─── Tabla prendas ───────────────────────────────────────────────────────────
CREATE TABLE prendas (
    id_prenda    INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT           NOT NULL,
    nombre       VARCHAR(100)  NOT NULL,
    precio       DECIMAL(10,2) NOT NULL,
    imagen       VARCHAR(255)  DEFAULT NULL,
    tiene_talla  BOOLEAN       NOT NULL DEFAULT TRUE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

-- ─── Tabla pedidos ───────────────────────────────────────────────────────────
CREATE TABLE pedidos (
    id_pedido    INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario   INT           NOT NULL,
    fecha_pedido DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total        DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado       ENUM('pendiente','pagado','entregado') NOT NULL DEFAULT 'pendiente',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- ─── Tabla detalle_pedido ────────────────────────────────────────────────────
CREATE TABLE detalle_pedido (
    id_detalle      INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_pedido       INT           NOT NULL,
    id_prenda       INT           NOT NULL,
    talla           ENUM('S','M','L','XL') DEFAULT NULL,
    cantidad        INT           NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_prenda) REFERENCES prendas(id_prenda)
);

-- ─── Datos de prueba ─────────────────────────────────────────────────────────
-- Contraseña para todos: password123
INSERT INTO usuarios (nombre, email, usuario, password, rol, suscripcion) VALUES
('Admin General',   'admin@mail.com',    'admin',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superusuario', 1),
('Santiago Tapia',  'santiago@mail.com', 'santiago', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario',       1),
('Ana García',      'ana@mail.com',      'ana',      '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario',       0);

INSERT INTO categorias (nombre) VALUES
('Deportes'),
('Uso Casual'),
('Gala');

INSERT INTO prendas (id_categoria, nombre, precio, tiene_talla) VALUES
-- Deportes (id_categoria = 1)
(1, 'Pants',           350.00, TRUE),
(1, 'Playera Roja',    180.00, TRUE),
(1, 'Playera Blanca',  180.00, TRUE),
(1, 'Shorts',          220.00, TRUE),
(1, 'Chamarra',        680.00, TRUE),
-- Uso Casual (id_categoria = 2)
(2, 'Playera Polo',    250.00, TRUE),
(2, 'Chamarra Diaria', 650.00, TRUE),
(2, 'Chaleco Antifrio',400.00, TRUE),
-- Gala (id_categoria = 3)
(3, 'Parche Institucional', 120.00, FALSE),
(3, 'Saco Azul Marino',    900.00, TRUE),
(3, 'Playera Polo Blanca', 280.00, TRUE),
(3, 'Guantes Antifrio',    150.00, FALSE),
(3, 'Bufanda Azul Marino', 200.00, FALSE);
