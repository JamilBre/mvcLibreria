<?php
    require_once("config.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Web</title>
    <link rel="stylesheet" href="vista/css/app.css">
</head>
<body>
    <header>
        <h1>CRUDS</h1>
        <nav>
            <ul>
                <li><a class="link" href="vista/Autor/listar.php">Autor</a></li>
                <li><a class="link" href="vista/Usuario/listar.php">Usuario</a></li>
                <li><a class="link" href="vista/Libro/listar.php">Libro</a></li>
                <li><a class="link" href="vista/Ejemplar//listar.php">Ejemplar</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Prestamo y Devolución</h2>
        <button class="button" onclick="location.href='controlador/ControladorPrestamo.php'" >Prestamo</button>
        <button class="button" onclick="location.href='controlador/ControladorDevolucion.php'">Devolución</button>
    </section>

    <section>
        <h2>Consultas</h2>
        <button class="button" onclick="location.href='controlador/consulta1.php'">Consulta 1</button>
        <button class="button" onclick="location.href='controlador/consulta2.php'">Consulta 2</button>
        <button class="button" onclick="location.href='controlador/consulta3.php'">Consulta 3</button>
    </section>
</body>
</html>
