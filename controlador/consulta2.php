<?php
// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conectar con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Obtener ejemplares que no fueron devueltos
$query = $miPDO->prepare('
    SELECT E.id, L.titulo, P.idUsuario, U.nombre AS nombreUsuario, P.fechaPrestamo
    FROM EJEMPLAR E
    JOIN LIBRO L ON E.idLibro = L.id
    JOIN PRESTAMO P ON E.id = P.idEjemplar
    JOIN USUARIO U ON P.idUsuario = U.id
    WHERE P.fechaDevolucion IS NULL
');
$query->execute();
$ejemplares = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplares No Devueltos - CRUD PHP</title>
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
            max-width: 800px;
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
            max-width: 800px;
            box-sizing: border-box;
        }

        header h1 {
            margin: 0;
            font-size: 1.5rem; /* Estilo igual que otros encabezados */
            word-wrap: break-word;
            line-height: 1.4;
            font-weight: bold;
        }

        /* Títulos */
        h2 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .container,
            header {
                max-width: 95%;
            }
            header h1,
            h2 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0;
            }
            header h1,
            h2 {
                font-size: 1rem;
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
            <h2>📚 Ejemplares No Devueltos</h2> <!-- Cambié el título aquí -->
            <table>
                <tr>
                    <th>ID Ejemplar</th>
                    <th>Título</th>
                    <th>ID Usuario</th>
                    <th>Nombre Usuario</th>
                    <th>Fecha de Préstamo</th>
                </tr>
                <?php foreach ($ejemplares as $ejemplar): ?>
                    <tr>
                        <td><?= $ejemplar['id'] ?></td>
                        <td><?= $ejemplar['titulo'] ?></td>
                        <td><?= $ejemplar['idUsuario'] ?></td>
                        <td><?= $ejemplar['nombreUsuario'] ?></td>
                        <td><?= $ejemplar['fechaPrestamo'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </main>
    </div>

</body>
</html>
