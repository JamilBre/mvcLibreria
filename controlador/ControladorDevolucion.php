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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Devolución - CRUD PHP</title>
    <style>
        /* Reset y fuente base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html, body {
            width: 100%;
            height: 100%;
            background: #f4f6f9;
            color: #333;
        }

        body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Contenedor principal */
        .container {
            width: 100%;
            max-width: 600px; /* Igual que el formulario y el header */
            margin: 0 auto;
        }

        /* Encabezado */
        header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
            max-width: 600px; /* Igual que el formulario */
            box-sizing: border-box;
        }

        header h1 {
            margin: 0;
            font-size: 1.2rem; /* Igual que los campos del formulario */
            word-wrap: break-word;
            line-height: 1.4;
            font-weight: bold;
        }

        /* Formulario */
        form {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }

        form p {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.2rem; /* Igual que el título */
        }

        form input, form select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1.2rem; /* Igual que el título */
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background 0.3s;
        }

        form input[type="submit"]:hover {
            background-color: #2980b9;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .container,
            header,
            form {
                max-width: 95%;
            }
            header h1,
            form label,
            form input,
            form select {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .container,
            header,
            form {
                max-width: 100%;
                padding: 0;
            }
            header h1,
            form label,
            form input,
            form select {
                font-size: 1rem;
            }
            form input[type="submit"] {
                font-size: 1rem;
                padding: 12px 0;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>📚 Sistema CRUD de Biblioteca</h1>
        </header>

        <main>
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
        </main>
    </div>

</body>
</html>
