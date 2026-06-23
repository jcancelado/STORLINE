<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STORLINE - Gestor de Tiendas</title>
    <link rel="stylesheet" href="css/estilosprincipales.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
            text-decoration: none;
        }

        .nav-auth {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-login, .btn-register {
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-login {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-login:hover {
            background: #667eea;
            color: white;
        }

        .btn-register {
            background: #667eea;
            color: white;
        }

        .btn-register:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
            color: white;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            animation: slideInDown 0.8s ease;
        }

        .hero-content p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: slideInUp 0.8s ease;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeIn 1s ease 0.3s both;
        }

        .btn-cta {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-cta-primary {
            background: white;
            color: #667eea;
        }

        .btn-cta-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-cta-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-cta-secondary:hover {
            background: white;
            color: #667eea;
            transform: scale(1.05);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Features Section */
        .features {
            background: white;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        footer p {
            margin: 0.5rem 0;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-cta {
                width: 100%;
                max-width: 300px;
            }

            header {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-auth {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">🏪 STORLINE</div>
        <nav class="nav-auth">
            <a href="php/auth/login.php" class="btn-login">Iniciar Sesión</a>
            <a href="php/auth/registro.php" class="btn-register">Registrarse</a>
        </nav>
    </header>

        <button id="toggle-nav" class="toggle-nav-btn">☰</button>

        <section class="textos-header">
            <h1 style='--content: "RAN"; --star-color: #e53232; --end-color: #f1e314; --delay: 0s;'>RAN</h1>
            <h2 style='--content: "R A I N   A  N E C T A R"; --star-color: #4d32e5d2; --end-color: #00ff6ad0; --delay: 0s; '>R A I N  A N E C T A R</h2>

        </section>
        <div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
         </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>STORLINE</h1>
            <p>Gestor completo de tiendas - Administra tus productos, clientes y deudas</p>
            <div class="cta-buttons">
                <a href="php/auth/registro.php" class="btn-cta btn-cta-primary">Crear Mi Tienda Ahora</a>
                <a href="#features" class="btn-cta btn-cta-secondary">Conocer Más</a>
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