<?php

require_once("Adresse.php");

final class Magasin {


    protected $id_magasin;

    protected $nom;

    protected $adresse;

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
        $stmt = $connection->prepare("SELECT * FROM magasin WHERE id_magasin = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $magasin = Hydrator::hydrate($result, new Magasin());
        $magasin->adresse = Adresse::findByMagasinId($id);
        return $magasin;
    }


    public static function findAll() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT id_magasin, nom FROM magasin 
            INNER JOIN magasin_has_adresse
            ON id_magasin = magasin_id_magasin
            INNER JOIN adresse
            ON id_adresse = adresse_id_adresse
            ORDER BY code_postal");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();
        
        return Hydrator::hydrate($result, new Client());
    }

    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO magasin (nom) 
            VALUES (:nom)");
        $stmt->bindParam(':nom', $this->nom);
        $stmt->execute();

        $this->id_magasin = $connection->lastInsertId();

        if ($this->adresse->__get("rue") != null) {
            $this->adresse->insert();
        }
        else {
            $this->adresse->insertSansRue();
        }
        $id_adresse = $connection->lastInsertId();

        $stmt2 = $connection->prepare("INSERT INTO magasin_has_adresse (magasin_id_magasin, adresse_id_adresse) 
            VALUES (:id_magasin,:id_adresse)");
        $stmt2->bindParam(':id_adresse', $id_adresse);
        $stmt2->bindParam(':id_magasin', $this->id_magasin);
        $stmt2->execute();
    }

}