<?php
//Variables
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$idLibro = isset($_REQUEST['idLibro']) ? $_REQUEST['idLibro'] : null;
$localizacion = isset($_REQUEST['localizacion']) ? $_REQUEST['localizacion'] : null;
//Conecta con la base
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
//Comprabamos si recibimos datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Prepara UPDATE
    $miUpdate = $miPDO->prepare('UPDATE EJEMPLAR SET localizacion = :localizacion, idLibro = :idLibro  WHERE id = :id');
    //Ejecutar UPDATE con los datos
    $miUpdate->execute(
        [
            'id' => $id,
            'idLibro' => $idLibro,
            'localizacion' => $localizacion,
        ]
    );
    //Redireccionamos a Leer
    header('Location: listar.php');
} else{
    //Prepara Select
    $miConsulta = $miPDO->prepare('SELECT * FROM EJEMPLAR WHERE id = :id;');
    //Ejecutar consulta
    $miConsulta->execute(
        [
            'id' => $id
        ]
    );
}
//Obtiene un resultado
$ejemplar = $miConsulta->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar - CRUD PHP</title>
</head>
<body>
    <form method="post">
        <p>
            <label for="idLibro">Codigo del libro</label>
            <input id="idLibro" type="text" name="idLibro" value="<?= $autor['idLibro'] ?>">
        </p>
        <p>
            <label for="localizacion">Localizacion</label>
            <input id="localizacion" type="text" name="localizacion" value="<?= $autor['localizacion'] ?>">
        </p>
        <p>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Modificar">
        </p>
    </form>
</body>
</html>