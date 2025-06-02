<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos las variables
    $titulo = $_POST['titulo'] ?? null;
    $isbn = $_POST['isbn'] ?? null;
    $editorial = $_POST['editorial'] ?? null;
    $paginas = $_POST['paginas'] ?? null;
    $idAutor = $_POST['idAutor'] ?? null;
    
    // Validación básica
    if (empty($titulo) || empty($isbn) || empty($idAutor)) {
        die("Por favor complete todos los campos requeridos");
    }

    // Conexión a la base de datos
    try {
        $hostDB = '127.0.0.1';
        $nombreDB = 'BdBiblioteca';
        $usuarioDB = 'root';
        $contrasenaDB = '';
        $miPDO = new PDO("mysql:host=$hostDB;dbname=$nombreDB;charset=utf8", $usuarioDB, $contrasenaDB);
        $miPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar que el autor existe
        $stmt = $miPDO->prepare('SELECT 1 FROM AUTOR WHERE id = ?');
        $stmt->execute([$idAutor]);
        if (!$stmt->fetch()) {
            die("Error: El autor seleccionado no existe");
        }

        // Insertar el libro
        $miInsert = $miPDO->prepare('INSERT INTO LIBRO (titulo, isbn, editorial, paginas, idAutor) 
                                   VALUES (:titulo, :isbn, :editorial, :paginas, :idAutor)');
        $miInsert->execute([
            'titulo' => $titulo,
            'isbn' => $isbn,
            'editorial' => $editorial,
            'paginas' => $paginas,
            'idAutor' => $idAutor
        ]);

        header('Location: listar.php');
        exit;
    } catch (PDOException $e) {
        die("Error de base de datos: " . $e->getMessage());
    }
}

// Obtener autores para el dropdown
try {
    $hostDB = '127.0.0.1';
    $nombreDB = 'BdBiblioteca';
    $usuarioDB = 'root';
    $contrasenaDB = '';
    $miPDO = new PDO("mysql:host=$hostDB;dbname=$nombreDB;charset=utf8", $usuarioDB, $contrasenaDB);
    $autores = $miPDO->query('SELECT id, nombre FROM AUTOR ORDER BY nombre');
} catch (PDOException $e) {
    die("Error al obtener autores: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Libro</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Crear Nuevo Libro</h1>
    <form action="" method="post">
        <p>
            <label for="titulo">Título del Libro*:</label>
            <input id="titulo" type="text" name="titulo" required>
        </p>
        <p>
            <label for="isbn">ISBN*:</label>
            <input id="isbn" type="text" name="isbn" required>
        </p>
        <p>
            <label for="editorial">Editorial:</label>
            <input id="editorial" type="text" name="editorial">
        </p>
        <p>
            <label for="paginas">Páginas:</label>
            <input id="paginas" type="number" name="paginas" min="1">
        </p>
        <p>
            <label for="idAutor">Autor*:</label>
            <select id="idAutor" name="idAutor" required>
                <option value="">-- Seleccione un autor --</option>
                <?php foreach ($autores as $autor): ?>
                <option value="<?= htmlspecialchars($autor['id']) ?>">
                    <?= htmlspecialchars($autor['nombre']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input type="submit" value="Guardar">
            <a href="listar.php">Cancelar</a>
        </p>
    </form>
</body>
</html>