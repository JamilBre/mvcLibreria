<?php
// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conectar con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Obtener la lista de ejemplares con el título del libro
$query = $miPDO->prepare('
    SELECT EJEMPLAR.id, LIBRO.titulo 
    FROM EJEMPLAR
    INNER JOIN LIBRO ON EJEMPLAR.idLibro = LIBRO.id
');
$query->execute();
$ejemplares = $query->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de usuarios
$queryUsuarios = $miPDO->prepare('SELECT id, nombre FROM USUARIO');
$queryUsuarios->execute();
$usuarios = $queryUsuarios->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos las variables
    $idEjemplares = isset($_POST['idEjemplar']) ? $_POST['idEjemplar'] : [];  // Cambiar a un array
    $idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : null;
    $fechaPrestamo = isset($_POST['fechaPrestamo']) ? $_POST['fechaPrestamo'] : null;

    // Preparar INSERT para cada ejemplar seleccionado
    foreach ($idEjemplares as $idEjemplar) {
        $miInsert = $miPDO->prepare('INSERT INTO PRESTAMO (idEjemplar, idUsuario, fechaPrestamo) VALUES (:idEjemplar, :idUsuario, :fechaPrestamo)');

        // Ejecutar INSERT con los datos proporcionados
        $miInsert->bindParam(':idEjemplar', $idEjemplar);
        $miInsert->bindParam(':idUsuario', $idUsuario);
        $miInsert->bindParam(':fechaPrestamo', $fechaPrestamo);

        // Ejecutar la consulta
        $miInsert->execute();
    }

    // Redirigir a la pagina principal
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Préstamo - CRUD PHP</title>
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

        form input[type="checkbox"] {
            margin-right: 10px;
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

        /* Recuadro para los checkboxes */
        .checkbox-container {
            border: 2px solid #3498db;
            padding: 15px;
            border-radius: 10px;
            background-color: #ecf6ff;
            margin-bottom: 15px;
        }

        /* Contenedor desplazable para la lista de libros */
        .scrollable-list {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .checkbox-container label {
            display: block;
            margin: 5px 0;
        }

        /* Estilos para la barra de desplazamiento */
        .scrollable-list::-webkit-scrollbar {
            width: 8px;
        }

        .scrollable-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollable-list::-webkit-scrollbar-thumb {
            background: #3498db;
            border-radius: 10px;
        }

        .scrollable-list::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
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
                    <label for="idEjemplar">Selecciona los Ejemplares (máximo 3)</label>
                    <div class="checkbox-container">
                        <div class="scrollable-list" id="ejemplaresList">
                            <?php foreach ($ejemplares as $ejemplar): ?>
                                <label>
                                    <input type="checkbox" name="idEjemplar[]" value="<?= $ejemplar['id'] ?>" class="ejemplarCheckbox"> 
                                    <?= $ejemplar['titulo'] ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </p>

                <!-- Selección de Usuario -->
                <p>
                    <label for="idUsuario">Seleccione Usuario</label>
                    <select id="idUsuario" name="idUsuario" required>
                        <option value="">Seleccione un usuario</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id'] ?>"><?= $usuario['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>

                <p>
                    <label for="fechaPrestamo">Fecha de Préstamo</label>
                    <input id="fechaPrestamo" type="date" name="fechaPrestamo" required>
                </p>

                <p>
                    <input type="submit" value="Registrar Préstamo">
                </p>
            </form>
        </main>
    </div>

    <script>
        // Restringir la selección a un máximo de 3 libros
        const checkboxes = document.querySelectorAll('.ejemplarCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedBoxes = document.querySelectorAll('.ejemplarCheckbox:checked');
                if (checkedBoxes.length > 3) {
                    alert('Solo puedes seleccionar hasta 3 libros.');
                    this.checked = false; // Desmarcar el último seleccionado
                }
            });
        });
    </script>

</body>
</html>