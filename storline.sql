-- Base de datos para Gestor de Tiendas - STORLINE
-- =====================================================

CREATE DATABASE IF NOT EXISTS `storline`;
USE `storline`;

-- =====================================================
-- Tabla: USUARIOS (Dueños de tiendas)
-- =====================================================
CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del usuario',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre completo del dueño',
  `email` varchar(100) NOT NULL UNIQUE COMMENT 'Email único del usuario',
  `password` varchar(255) NOT NULL COMMENT 'Contraseña encriptada',
  `telefono` varchar(20) COMMENT 'Teléfono de contacto',
  `fecha_registro` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro',
  `activo` tinyint(1) DEFAULT 1 COMMENT 'Estado activo/inactivo',
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabla: TIENDAS
-- =====================================================
CREATE TABLE `tiendas` (
  `tienda_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la tienda',
  `usuario_id` int(11) NOT NULL COMMENT 'ID del dueño',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la tienda',
  `descripcion` text COMMENT 'Descripción de la tienda',
  `telefono` varchar(20) COMMENT 'Teléfono de la tienda',
  `ciudad` varchar(50) COMMENT 'Ciudad',
  `direccion` varchar(255) COMMENT 'Dirección de la tienda',
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `activa` tinyint(1) DEFAULT 1 COMMENT 'Tienda activa/inactiva',
  PRIMARY KEY (`tienda_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`usuario_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabla: CATEGORIAS
-- =====================================================
CREATE TABLE `categorias` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la categoría',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la categoría',
  `descripcion` text COMMENT 'Descripción',
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabla: PRODUCTOS
-- =====================================================
CREATE TABLE `productos` (
  `producto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del producto',
  `tienda_id` int(11) NOT NULL COMMENT 'ID de la tienda',
  `nombre` varchar(150) NOT NULL COMMENT 'Nombre del producto',
  `descripcion` text COMMENT 'Descripción del producto',
  `categoria_id` int(11) COMMENT 'Categoría del producto',
  `precio` decimal(10, 2) NOT NULL COMMENT 'Precio unitario',
  `stock` int(11) DEFAULT 0 COMMENT 'Stock disponible',
  `imagen` varchar(255) COMMENT 'Ruta de la imagen',
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `activo` tinyint(1) DEFAULT 1 COMMENT 'Producto activo/inactivo',
  PRIMARY KEY (`producto_id`),
  FOREIGN KEY (`tienda_id`) REFERENCES `tiendas`(`tienda_id`) ON DELETE CASCADE,
  FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`categoria_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabla: CLIENTES (Globales)
-- =====================================================
CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del cliente',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre del cliente',
  `email` varchar(100) COMMENT 'Email del cliente',
  `telefono` varchar(20) COMMENT 'Teléfono',
  `direccion` varchar(255) COMMENT 'Dirección',
  `ciudad` varchar(50) COMMENT 'Ciudad',
  `fecha_registro` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro',
  `activo` tinyint(1) DEFAULT 1 COMMENT 'Cliente activo',
  `tienda_id` int(11) DEFAULT NULL COMMENT 'Tienda asociada al cliente',
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabla: DEUDAS (Clientes por tienda)
-- =====================================================
CREATE TABLE `deudas` (
  `deuda_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la deuda',
  `tienda_id` int(11) NOT NULL COMMENT 'ID de la tienda',
  `cliente_id` int(11) NOT NULL COMMENT 'ID del cliente',
  `monto_total` decimal(10, 2) NOT NULL COMMENT 'Monto total adeudado',
  `monto_pagado` decimal(10, 2) DEFAULT 0 COMMENT 'Monto pagado',
  `descripcion` text COMMENT 'Descripción de la deuda',
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `fecha_vencimiento` date COMMENT 'Fecha de vencimiento',
  `estado` enum('pendiente', 'parcial', 'pagada') DEFAULT 'pendiente' COMMENT 'Estado de la deuda',
  PRIMARY KEY (`deuda_id`),
  FOREIGN KEY (`tienda_id`) REFERENCES `tiendas`(`tienda_id`) ON DELETE CASCADE,
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`cliente_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Índices adicionales para optimización
-- =====================================================
CREATE INDEX idx_usuario_tienda ON `tiendas`(`usuario_id`);
CREATE INDEX idx_tienda_producto ON `productos`(`tienda_id`);
CREATE INDEX idx_tienda_deuda ON `deudas`(`tienda_id`);
CREATE INDEX idx_cliente_deuda ON `deudas`(`cliente_id`);
CREATE INDEX idx_email_usuarios ON `usuarios`(`email`);
CREATE INDEX idx_email_clientes ON `clientes`(`email`);

--tabla ventas
CREATE TABLE `ventas` (
  `venta_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la venta',
  `tienda_id` int(11) NOT NULL COMMENT 'ID de la tienda donde se realizó la venta',
  `usuario_id` int(11) NOT NULL COMMENT 'Usuario que registró la venta',
  `cliente_id` int(11) DEFAULT NULL COMMENT 'Cliente asociado (solo para ventas a crédito o fiado)',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Subtotal de la venta',
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Descuento aplicado',
  `total` decimal(10,2) NOT NULL COMMENT 'Total final de la venta',
  `estado` enum('ACTIVA','ANULADA') NOT NULL DEFAULT 'ACTIVA' COMMENT 'Estado de la venta',
  `observaciones` text DEFAULT NULL COMMENT 'Observaciones adicionales',
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación de la venta',

  PRIMARY KEY (`venta_id`),

  KEY `idx_tienda` (`tienda_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_cliente` (`cliente_id`),

  CONSTRAINT `fk_ventas_tienda`
    FOREIGN KEY (`tienda_id`)
    REFERENCES `tiendas` (`tienda_id`)
    ON DELETE CASCADE,

  CONSTRAINT `fk_ventas_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`usuario_id`)
    ON DELETE CASCADE,

  CONSTRAINT `fk_ventas_cliente`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `clientes` (`cliente_id`)
    ON DELETE SET NULL

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;


-- tablas detalles ventas
CREATE TABLE `detalle_venta` (
  `detalle_venta_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del detalle de venta',
  `venta_id` int(11) NOT NULL COMMENT 'ID de la venta',
  `producto_id` int(11) NOT NULL COMMENT 'Producto vendido',
  `cantidad` int(11) NOT NULL COMMENT 'Cantidad vendida',
  `precio_unitario` decimal(10,2) NOT NULL COMMENT 'Precio unitario al momento de la venta',
  `subtotal` decimal(10,2) NOT NULL COMMENT 'Subtotal del producto',

  PRIMARY KEY (`detalle_venta_id`),

  KEY `idx_venta` (`venta_id`),
  KEY `idx_producto` (`producto_id`),

  CONSTRAINT `fk_detalle_venta_venta`
    FOREIGN KEY (`venta_id`)
    REFERENCES `ventas` (`venta_id`)
    ON DELETE CASCADE,

  CONSTRAINT `fk_detalle_venta_producto`
    FOREIGN KEY (`producto_id`)
    REFERENCES `productos` (`producto_id`)
    ON DELETE RESTRICT

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;