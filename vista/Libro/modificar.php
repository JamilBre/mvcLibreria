<?php
//Variables
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$titulo = isset($_REQUEST['titulo']) ? $_REQUEST['titulo'] : null;
$isbn = isset($_REQUEST['isbn']) ? $_REQUEST['isbn'] : null;
$editorial = isset($_REQUEST['editorial']) ? $_REQUEST['editorial'] : null;
$paginas = isset($_REQUEST['paginas']) ? $_REQUEST['paginas'] : null;
$idAutor = isset($_REQUEST['idAutor']) ? $_REQUEST['idAutor'] : null;
//Conecta con la base
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
//Comprabamos si recibimos datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Prepara UPDATE
    $miUpdate = $miPDO->prepare('UPDATE LIBRO SET titulo = :titulo, isbn= :isbn, editorial = :editorial, paginas = :paginas, idAutor = :idAutor WHERE id = :id');
    //Ejecutar UPDATE con los datos
    $miUpdate->execute(
        [
            'titulo' => $titulo,
            'isbn' => $isbn,
            'editorial' => $editorial,
            'paginas' => $paginas,
            'idAutor' => $idAutor,
            'id' => $id
        ]
    );
    //Redireccionamos a Leer
    header('Location: listar.php');
} else{
    //Prepara Select
    $miConsulta = $miPDO->prepare('SELECT * FROM LIBRO WHERE id = :id;');
    //Ejecutar consulta
    $miConsulta->execute(
        [
            'id' => $id
        ]
    );
}
//Obtiene un resultado
$libro = $miConsulta->fetch();
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
            <label for="titulo">Titulo</label>
            <input id="titulo" type="text" name="titulo" value="<?= $libro['titulo'] ?>">
        </p>
        <p>
            <label for="isbn">ISBN</label>
            <input id="isbn" type="text" name="isbn" value="<?= $libro['isbn'] ?>">
        </p>
        <p>
            <label for="editorial">Editorial</label>
            <input id="editorial" type="text" name="editorial" value="<?= $libro['editorial'] ?>">
        </p>
        <p>
            <label for="paginas">Páginas</label>
            <input id="paginas" type="num" name="paginas" value="<?= $libro['paginas'] ?>">
        </p>
        <p>
            <label for="idAutor">ID del Autor</label>
            <input id="idAutor" type="text" name="idAutor" value="<?= $libro['idAutor'] ?>">
        </p>
        <p>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Modificar">
        </p>
    </form>
</body>
</html>