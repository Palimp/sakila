<DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">
            <?php
            include "sakila.php";
            $sakila = new Sakila();

            //hola

            $actor_id = filter_input(INPUT_GET, 'actor_id');

            if (!empty($actor_id)) {
                $actor = $sakila->getActor($actor_id);
            }
            ?>
            <h1>Editar actor</h1>

            <form action="index.php">
                <input type="hidden" class="form-control" name="actor_id" value="<?= $actor['actor_id'] ?>">
                <div class="form-group">
                    <label for="first_name">Nombre:</label>
                    <input type="text" class="form-control" name="first_name" value="<?= $actor['first_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Apellidos:</label>
                    <input type="text" class="form-control" name="last_name" value="<?= $actor['last_name'] ?>">
                </div>
                    <div class="form-group">
                    <label for="last_name">Apellidos:</label>
                    <input type="text" class="form-control" name="last_name" value="<?= $actor['last_name'] ?>">
                </div>
                <input class="btn btn-success" type="submit" name="cambiar" value="Cambiar">
            </form>
        </div>
        <!--Teste github Caroline-->
    </body>
</html>
