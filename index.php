<?php
    require_once("config.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Web</title>
    <style>
        /* Reset y fuente base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #333;
            padding: 20px;
        }

        /* Encabezado */
        header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }

        header h1 {
            margin-bottom: 10px;
            font-size: 2rem;
        }

        /* Navegación */
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        nav .link {
            color: #ecf0f1;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        nav .link:hover {
            background: #34495e;
        }

        /* Contenido principal */
        main {
            max-width: 800px;
            margin: auto;
        }

        /* Secciones */
        section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        section h2 {
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 1.5rem;
        }

        /* Botones */
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }

        .button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <header>
        <h1>📚 Sistema CRUD de Biblioteca</h1>
        <nav>
            <ul>
                <li><a class="link" href="vista/Autor/listar.php">Autor</a></li>
                <li><a class="link" href="vista/Usuario/listar.php">Usuario</a></li>
                <li><a class="link" href="vista/Libro/listar.php">Libro</a></li>
                <li><a class="link" href="vista/Ejemplar/listar.php">Ejemplar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>📤 Préstamo y 📥 Devolución</h2>
            <div class="button-group">
                <button class="button" onclick="location.href='controlador/ControladorPrestamo.php'">Préstamo</button>
                <button class="button" onclick="location.href='controlador/ControladorDevolucion.php'">Devolución</button>
            </div>
        </section>

        <section>
            <h2>🔍 Consultas</h2>
            <div class="button-group">
                <button class="button" onclick="location.href='controlador/consulta1.php'">Consulta 1</button>
                <button class="button" onclick="location.href='controlador/consulta2.php'">Consulta 2</button>
                <button class="button" onclick="location.href='controlador/consulta3.php'">Consulta 3</button>
            </div>
        </section>
    </main>
</body>
</html>
