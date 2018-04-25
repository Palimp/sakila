<?php

class Sakila {

    private $server = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "sakila";
    public $conn;

    function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->server;dbname=$this->db", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function getActors() {
        $sql = "select * from actor";
        $query = $this->conn->query($sql);
        return $query->fetchAll();
    }

    function getActor($id) {
        $sql = "select * from actor where actor_id=$id";
        $query = $this->conn->query($sql);
        return $query->fetch();
    }

    /**
     * 
     * @param type $actor  array asociativo con los campos del actor
     * ejemplo: ['actor_id'=>1,'first_name'=>'Santiago','last_name'=>'Segura']
     */
    function updateActor($actor) {
        $sql = "update actor set first_name='" . $actor['first_name'] . "', last_name='" . $actor['last_name'] . "'
                where actor_id=" . $actor['actor_id'] . ";";
        $this->conn->exec($sql);
    }

    function deleteActor($id) {
        $sql = "delete from actor where actor_id=$id";
        $this->conn->exec($sql);
    }

    /**
     * Inserta un nuevo actor o devuelve el id si ya existe
     * @param string valor de first_name
     * @param string valor de last_name
     * @return int id
     */
    function newActor($first_name, $last_name) {
        if (!empty($first_name) && !empty($last_name)) {
            $sql = "select * from actor where first_name=:first_name and last_name=:last_name";
            $st = $this->conn->prepare($sql);
            $st->execute([':first_name' => $first_name, ':last_name' => $last_name]);
            if ($actor = $st->fetch()) {
                return $actor['actor_id'];
            }
            $sql = "insert into actor (first_name,last_name) values (:first_name,:last_name)";
            $st = $this->conn->prepare($sql);
            $st->execute([':first_name' => $first_name, ':last_name' => $last_name]);
            return $this->conn->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * Inserta una película en una categoría
     * @param int id de la categoría
     * @param string título de la película
     */
    function newFilm($category_id, $film) {

        $this->conn->beginTransaction();
        try {
            $sql = "insert into film(title,language_id) values (:film,1)";
            $st = $this->conn->prepare($sql);
            $st->execute([':film' => $film]);
            $film_id = $this->conn->lastInsertId();
            $sql = "insert into film_category(film_id,category_id) values($film_id,$category_id)";
            $this->conn->exec($sql);
            $this->conn->commit();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->conn->rollBack();
        }
    }

    /**
     * Crea un select con todas las categorías
     */
    function selectCategory() {
        $sql = "select * from category";
        $q = $this->conn->query($sql);
        $categorias = $q->fetchAll();
        ?>
        <select name="category">
        <?php foreach ($categorias as $categoria) {
            ?>
                <option value="<?= $categoria['category_id'] ?>"><?= $categoria['name'] ?></option>
            <?php } ?>
        </select>
            <?php
        }

    }
    