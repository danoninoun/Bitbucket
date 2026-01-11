≥	CREATE DATABASE IF NOT EXISTS empresa;
≥	USE empresa;
≥	-- Tabla Provincias
≥	CREATE TABLE IF NOT EXISTS provincias (
≥	    id_provincia INT AUTO_INCREMENT PRIMARY KEY,
≥	    nombre VARCHAR(100) NOT NULL
≥	);
≥	-- Tabla Departamentos
≥	CREATE TABLE IF NOT EXISTS departamentos (
≥	    id_departamento INT AUTO_INCREMENT PRIMARY KEY,
≥	    nombre VARCHAR(100) NOT NULL
≥	);
≥	-- Tabla Sedes (Relacionada con Provincias)
≥	CREATE TABLE IF NOT EXISTS sedes (
≥	    id_sede INT AUTO_INCREMENT PRIMARY KEY,
≥	    nombre VARCHAR(100) NOT NULL,
≥	    id_provincia INT,
≥	    FOREIGN KEY (id_provincia) REFERENCES provincias(id_provincia)
≥	);
≥	-- Tabla Empleados (La principal)
≥	CREATE TABLE IF NOT EXISTS empleados (
≥	    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
≥	    nombre VARCHAR(100) NOT NULL,
≥	    apellidos VARCHAR(100) NOT NULL,
≥	    dni VARCHAR(20) NOT NULL UNIQUE,
≥	    email VARCHAR(100) NOT NULL,
≥	    telefono VARCHAR(20),
≥	    fecha_alta DATE,
≥	    id_sede INT,
≥	    id_departamento INT,
≥	    FOREIGN KEY (id_sede) REFERENCES sedes(id_sede),
≥	    FOREIGN KEY (id_departamento) REFERENCES departamentos(id_departamento)
≥	);
