<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STORLINE - Gestor de Tiendas</title>
    <link rel="stylesheet" href="css/index.css">
    
</head>
<body>
    <!-- Header -->
   <header>
    <div class="logo">
        <a href="index.php">
            <img src="log.png" alt="STORLINE Logo" class="logo-img">
        </a>
    </div>
    <nav class="nav-auth">
        <a href="php/auth/login.php" class="btn-login">Iniciar Sesión</a>
        <a href="php/auth/registro.php" class="btn-register">Registrarse</a>
    </nav>
</header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>STORLINE</h1>
            <p>Gestiona tus tiendas - Administra tus productos, clientes y deudas</p>
            <div class="cta-buttons">
                <a href="php/auth/registro.php" class="btn-cta btn-cta-primary">CREAR TIENDA</a>
                <a href="#features" class="btn-cta btn-cta-secondary">CONOCER MÁS</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="feature-card">
            <div class="feature-icon">🏢</div>
            <h3>Gestiona Múltiples Tiendas</h3>
            <p>Crea y administra todas tus tiendas desde un único panel de control centralizado.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📦</div>
            <h3>CRUD de Productos</h3>
            <p>Administra tu inventario con facilidad. Crea, edita, elimina y controla el stock de tus productos.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3>Gestión de Clientes</h3>
            <p>Mantén un registro completo de tus clientes con toda su información de contacto.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">💰</div>
            <h3>Control de Deudas</h3>
            <p>Registra y controla las deudas de tus clientes. Seguimiento de pagos y vencimientos.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Reportes y Estadísticas</h3>
            <p>Visualiza datos importantes sobre tus tiendas, productos y clientes en tiempo real.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h3>Seguridad Garantizada</h3>
            <p>Tu información está protegida con contraseñas encriptadas y sesiones seguras.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 STORLINE. Todos los derechos reservados.</p>
        <p>Desarrollado para gestionar tu negocio de forma eficiente.</p>
    </footer>
</body>
</html>