# 🏪 STORLINE - Gestor de Tiendas

Sistema de gestión completo para administrar múltiples tiendas, productos, clientes y deudas.

## 📋 Características

✅ **Gestión de Tiendas**: Crea y administra múltiples tiendas desde un panel central
✅ **CRUD de Productos**: Gestiona el inventario de cada tienda (crear, editar, eliminar, cambiar stock)
✅ **Gestión de Clientes**: Registro global de clientes con información de contacto
✅ **Control de Deudas**: Registra deudas, pagos parciales y realiza seguimiento

## 🚀 Instalación Rápida

### 1️⃣ Crear la Base de Datos

Abre **phpMyAdmin** (http://localhost/phpmyadmin) y ejecuta el archivo `storline.sql`:

```bash
c:\xampp\htdocs\STORLINE\storline.sql
```

O simplemente importa el archivo directamente en phpMyAdmin.

### 2️⃣ Acceder a la Aplicación

- **URL**: http://localhost/STORLINE/
- **Página Principal**: Verás información sobre STORLINE con botones para Iniciar Sesión y Registrarse

## 📚 Flujo de Uso

### 1. Registrarse
- Ve a `http://localhost/STORLINE/php/auth/registro.php`
- Crea tu cuenta con:
  - Nombre Completo
  - Email
  - Contraseña (mín. 6 caracteres)
  - Teléfono (opcional)

### 2. Iniciar Sesión
- Ve a `http://localhost/STORLINE/php/auth/login.php`
- Usa tus credenciales de registro

### 3. Dashboard Principal
Verás:
- **Estadísticas**: Total de tiendas, productos, clientes y deudas pendientes
- **Tus Tiendas**: Listado de todas tus tiendas
- **Acciones Rápidas**: Botones para acceder a Productos, Clientes y Deudas de cada tienda

### 4. Crear tu Primera Tienda
- Haz clic en **"+ Nueva Tienda"**
- Completa:
  - Nombre de la tienda (obligatorio)
  - Descripción
  - Teléfono
  - Ciudad
  - Dirección

### 5. Gestionar Productos (por tienda)
- Desde el Dashboard, haz clic en **📦 Productos** de una tienda
- **Crear**: Haz clic en **"+ Nuevo Producto"**
  - Nombre (obligatorio)
  - Descripción
  - Categoría
  - Precio (obligatorio)
  - Stock inicial
- **Editar/Eliminar**: Usa los botones en la tabla de productos

### 6. Gestionar Clientes (global)
- Desde el Dashboard, haz clic en **👥 Clientes** de una tienda
- **Crear**: Haz clic en **"+ Nuevo Cliente"**
  - Nombre (obligatorio)
  - Email
  - Teléfono
  - Ciudad
  - Dirección
- **Editar**: Actualiza información del cliente

### 7. Registrar y Gestionar Deudas
- Desde el Dashboard, haz clic en **💰 Deudas** de una tienda
- **Crear Deuda**: Haz clic en **"+ Nueva Deuda"**
  - Selecciona un cliente
  - Monto total de la deuda
  - Fecha de vencimiento (opcional)
  - Descripción
- **Registrar Pagos**: 
  - Haz clic en **Editar** en una deuda
  - Tab "Registrar Pago"
  - Ingresa el monto a pagar
  - El estado cambia automáticamente a "Parcial" o "Pagada"

## 🗄️ Estructura de la Base de Datos

### Tabla: usuarios
- usuario_id (PK)
- nombre
- email (UNIQUE)
- password (encriptada con BCRYPT)
- telefono
- fecha_registro
- activo

### Tabla: tiendas
- tienda_id (PK)
- usuario_id (FK → usuarios)
- nombre
- descripcion
- telefono
- ciudad
- direccion
- fecha_creacion
- activa

### Tabla: productos
- producto_id (PK)
- tienda_id (FK → tiendas)
- nombre
- descripcion
- categoria_id (FK → categorias)
- precio
- stock
- imagen
- fecha_creacion
- activo

### Tabla: clientes
- cliente_id (PK)
- nombre
- email
- telefono
- direccion
- ciudad
- fecha_registro
- activo

### Tabla: deudas
- deuda_id (PK)
- tienda_id (FK → tiendas)
- cliente_id (FK → clientes)
- monto_total
- monto_pagado (default 0)
- descripcion
- fecha_creacion
- fecha_vencimiento
- estado (pendiente | parcial | pagada)

### Tabla: categorias
- categoria_id (PK)
- nombre
- descripcion

## 🔒 Seguridad

✅ Contraseñas encriptadas con BCRYPT
✅ Validación de sesiones
✅ Verificación de permisos por usuario
✅ Protección contra inyección SQL con mysqli_real_escape_string

## 📱 Acceso por Rol

### Propietario (Dueño de Tienda)
- Crear/Editar/Eliminar tiendas
- Gestionar productos de sus tiendas
- Ver y gestionar clientes de sus tiendas
- Registrar y controlar deudas
- Registrar pagos

## 🎯 Tips de Uso

1. **Clientes Globales**: Los clientes se crean globalmente en el sistema, pero las deudas son por tienda
2. **Estados de Deuda**: 
   - Pendiente = sin pagos
   - Parcial = pagos parciales
   - Pagada = deuda liquidada
3. **Editar Tienda**: Haz clic en **✏️ Editar** en la tarjeta de la tienda desde el Dashboard
4. **Desactivar Tienda**: En la edición de tienda puedes desactivarla sin eliminarla

## 📞 Soporte

Si tienes problemas:
1. Verifica que la BD `storline` está creada correctamente
2. Comprueba que la contraseña en `php/conexion.php` es correcta
3. Asegúrate de que XAMPP está corriendo
4. Limpia el cache del navegador (Ctrl+Shift+Delete)

## 📝 Notas de Desarrollo

- PHP 7.4+ requerido
- MySQL/MariaDB
- No se requieren dependencias externas (PHP puro)
- Compatible con XAMPP

---

1.2 (seccion de ventas)

STORLINE
Módulo de Ventas

Descripción

Este módulo permite registrar ventas dentro de una tienda, controlar inventario, generar facturas y administrar el historial de ventas.

Todas las operaciones se realizan únicamente sobre las tiendas pertenecientes al usuario autenticado.

--------------------------------------------------

FUNCIONALIDADES IMPLEMENTADAS

Registro de ventas.

Buscador de productos en tiempo real.

Selección rápida de productos.

Control de cantidades.

Cálculo automático del subtotal.

Cálculo automático del total.

Pago exacto.

Registro del monto recibido.

Estado del pago.

Generación automática de factura.

Historial de ventas.

Visualización de facturas.

Anulación de ventas.

Devolución automática del inventario al anular.

Filtros por:

Número de factura.

Fecha.

Estado de la venta.

Estado del pago.

Validación de inventario tanto en JavaScript como en PHP.

--------------------------------------------------

VALIDACIONES

No permite registrar ventas vacías.

No permite vender cantidades mayores al stock.

No permite cantidades menores a 1.

No permite registrar productos inexistentes.

No permite registrar productos de otra tienda.

Los productos sin stock aparecen en la búsqueda pero no pueden agregarse.

Si el stock cambia mientras otro usuario vende, PHP vuelve a validar antes de registrar la venta.

Todas las operaciones críticas utilizan transacciones MySQL.

--------------------------------------------------

ESTADOS DE LA VENTA

ACTIVA

ANULADA

--------------------------------------------------

ESTADOS DEL PAGO

PAGADA

PARCIAL

PENDIENTE

--------------------------------------------------

ESTRUCTURA

php/

ventas/

crear.php

guardar.php

ver.php

index.php

eliminar.php

js/

ventas_crear.js

css/

php_ventas_crear.css

--------------------------------------------------

RUTAS

Crear venta

php/ventas/crear.php?tienda_id=ID

Guardar venta

php/ventas/guardar.php

Ver factura

php/ventas/ver.php?venta_id=ID

Historial

php/ventas/index.php?tienda_id=ID

Anular venta

php/ventas/eliminar.php?venta_id=ID

--------------------------------------------------

TABLAS UTILIZADAS

usuarios

tiendas

productos

ventas

detalle_venta

--------------------------------------------------

CAMPOS IMPORTANTES

ventas

venta_id

tienda_id

usuario_id

cliente_id

subtotal

total

monto_pagado

estado

estado_pago

fecha_creacion

detalle_venta

detalle_venta_id

venta_id

producto_id

cantidad

precio_unitario

subtotal

productos

producto_id

nombre

precio

stock

activo

--------------------------------------------------

CONSIDERACIONES

La venta solo puede realizarse sobre tiendas pertenecientes al usuario autenticado.

Todas las modificaciones de inventario se realizan dentro de una transacción.

La anulación devuelve automáticamente el inventario.

Actualmente no existe integración con el módulo de clientes ni con el sistema de deudas.

El módulo quedó preparado para futuras integraciones.



**STORLINE v1.2** - 2026

