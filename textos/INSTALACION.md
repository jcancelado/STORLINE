# ⚡ INSTALACIÓN RÁPIDA - STORLINE

## Paso 1: Crear la Base de Datos

1. Abre **phpMyAdmin**: http://localhost/phpmyadmin
2. En el panel izquierdo, haz clic en "Nueva"
3. **Opción A: Importar archivo SQL**
   - Haz clic en la pestaña "Importar"
   - Selecciona el archivo: `c:\xampp\htdocs\STORLINE\storline.sql`
   - Haz clic en "Ejecutar"

4. **Opción B: Crear manualmente**
   - Copia todo el contenido de `storline.sql`
   - Pégalo en la pestaña "SQL" de phpMyAdmin
   - Haz clic en "Ejecutar"

## Paso 2: Verificar la Conexión

1. Abre `php/conexion.php`
2. Verifica que tenga:
   ```php
   $servidor="localhost";
   $usuario="root";
   $clave="";
   $base="storline";
   ```

## Paso 3: Acceder a la Aplicación

1. En tu navegador, ve a: **http://localhost/STORLINE/**
2. Verás la página principal de STORLINE

## Paso 4: Crear tu Cuenta

1. Haz clic en **"Registrarse"**
2. Completa el formulario con:
   - Nombre Completo
   - Email
   - Contraseña (mín. 6 caracteres)
   - Teléfono (opcional)
3. Haz clic en **"Crear Cuenta"**

## Paso 5: Iniciar Sesión

1. Haz clic en **"Iniciar Sesión"**
2. Usa las credenciales que acabas de crear
3. ¡Accederás al Dashboard!

## Paso 6: Crear tu Primera Tienda

1. En el Dashboard, haz clic en **"+ Nueva Tienda"**
2. Completa:
   - Nombre de la tienda (ej: "Mi Tienda Principal")
   - Descripción (ej: "Tienda de electrodomésticos")
   - Ciudad
   - Teléfono
   - Dirección
3. Haz clic en **"Crear Tienda"**

## Paso 7: Comenzar a Usar

¡Listo! Ahora puedes:
- ➕ Agregar productos a tu tienda
- 👥 Registrar clientes
- 💰 Crear y controlar deudas
- 📊 Ver estadísticas en tiempo real

---

## ❌ Solución de Problemas

### "Error en la conexión"
- Verifica que XAMPP está corriendo (Apache + MySQL)
- Comprueba que la BD `storline` existe en phpMyAdmin

### "Página en blanco"
- Abre la consola del navegador (F12)
- Busca errores en la pestaña "Console"
- Verifica los logs de PHP en XAMPP

### "No puedo iniciar sesión"
- Verifica que tu email y contraseña son correctos
- Intenta limpiar cookies (Ctrl+Shift+Delete)

### "Las deudas no se ven"
- Primero crea un cliente
- Luego crea una deuda para ese cliente

---

**¿Necesitas ayuda?** Revisa el archivo `README.md` para más información detallada.
