-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS suscripciones;

-- Usar la base de datos
USE suscripciones;

-- Crear la tabla para almacenar las suscripciones
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_barrio_edificio VARCHAR(100) NOT NULL,
    email_contacto VARCHAR(100) NOT NULL,
    tipo_cobro ENUM('debito', 'tarjeta') NOT NULL,
    plan_id INT NOT NULL,
    estado_suscripcion ENUM('activa', 'inactiva') NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (plan_id) REFERENCES planes(id)
);

-- Crear la tabla para almacenar los planes
CREATE TABLE planes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    costo_mensual DECIMAL(10, 2) NOT NULL
);

-- Insertar los planes disponibles
INSERT INTO planes (nombre, costo_mensual) VALUES
('Básico', 10000),
('Pro', 25000),
('Empresas', 70000);

-- Crear la tabla para almacenar los lotes de cobro
CREATE TABLE lotes_cobro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha_generacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    fecha_envio TIMESTAMP DEFAULT NULL,
    estado ENUM('generado', 'enviado') NOT NULL
);

-- Crear la tabla para almacenar los detalles de cobro por cada suscripción en un lote
CREATE TABLE lotes_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lote_id INT NOT NULL,
    cliente_id INT NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
   estado_periodo_cobro ENUM('generado', 'enviado_a_cobrar', 'pagado') NOT NULL,
    FOREIGN KEY (lote_id) REFERENCES lotes_cobro(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);
