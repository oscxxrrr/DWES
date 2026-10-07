-- Base de datos shop1
CREATE DATABASE IF NOT EXISTS shop1;
USE shop1;

-- Tabla users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabla products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0
);

-- Tabla orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyerid INT NOT NULL,
    total_order DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    FOREIGN KEY (buyerid) REFERENCES users(id)
);

-- Tabla order_lines
CREATE TABLE IF NOT EXISTS order_lines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Datos de prueba
INSERT INTO users (username, password) VALUES
    ('admin', md5('admin')),
    ('oscar', md5('1234'));

INSERT INTO products (name, description, price, stock) VALUES
    ('Camiseta', 'Camiseta de algodón talla M', 15.99, 50),
    ('Pantalón', 'Pantalón vaquero talla 32', 39.99, 30),
    ('Zapatillas', 'Zapatillas deportivas talla 42', 59.99, 20),
    ('Gorra', 'Gorra visera plana negra', 12.50, 100);
