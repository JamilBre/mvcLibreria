<?php
// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conectar con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Obtener la lista de préstamos sin devolución
$query = $miPDO->prepare('SELECT id, idEjemplar, idUsuario, fechaPrestamo FROM PRESTAMO WHERE fechaDevolucion IS NULL');
$query->execute();
$prestamos = $query->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos las variables
    $idPrestamo = isset($_POST['idPrestamo']) ? $_POST['idPrestamo'] : null;
    $fechaDevolucion = isset($_POST['fechaDevolucion']) ? $_POST['fechaDevolucion'] : null;

    // Preparar UPDATE
    $miUpdate = $miPDO->prepare('UPDATE PRESTAMO SET fechaDevolucion = :fechaDevolucion WHERE id = :idPrestamo');

    // Ejecutar UPDATE con los datos
    $miUpdate->bindParam(':idPrestamo', $idPrestamo);
    $miUpdate->bindParam(':fechaDevolucion', $fechaDevolucion);

    // Ejecutar la consulta
    $miUpdate->execute();

    // Redireccionamos a listar
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Devolución - CRUD PHP</title>
</head>
<body>
    <form action="" method="post">
        <p>
            <label for="idPrestamo">ID del Préstamo</label>
            <select id="idPrestamo" name="idPrestamo" required>
                <?php foreach ($prestamos as $prestamo): ?>
                    <option value="<?= $prestamo['id'] ?>">
                        <?= "Préstamo ID: {$prestamo['id']} - Ejemplar ID: {$prestamo['idEjemplar']} - Usuario ID: {$prestamo['idUsuario']} - Fecha Préstamo: {$prestamo['fechaPrestamo']}" ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="fechaDevolucion">Fecha de Devolución</label>
            <input id="fechaDevolucion" type="date" name="fechaDevolucion" required>
        </p>
        <p>
            <input type="submit" value="Registrar Devolución">
        </p>
    </form>
</body>
</html>
