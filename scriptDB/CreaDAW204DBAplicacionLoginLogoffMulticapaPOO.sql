-- CREACION BASE DE DATOS
-- Creacion de la base de datos DAW215DBDepartamentos
CREATE DATABASE if NOT EXISTS DAW204DB_API_REST;
-- Creacion de tablas de la base de datos
CREATE TABLE IF NOT EXISTS DAW204DB_API_REST.Usuario(
    CodUsuario VARCHAR(10) PRIMARY KEY,
    Password VARCHAR(64) NOT NULL
)ENGINE=INNODB;
CREATE TABLE IF NOT EXISTS DAW204DB_API_REST.Persona(
    ID INT PRIMARY KEY,
    Nombre VARCHAR(25),
    Descripcion VARCHAR(50),
    Edad INT
)ENGINE=INNODB;

-- CREACION USUARIO ADMINISTRADOR
-- Creacion de usuario administrador de la base de datos: usuarioDAW215DBDepartamentos / paso
CREATE USER 'usuarioDAW204DB_API_REST'@'%' IDENTIFIED BY 'P@ssw0rd';
-- Permisos para la base de datos
GRANT ALL PRIVILEGES ON DAW204DB_API_REST.* TO 'usuarioDAW204DB_API_REST'@'%';