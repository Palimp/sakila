<!DOCTYPE html>

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

            

            $nuevo = filter_input(INPUT_GET, 'nuevo');
            $first_name = filter_input(INPUT_GET, 'first_name');
            $last_name = filter_input(INPUT_GET, 'last_name');

            if (!empty($nuevo) && !empty($first_name) && !empty($last_name)) {
                $sakila->newActor($first_name, $last_name);
            }
            $cambiar = filter_input(INPUT_GET, 'cambiar');
            $actor_id = filter_input(INPUT_GET, 'actor_id');

            if (!empty($cambiar) && !empty($actor_id) && !empty($first_name) && !empty($last_name)) {
                $sakila->updateActor(['actor_id' => $actor_id, 'first_name' => $first_name, 'last_name' => $last_name]);
            }

            $delete = filter_input(INPUT_POST, 'delete');
            $actor_id = filter_input(INPUT_POST, 'actor_id');

            if (!empty($delete) && !empty($actor_id)) {
                $sakila->deleteActor($actor_id);
            }




            $actores = $sakila->getActors();
            ?>
            <h1>Mantenimiento actores</h1>

            <form>
                <div class="form-group">
                    <label for="first_name">Nombre:</label>
                    <input type="text" class="form-control" name="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Apellidos:</label>
                    <input type="text" class="form-control" name="last_name">
                </div>
                <input class="btn btn-success" type="submit" name="nuevo" value="Nuevo">
            </form>
            <table class="table">
                <tr><td>Nombre</td><td>Apellidos</td><td>Acciones</td></tr>
                <?php
                foreach ($actores as $actor) {
                    ?>
                    <tr><td><?= $actor['first_name'] ?></td><td><?= $actor['last_name'] ?></td>
                        <td><a href="editar.php?actor_id=<?= $actor['actor_id'] ?>" class="btn btn-success">Editar</a>
                            <form action="index.php" method="post" style="float:left;margin-right: 10px">
                                <input type="hidden" name="actor_id" value="<?= $actor['actor_id'] ?>">
                                <input class="btn btn-success" type="submit" name="delete" value="Borrar">   
                            </form>
                        </td></tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </body>
</html>
