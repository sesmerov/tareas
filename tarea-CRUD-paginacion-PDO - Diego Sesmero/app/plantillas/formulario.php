<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CRUD DE USUARIOS</title>
    <link href="web/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="container" style="width: 600px;">
        <div id="header">
            <h1><?=  ($orden == "Detalles") ?  "DETALLES DE CLIENTE" : "" ?></h1>
            <h1><?=  ($orden == "Modificar") ?  "MODIFICAR CLIENTE" : "" ?></h1>
            <h1><?=  ($orden == "Alta") ?  "NUEVO CLIENTE" : "" ?></h1>
        </div>
        <div id="content">
            <hr>
            <form method="POST">
                <table>
                    <tr>
                        <td>ID </td>
                        <td>
                            <input type="text" name="id" value="<?= $cliente->id ?>" readonly size="20" <?= ($orden=="Alta") ? "disabled" : "" ?>> 
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre </td>
                        <td>
                            <input type="text" name="first_name" value="<?= $cliente->first_name ?>" <?= ($orden == "Detalles") ? "readonly" : "" ?> size="8" autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td>Apellido </td>
                        <td>
                            <input type="text" name="last_name" value="<?= $cliente->last_name ?>" <?= ($orden == "Detalles") ? "readonly" : "" ?> size=10>
                        </td>
                    </tr>
                    <tr>
                        <td>Email </td>
                        <td>
                            <input type="text" name="email" value="<?= $cliente->email ?>" <?= ($orden == "Detalles") ? "readonly" : "" ?> size=10>
                        </td>
                    </tr>
                    <tr>
                        <td>Genero </td>
                        <td>
                            <input type="text" name="gender" value="<?= $cliente->gender ?>" <?= ($orden == "Detalles") ? "readonly" : "" ?> size=10>
                        </td>
                    </tr>
                    <tr>
                        <td>IP adress </td>
                        <td>
                            <input type="text" name="ip_address" value="<?= $cliente->ip_address ?>" <?= ($orden == "Detalles") ? "readonly" : "" ?> size=10>
                        </td>
                    </tr>
                    <tr>
                        <td>Teléfono </td>
                        <td>
                            <input type="text" name="telefono" value="<?= $cliente->telefono ?>" <?= ($orden == "Detalles") ? "readonly" : "" ?> size=20>
                        </td>
                    </tr>
                </table>

                <?=  ($orden == "Alta") ?  '<input type="submit" name="orden" value="Añadir"></input>' : "" ?>
                <?=  ($orden == "Modificar") ?  '<input type="submit" name="orden" value="Modificar"></input>' : "" ?>


                <input type="button" name="orden" value="Volver" onclick="history.back()">
            </form>
        </div>
    </div>
</body>

</html>
<?php exit(); ?>

</html>