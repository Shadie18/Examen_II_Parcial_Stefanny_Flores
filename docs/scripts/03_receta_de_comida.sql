CREATE TABLE RecetasComida (
    id_receta INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    ingrediente_principal VARCHAR(50),
    dificultad VARCHAR(20),
    tiempo_preparacion_min INT,
    tipo_cocina VARCHAR(50)
);