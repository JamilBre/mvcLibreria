<?php
//Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recogemos las variables
    $titulo = isset($_REQUEST['titulo']) ? $_REQUEST['titulo'] : null;
    $isbn = isset($_REQUEST['isbn']) ? $_REQUEST['isbn'] : null;
    $editorial = isset($_REQUEST['editorial']) ? $_REQUEST['editorial'] : null;
    $paginas = isset($_REQUEST['paginas']) ? $_REQUEST['paginas'] : null;
    $idAutor = isset($_REQUEST['idAutor']) ? $_REQUEST['idAutor'] : null;
    //Variables
    $hostDB = '127.0.0.1';
    $nombreDB = 'BdBiblioteca';
    $usuarioDB = 'root';
    $contrasenaDB = '';
    //Conecta con la base
    $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
    //Prepara insert
    $miInsert = $miPDO->prepare('INSERT INTO LIBRO (titulo, isbn, editorial, paginas, idAutor) VALUES (:titulo, :isbn, :editorial, :paginas, :idAutor)');
    //Ejecuta INSERT con los datos
    $miInsert->execute(
        array(
            'titulo' => $titulo,
            'isbn' => $isbn,
            'editorial' => $editorial,
            'paginas' => $paginas,
            'idAutor' => $idAutor
        )
    );
    //Redireccionamos a leer
    header('Location: listar.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear - CRUD PHP</title>
</head>
<body>
    <form action="" method="post">
    <p>
        <label for="titulo">Titulo del Libro</label>
        <input id="titulo" type="text" name="titulo">
    </p>
    <p>
        <label for="isbn">ISBN</label>
        <input id="isbn" type="text" name="isbn">
    </p>
    <p>
        <label for="editorial">Editorial</label>
        <input id="editorial" type="text" name="editorial">
    </p>
    <p>
        <label for="paginas">Páginas</label>
        <input id="paginas" type="num" name="paginas">
    </p>
    <p>
        <label for="idAutor">ID del Autor</label>
        <input id="idAutor" type="num" name="idAutor">
    </p>
    <p>
        <input type="submit" value="Guardar">
    </p>
    </form>
</body>
</html>