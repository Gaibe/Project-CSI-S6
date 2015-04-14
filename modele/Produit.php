<?php

require_once "Categorie.php";

final class Produit {

    protected $id_produit;

    protected $libelle;

    protected $prix;

    protected $description;

    protected $image_url;

    protected $categorie;



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
        $stmt = $connection->prepare("SELECT * FROM produit WHERE id_produit = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();


        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $produit = new Produit();
        $produit->categorie = Categorie::findByClientId($id);
        return Hydrator::hydrate($result, $produit);
    }

    public static function findByCategorie($id_categ) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM produit 
            INNER JOIN produit_has_categorie ON produit_id_produit = id_produit
            WHERE categorie_id_categorie = :id_categorie");
        $stmt->bindParam(':id_categorie', $id_categ);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();

        return Hydrator::hydrate($result, new Categorie());
    }

    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO produit (libelle, prix, description, image_url) 
            VALUES (:libelle, :prix, :description, :image_url)");
        $stmt->bindParam(':libelle', $this->libelle);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->execute();

        $this->id_produit = $connection->lastInsertId();
        $stmt2 = $connection->prepare("INSERT INTO produit_has_categorie (produit_id_produit, categorie_id_categorie) 
            VALUES (:id_produit, :id_categorie)");
        $stmt2->bindParam(':id_produit', $this->id_produit);
        // var_dump($this->categorie);
        $stmt2->bindParam(':id_categorie', $this->categorie->__get("id_categorie"));
        $stmt2->execute();
    }

    public function delete() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("DELETE FROM produit WHERE id_produit = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


    
}