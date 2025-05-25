<?php
//variables
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';
//conecta con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
//Obtiene codigo del libro a borrar
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
//Prepara delete
$miConsulta = $miPDO->prepare('DELETE FROM EJEMPLAR WHERE id = :id');
//Ejectura consulta SQL
$miConsulta->execute(
    [
        'id' => $id
    ]
);
//Redireccionarmos a la pagina principal
header('Location: listar.php');
?>