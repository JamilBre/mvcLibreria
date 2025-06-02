<?php
// Iniciar sesión para mensajes flash
session_start();

// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

try {
    // Conecta con la base de datos
    $miPDO = new PDO("mysql:host=$hostDB;dbname=$nombreDB;charset=utf8", $usuarioDB, $contrasenaDB);
    $miPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtiene código del libro a borrar
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    
    if (!$id) {
        throw new Exception("ID de libro no proporcionado");
    }

    // Iniciar transacción
    $miPDO->beginTransaction();

    // 1. Primero borrar los ejemplares asociados al libro
    $borrarEjemplares = $miPDO->prepare('DELETE FROM EJEMPLAR WHERE idLibro = :id');
    $borrarEjemplares->execute(['id' => $id]);

    // 2. Luego borrar el libro
    $borrarLibro = $miPDO->prepare('DELETE FROM LIBRO WHERE id = :id');
    $borrarLibro->execute(['id' => $id]);

    // Verificar si se afectó alguna fila
    if ($borrarLibro->rowCount() === 0) {
        throw new Exception("No se encontró el libro con ID: $id");
    }

    // Confirmar transacción
    $miPDO->commit();

    $_SESSION['mensaje'] = "Libro eliminado correctamente";
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    if (isset($miPDO) && $miPDO->inTransaction()) {
        $miPDO->rollBack();
    }
    $_SESSION['error'] = "Error al eliminar el libro: " . $e->getMessage();
}

// Redireccionar con headers anti-caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header('Location: listar.php');
exit;
?>