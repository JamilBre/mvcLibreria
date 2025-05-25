<?php
// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conectar con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Obtener la lista de ejemplares
$query = $miPDO->prepare('SELECT id, idLibro FROM EJEMPLAR');
$query->execute();
$ejemplares = $query->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos las variables
    $idEjemplar = isset($_POST['idEjemplar']) ? $_POST['idEjemplar'] : null;
    $idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : null;
    $fechaPrestamo = isset($_POST['fechaPrestamo']) ? $_POST['fechaPrestamo'] : null;

    // Preparar INSERT
    $miInsert = $miPDO->prepare('INSERT INTO PRESTAMO (idEjemplar, idUsuario, fechaPrestamo) VALUES (:idEjemplar, :idUsuario, :fechaPrestamo)');

    // Ejecutar INSERT con los datos
    $miInsert->bindParam(':idEjemplar', $idEjemplar);
    $miInsert->bindParam(':idUsuario', $idUsuario);
    $miInsert->bindParam(':fechaPrestamo', $fechaPrestamo);

    // Ejecutar la consulta
    $miInsert->execute();

    // Redireccionamos a la pagina principal
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Préstamo - CRUD PHP</title>
</head>
<body>
    <form action="" method="post">
        <p>
            <label for="idEjemplar">ID del Ejemplar</label>
            <select id="idEjemplar" name="idEjemplar" required>
                <?php foreach ($ejemplares as $ejemplar): ?>
                    <option value="<?= $ejemplar['id'] ?>"><?= $ejemplar['idLibro'] ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="idUsuario">ID del Usuario</label>
            <input id="idUsuario" type="number" name="idUsuario" required>
        </p>
        <p>
            <label for="fechaPrestamo">Fecha de Préstamo</label>
            <input id="fechaPrestamo" type="date" name="fechaPrestamo" required>
        </p>
        <p>
            <input type="submit" value="Registrar Préstamo">
        </p>
    </form>
</body>
</html>
