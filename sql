create database BdBiblioteca;
use BdBiblioteca;

create table AUTOR (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100)
);

create table USUARIO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
	telefono  VARCHAR(9),
    direccion VARCHAR(100)
);

create table LIBRO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
	isbn   VARCHAR(17),
	editorial  VARCHAR(50),
	paginas		int,
    idAutor INT,
    FOREIGN KEY (idAutor) REFERENCES AUTOR(id)
);

create table EJEMPLAR (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idLibro INT,
    localizacion VARCHAR(50),
    FOREIGN KEY (idLibro) REFERENCES LIBRO(id)
);

create table PRESTAMO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idEjemplar INT,
    idUsuario INT,
    fechaPrestamo DATE,
    fechaDevolucion DATE,
    FOREIGN KEY (idEjemplar) REFERENCES EJEMPLAR(id),
    FOREIGN KEY (idUsuario) REFERENCES USUARIO(id)
);
-- Insertar autores
INSERT INTO AUTOR (nombre) VALUES 
('Gabriel García Márquez'),
('Mario Vargas Llosa'),
('Julio Cortázar');

-- Insertar usuarios
INSERT INTO USUARIO (nombre, telefono, direccion) VALUES 
('Ana Pérez', '987654321', 'Av. Siempre Viva 123'),
('Carlos Rodríguez', '912345678', 'Calle Falsa 456'),
('María López', '956789123', 'Jr. Principal 789');

-- Insertar libros
INSERT INTO LIBRO (titulo, isbn, editorial, paginas, idAutor) VALUES 
('Cien años de soledad', '978-3-16-148410-0', 'Sudamericana', 471, 1),
('La ciudad y los perros', '978-0-14-118549-1', 'Seix Barral', 472, 2),
('Rayuela', '978-84-204-2003-6', 'Editorial Alfaguara', 600, 3);

-- Insertar ejemplares
INSERT INTO EJEMPLAR (idLibro, localizacion) VALUES 
(1, 'Estante A1'),
(2, 'Estante B2'),
(3, 'Estante C3');


-- Insertar préstamos
INSERT INTO PRESTAMO (idEjemplar, idUsuario, fechaPrestamo, fechaDevolucion) VALUES 
(1, 1, '2025-05-01', '2025-05-15'),
(2, 2, '2025-05-03', '2025-05-17'),
(3, 3, '2025-05-05', '2025-05-20');