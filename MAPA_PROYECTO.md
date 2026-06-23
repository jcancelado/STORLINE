# 🗺️ Mapa del Proyecto STORLINE

```
c:\xampp\htdocs\STORLINE\
│
├── 📄 index.php                      ← PÁGINA PRINCIPAL (informativa + login/registro)
├── 📄 README.md                      ← Documentación completa
├── 📄 INSTALACION.md                 ← Guía de instalación rápida
├── 📄 storline.sql                   ← Base de datos SQL
├── 📄 rainanectar.sql                ← Anterior (se mantiene como backup)
│
├── 📁 php/
│   │
│   ├── 📄 conexion.php               ← Conexión a BD (actualizada a 'storline')
│   │
│   ├── 📁 auth/                      ← AUTENTICACIÓN
│   │   ├── 📄 login.php              ← Iniciar sesión
│   │   ├── 📄 registro.php           ← Crear cuenta
│   │   └── 📄 logout.php             ← Cerrar sesión
│   │
│   ├── 📁 dashboard/                 ← PANEL PRINCIPAL
│   │   └── 📄 index.php              ← Dashboard con estadísticas y tiendas
│   │
│   ├── 📁 tienda/                    ← GESTIÓN DE TIENDAS
│   │   ├── 📄 crear.php              ← Crear nueva tienda
│   │   ├── 📄 editar.php             ← Editar tienda
│   │   └── 📄 eliminar.php           ← Eliminar tienda
│   │
│   ├── 📁 productos/                 ← CRUD PRODUCTOS
│   │   ├── 📄 index.php              ← Listar productos
│   │   ├── 📄 crear.php              ← Crear producto
│   │   ├── 📄 editar.php             ← Editar producto
│   │   └── 📄 eliminar.php           ← Eliminar producto
│   │
│   ├── 📁 clientes/                  ← CRUD CLIENTES
│   │   ├── 📄 index.php              ← Listar clientes
│   │   ├── 📄 crear.php              ← Crear cliente
│   │   ├── 📄 editar.php             ← Editar cliente
│   │   └── 📄 eliminar.php           ← Eliminar cliente
│   │
│   ├── 📁 deudas/                    ← CRUD DEUDAS
│   │   ├── 📄 index.php              ← Listar deudas
│   │   ├── 📄 crear.php              ← Crear deuda
│   │   ├── 📄 editar.php             ← Editar deuda + Registrar pagos
│   │   └── 📄 eliminar.php           ← Eliminar deuda
│   │
│   ├── 📁 CRUD/                      ← Antiguo (se mantiene como backup)
│   ├── 📁 carro/                     ← Antiguo (se mantiene como backup)
│   ├── 📁 inicio-registro/           ← Antiguo (se mantiene como backup)
│   ├── 📁 seccion/                   ← Antiguo (se mantiene como backup)
│   └── 📁 insertar/                  ← Antiguo (se mantiene como backup)
│
├── 📁 css/                           ← Estilos
│   └── estilosprincipales.css        ← Estilos principales
│
├── 📁 img/                           ← Imágenes (se mantiene)
│
├── 📁 js/                            ← JavaScript (se mantiene)
│
└── 📁 recursos/                      ← Recursos (se mantiene)
```

---

## 🔄 Flujo de Navegación

```
                    ┌─────────────┐
                    │  index.php  │
                    │ (Inicio)    │
                    └──────┬──────┘
                           │
                    ┌──────┴──────┐
                    │             │
            ┌───────▼────────┐  ┌─▼──────────┐
            │   registro.php │  │  login.php │
            └────────┬───────┘  └─┬──────────┘
                     │            │
                     └──────┬─────┘
                            │
                    ┌───────▼──────────┐
                    │  dashboard.php   │
                    │  (Panel Prin.)   │
                    └─────┬────┬────┬──┘
                          │    │    │
        ┌─────────────────┼────┼────┼────────────────┐
        │                 │    │    │                │
    ┌───▼──────┐  ┌──────▼──┐  │  ┌▼─────────┐ ┌───▼──────┐
    │ Tiendas  │  │Productos│  │  │ Clientes │ │  Deudas  │
    │          │  │         │  │  │          │ │          │
    │-crear    │  │-crear   │  │  │-crear    │ │-crear    │
    │-editar   │  │-editar  │  │  │-editar   │ │-editar   │
    │-eliminar │  │-eliminar│  │  │-eliminar │ │-pagar    │
    └──────────┘  └─────────┘  │  └──────────┘ │-eliminar │
                                │              └──────────┘
                                └─ Cierre de Sesión
```

---

## 📊 Tabla de Módulos

| Módulo | Descripción | URL |
|--------|-------------|-----|
| **Inicio** | Página informativa | `/index.php` |
| **Registro** | Crear nueva cuenta | `/php/auth/registro.php` |
| **Login** | Iniciar sesión | `/php/auth/login.php` |
| **Dashboard** | Panel principal | `/php/dashboard/index.php` |
| **Tiendas** | Crear/editar tiendas | `/php/tienda/` |
| **Productos** | CRUD de productos | `/php/productos/` |
| **Clientes** | CRUD de clientes | `/php/clientes/` |
| **Deudas** | Gestionar deudas | `/php/deudas/` |

---

## 🗄️ Relaciones de Base de Datos

```
usuarios
  │
  └─── tiendas (1:N)
         │
         ├─── productos (1:N)
         │
         └─── deudas (1:N)
              │
              └─── clientes (N:1)

categorias ←─── productos
```

---

## 🔐 Permisos por Usuario

✅ **Propietario (autenticado)** puede:
- Crear y editar sus propias tiendas
- Gestionar productos de sus tiendas
- Ver y crear clientes
- Gestionar deudas de sus tiendas
- Registrar pagos

❌ **NO puede**:
- Ver tiendas de otros propietarios
- Editar productos de otras tiendas
- Eliminar clientes de otros propietarios

---

## 📈 Estadísticas en Dashboard

El dashboard muestra:
- Total de tiendas del usuario
- Total de productos en todas sus tiendas
- Total de clientes únicos
- Total de deudas pendientes ($)

---

**Última actualización**: 23 de Junio, 2026
