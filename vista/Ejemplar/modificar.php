<?php
// Variables de conexión a la base de datos
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Obtener parámetros
$id = $_REQUEST['id'] ?? null;
$idLibro = $_REQUEST['idLibro'] ?? null;
$localizacion = $_REQUEST['localizacion'] ?? null;

// Conectar con la base de datos
try {
    $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;charset=utf8";
    $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
    $miPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $miUpdate = $miPDO->prepare('UPDATE EJEMPLAR SET localizacion = :localizacion, idLibro = :idLibro WHERE id = :id');
        $miUpdate->execute([
            'id' => $id,
            'idLibro' => $idLibro,
            'localizacion' => $localizacion
        ]);
        header('Location: listar.php');
        exit;
    } catch (PDOException $e) {
        $error = "Error al actualizar: " . $e->getMessage();
    }
}

// Obtener datos del ejemplar
try {
    $miConsulta = $miPDO->prepare('SELECT * FROM EJEMPLAR WHERE id = :id');
    $miConsulta->execute(['id' => $id]);
    $ejemplar = $miConsulta->fetch();
    
    if (!$ejemplar) {
        header('Location: listar.php');
        exit;
    }
} catch (PDOException $e) {
    die("Error al obtener datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Ejemplar - CRUD PHP</title>
    <link rel="stylesheet" href="../css/form1.css">
</head>
<body>
    <div class="form-box">
        <h2>Modificar Ejemplar</h2>
        
        <?php if (isset($error)): ?>
            <div class="error-message" style="color: #dc3545; margin-bottom: 15px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="form-container">
            <div class="form-group">
                <label for="idLibro">Código del Libro</label>
                <input id="idLibro" type="text" name="idLibro" 
                       value="<?= htmlspecialchars($ejemplar['idLibro']) ?>" required>
            </div>

            <div class="form-group">
                <label for="localizacion">Localización</label>
                <input id="localizacion" type="text" name="localizacion" 
                       value="<?= htmlspecialchars($ejemplar['localizacion']) ?>" required>
            </div>

            <div class="form-actions">
                <input type="hidden" name="id" value="<?= htmlspecialchars($ejemplar['id']) ?>">
                <button type="submit" class="button">Modificar</button>
            </div>
        </form>

        <div class="button-container">
            <a href="listar.php" class="button" style="background-color: #6c757d;">Volver al listado</a>
        </div>
    </div>
</body>
</html>