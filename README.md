# 🎌 OtakuShop

Plataforma de comercio electrónico especializada en productos de anime y cultura japonesa.

## 📋 Descripción

OtakuShop es una aplicación web full-stack desarrollada como Proyecto Final del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web. La plataforma permite a los usuarios navegar, comprar y gestionar productos relacionados con anime, manga y cultura japonesa.

## ✨ Características Principales

### Para Clientes
- 🛍️ Catálogo de productos con filtros avanzados (categoría, franquicia, búsqueda)
- 🛒 Carrito de compras interactivo
- 💳 Sistema de checkout y gestión de pedidos
- 👤 Perfiles de usuario personalizados
- 📦 Historial de compras
- ⭐ Productos destacados y sistema de preventas

### Para Administradores
- 📊 Dashboard con estadísticas en tiempo real
- 📦 Gestión completa de productos (CRUD)
- 🏷️ Gestión de categorías y franquicias
- 📋 Gestión de pedidos y cambio de estados
- 👥 Sistema de roles (Admin/Cliente)
- 🖼️ Subida y gestión de imágenes

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 8.2+**
- **Laravel 11** - Framework PHP
- **MySQL** - Base de datos relacional
- **Eloquent ORM** - Gestión de base de datos

### Frontend
- **HTML5**
- **CSS3**
- **Bootstrap 5.3** - Framework CSS
- **JavaScript (ES6+)** - Interactividad
- **Blade Templates** - Motor de plantillas

### Herramientas
- **Composer** - Gestor de dependencias PHP
- **NPM** - Gestor de paquetes JavaScript
- **Git** - Control de versiones
- **XAMPP** - Entorno de desarrollo local

## 📦 Requisitos Previos

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- XAMPP/LARAGON (recomendado para desarrollo local)

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/TU-USUARIO/otakushop.git
cd otakushop
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de JavaScript

```bash
npm install
```

### 4. Configurar el archivo .env

```bash
# Copiar el archivo de ejemplo
cp .env.example .env

# Generar la clave de la aplicación
php artisan key:generate
```

### 5. Configurar la base de datos

Edita el archivo `.env` con tus credenciales:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=otakushop_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Crear la base de datos

Abre phpMyAdmin o tu cliente MySQL y ejecuta:

```sql
CREATE DATABASE otakushop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Ejecutar migraciones y seeders

```bash
# Ejecutar migraciones
php artisan migrate

# Cargar datos de ejemplo
php artisan db:seed
```

### 8. Crear enlace simbólico para imágenes

```bash
php artisan storage:link
```

### 9. Compilar assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 10. Iniciar el servidor

```bash
php artisan serve
```

Visita: `http://localhost:8000`

## 👤 Usuarios de Prueba

### Administrador
- **Email:** admin@otakushop.com
- **Password:** admin123

### Cliente
- **Email:** cliente@otakushop.com
- **Password:** cliente123

## 📁 Estructura del Proyecto

```
otakushop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── FranchiseController.php
│   │   │   │   └── OrderController.php
│   │   │   ├── HomeController.php
│   │   │   ├── CartController.php
│   │   │   └── OrderController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       ├── Category.php
│       ├── Franchise.php
│       ├── Order.php
│       ├── OrderItem.php
│       └── CartItem.php
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   │   └── custom.css
│   └── js/
│       └── app.js
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── admin.blade.php
│       ├── admin/
│       ├── auth/
│       └── ...
└── routes/
    └── web.php
```

## 🎨 Características de Diseño

- ✅ Diseño responsive (móvil, tablet, desktop)
- ✅ Animaciones CSS y JavaScript
- ✅ Gradientes modernos
- ✅ Efectos hover interactivos
- ✅ Notificaciones toast
- ✅ Loading spinners
- ✅ Validación de formularios en tiempo real

## 📊 Base de Datos

### Tablas Principales
- **users** - Usuarios del sistema
- **products** - Productos del catálogo
- **categories** - Categorías de productos
- **franchises** - Franquicias de anime
- **orders** - Pedidos realizados
- **order_items** - Items de cada pedido
- **cart_items** - Productos en el carrito

## 🔐 Seguridad

- ✅ Autenticación con Laravel Breeze
- ✅ Protección CSRF
- ✅ Middleware de roles
- ✅ Validación de datos
- ✅ Hash de contraseñas (bcrypt)
- ✅ Protección de rutas

## 📝 Funcionalidades Futuras

- [ ] Sistema de reseñas y valoraciones
- [ ] Pasarela de pago real (Stripe/PayPal)
- [ ] Sistema de cupones y descuentos
- [ ] Notificaciones por email
- [ ] Lista de deseos
- [ ] Comparador de productos
- [ ] Sistema de puntos y recompensas
- [ ] API RESTful

## 👨‍💻 Autor

**Antonio Ciobanu Amaya**
- Centro: IES Barajas
- Ciclo: CFGS Desarrollo de Aplicaciones Web
- Tutora: Evgeniya Vartanova
- Fecha: Octubre 2025

## 📄 Licencia

Este proyecto es parte de un trabajo académico del CFGS de Desarrollo de Aplicaciones Web.

## 🙏 Agradecimientos

- IES Barajas
- Evgeniya Vartanova (Tutora)
- Comunidad de Laravel
- Bootstrap Team

## 📞 Contacto

Para cualquier consulta sobre el proyecto:
- GitHub: [@antonio1690](https://github.com/antonio1690)
- Email: tu-email@ejemplo.com

---

⭐ Si te gusta este proyecto, dale una estrella en GitHub!

Made with ❤️ and ☕ by Antonio Ciobanu Amaya