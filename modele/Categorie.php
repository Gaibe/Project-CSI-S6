<?php


final class Categorie {

    protected $id_categorie;

    protected $nom;



    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public static function findById($id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM categorie WHERE id_categorie = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Categorie());
    }

    public static function findAll() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM categorie ORDER BY nom");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();

        return Hydrator::hydrate($result, new Categorie());
    }

    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO categorie (nom) 
            VALUES (:nom)");
        $stmt->bindParam(':nom', $this->nom);
        $stmt->execute();
    }

    public function delete() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("DELETE FROM categorie WHERE id_produit = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


    
}