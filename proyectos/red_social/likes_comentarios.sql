-- Tabla para los likes de comentarios
CREATE TABLE IF NOT EXISTS likes_comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    comentario_id INT NOT NULL,
    UNIQUE KEY unique_like (usuario_id, comentario_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (comentario_id) REFERENCES comentarios(id) ON DELETE CASCADE
);

