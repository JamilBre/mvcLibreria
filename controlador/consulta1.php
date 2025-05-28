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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplares por Usuario - CRUD PHP</title>
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
            max-width: 600px;
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
            max-width: 600px;
            box-sizing: border-box;
        }

        header h1 {
            margin: 0;
            font-size: 1.2rem;
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
            font-size: 1.2rem;
        }

        form input, form select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1.2rem;
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

        /* Tabla */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        table th {
            background-color: #2c3e50;
            color: white;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .container,
            header,
            form,
            table {
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
            form,
            table {
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
                <table>
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
        </main>
    </div>

</body>
</html>
