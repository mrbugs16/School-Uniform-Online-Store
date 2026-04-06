# 🎓 Uniformes Escolares — Tienda en Línea

Plataforma web para que padres de familia y alumnos puedan comprar uniformes escolares en línea. Desarrollado con PHP, MySQL, HTML y Bootstrap 5, siguiendo el patrón MVC visto en clase.

---

## 📋 Requisitos previos

Tener instalado en tu computadora:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/)

---

## 🚀 Cómo correr el proyecto

### 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd uniformes
```

### 2. Levantar los contenedores con Docker

```bash
docker compose up -d
```

Este comando levanta automáticamente:

| Contenedor | Descripción | Puerto |
|---|---|---|
| `lamp_nginx` | Servidor web Nginx | `https://localhost` |
| `lamp_php` | PHP 8.4 FPM | interno |
| `lamp_db` | MySQL 8.4 | `3306` |
| `lamp_phpmyadmin` | Panel visual de BD | `http://localhost:8080` |

> La base de datos se crea sola al primer `docker compose up`. El archivo `db/uniformes_db.sql` se carga automáticamente.

### 3. Abrir el proyecto en el navegador

```
https://localhost
```

> El navegador mostrará una advertencia de certificado SSL porque usamos un certificado local autofirmado. Haz clic en **"Avanzado → Continuar"** para acceder.

---

## 🔑 Usuarios de prueba

| Usuario | Contraseña | Rol |
|---|---|---|
| `admin` | `password123` | Superusuario |
| `santiago` | `password123` | Usuario |
| `ana` | `password123` | Usuario |

---

## 📁 Estructura del proyecto

```
uniformes/
├── docker-compose.yml
├── Dockerfile.php
├── nginx.conf
├── certs/
│   ├── cert.pem
│   └── key.pem
├── db/
│   └── uniformes_db.sql       ← Script SQL (se carga automático)
└── src/                       ← Raíz del servidor web
    ├── db_cnx.php             ← Conexión PDO a MySQL
    ├── login.php              ← Vista: inicio de sesión
    ├── loginCNT.php           ← Controlador: login
    ├── registro.php           ← Vista: registro de usuario
    ├── registroCNT.php        ← Controlador: registro
    ├── catalogo.php           ← Vista: catálogo de prendas
    ├── carrito.php            ← Vista: carrito de compras
    ├── carritoCNT.php         ← Controlador: agregar al carrito
    ├── pagarCNT.php           ← Controlador: confirmar pedido
    ├── logout.php             ← Cerrar sesión
    ├── models/
    │   ├── Validator.php      ← Clase con validaciones estáticas
    │   ├── Usuario.php        ← Modelo entidad Usuario
    │   ├── Categoria.php      ← Modelo entidad Categoría
    │   ├── Prenda.php         ← Modelo entidad Prenda
    │   └── Pedido.php         ← Modelo entidad Pedido
    └── admin/
        └── usuarios.php       ← Vista admin (solo superusuario)
```

---

## 🗄️ Base de datos

### Diagrama de entidades

```
usuarios ──< pedidos ──< detalle_pedido >── prendas >── categorias
```

### Tablas

| Tabla | Descripción |
|---|---|
| `usuarios` | Usuarios registrados con rol (usuario / superusuario) |
| `categorias` | Deportes, Uso Casual, Gala |
| `prendas` | Prendas con precio, categoría y si tienen talla |
| `pedidos` | Órdenes de compra por usuario |
| `detalle_pedido` | Prendas, tallas y cantidades por pedido |

---

## 🏗️ Patrón MVC

El proyecto sigue el patrón Modelo-Vista-Controlador tal como se trabajó en clase:

- **Modelo** — Clases PHP en `src/models/` con métodos estáticos que hacen consultas a la BD usando PDO.
- **Vista** — Archivos `.php` con HTML y Bootstrap que muestran la información al usuario.
- **Controlador** — Archivos `*CNT.php` que reciben el `POST`, validan con `Validator`, llaman al modelo y redirigen con `header()`.

---

## 🛠️ Comandos útiles de Docker

```bash
# Levantar los contenedores
docker compose up -d

# Ver logs en tiempo real
docker compose logs -f

# Detener los contenedores
docker compose down

# Detener y borrar la base de datos (reset completo)
docker compose down -v

# Entrar al contenedor PHP
docker exec -it lamp_php bash

# Entrar al contenedor MySQL
docker exec -it lamp_db mysql -u ougalde -p arqweb
```

---

## ⚙️ Configuración de Docker

El `docker-compose.yml` define 4 servicios conectados en la red `lamp-network`:

```yaml
nginx  →  php  →  db
               ↓
          phpmyadmin
```

El volumen `dbdataP26` persiste la base de datos entre reinicios. Para resetear completamente la BD usa `docker compose down -v` antes de volver a levantar.

---

## 📦 Tecnologías utilizadas

| Tecnología | Versión |
|---|---|
| PHP | 8.4 FPM |
| MySQL | 8.4 |
| Nginx | Latest |
| Bootstrap | 5.3.8 |
| Docker | Compose v3 |

---

## 👥 Integrantes

- Santiago Tapia

---

## 📚 Materia

Arquitectura Web — Universidad Iberoamericana
