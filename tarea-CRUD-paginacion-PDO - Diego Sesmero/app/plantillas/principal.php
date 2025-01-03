<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clientes Paginado</title>
<link href="web/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="web/funciones.js"></script>

</head>
<body>
<div id="container">
    <div id="header">
        <h1>Listado de Clientes</h1>
    </div>
    <div id="content">
    <td><a href="index.php?orden=Alta">Nuevo Cliente</a></td>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>IP Address</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($tclientes as $cli): ?>
             <tr>
                <td><?= $cli->id ?> </td>
                <td><?= $cli->first_name ?> </td>
                <td><?= $cli->email ?> </td>
                <td><?= $cli->gender ?> </td>
                <td><?= $cli->ip_address ?> </td>
                <td><?= $cli->telefono ?> </td>
                <td><a href="#" onclick="confirmarBorrar('<?=$cli->first_name?>','<?=$cli->id?>');" >Borrar</a></td>
                <td><a href="index.php?orden=Modificar&id=<?=$cli->id?>">Modificar</a></td>
                <td><a href="index.php?orden=Detalles&id=<?=$cli->id?>" >Detalles</a></td>
             </tr>
            <?php endforeach; ?>    
            </tbody>
        </table>
        <form>
            <button name="orden" value="Primero">&#8606; Primero</button>
            <button name="orden" value="Anterior">&#8592; Anterior</button>
            <button name="orden" value="Siguiente">&#8594; Siguiente</button>
            <button name="orden" value="Ultimo">&#8608; Último</button>
        </form>
    </div>
</div>
</body>
</html>
