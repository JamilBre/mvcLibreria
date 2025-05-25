<?php
// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conectar con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Obtener la lista de usuarios
$query = $miPDO->prepare('SELECT id, nombre FROM USUARIO');
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos las variables
    $idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : null;

    // Obtener ejemplares sacados por el usuario
    $query = $miPDO->prepare('
        SELECT E.id, L.titulo, P.fechaPrestamo, P.fechaDevolucion
        FROM EJEMPLAR E
        JOIN LIBRO L ON E.idLibro = L.id
        JOIN PRESTAMO P ON E.id = P.idEjemplar
        WHERE P.idUsuario = :idUsuario
    ');
    $query->bindParam(':idUsuario', $idUsuario);
    $query->execute();
    $ejemplares = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplares por Usuario - CRUD PHP</title>
</head>
<body>
    <form action="" method="post">
        <p>
            <label for="idUsuario">Seleccione Usuario</label>
            <select id="idUsuario" name="idUsuario" required>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>"><?= $usuario['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input type="submit" value="Buscar">
        </p>
    </form>

    <?php if (isset($ejemplares)): ?>
        <h2>Ejemplares sacados por el usuario</h2>
        <table border="1">
            <tr>
                <th>ID Ejemplar</th>
                <th>Título</th>
                <th>Fecha de Préstamo</th>
                <th>Fecha de Devolución</th>
            </tr>
            <?php foreach ($ejemplares as $ejemplar): ?>
                <tr>
                    <td><?= $ejemplar['id'] ?></td>
                    <td><?= $ejemplar['titulo'] ?></td>
                    <td><?= $ejemplar['fechaPrestamo'] ?></td>
                    <td><?= $ejemplar['fechaDevolucion'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
