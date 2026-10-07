ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('usuario');
FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS blog;
USE blog;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL
);

INSERT INTO usuarios (nombre, email, contrasena) VALUES ('demo', 'demo@blog.local', MD5('demo'));