<?php

require_once("Adresse.php");

final class Magasin {

    const NB_QUAI = 5;

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

    public static function horraireOuverture($day) {
        return array(
            // Magasin ouvre à 8heure
            new DateTime($day.' 08:00:00'),
            new DateTime($day.' 08:30:00'),
            new DateTime($day.' 09:00:00'),
            new DateTime($day.' 09:30:00'),
            new DateTime($day.' 10:00:00'),
            new DateTime($day.' 10:30:00'),
            new DateTime($day.' 11:00:00'),
            new DateTime($day.' 11:30:00'),
            // Pause de midi
            new DateTime($day.' 13:00:00'),
            new DateTime($day.' 13:30:00'),
            new DateTime($day.' 14:00:00'),
            new DateTime($day.' 14:30:00'),
            new DateTime($day.' 15:00:00'),
            new DateTime($day.' 15:30:00'),
            new DateTime($day.' 16:00:00'),
            new DateTime($day.' 16:30:00'),
            new DateTime($day.' 17:00:00'),
            new DateTime($day.' 17:30:00')
            // Magasin ferme à 18h donc 17h30 dernier chargement
            );
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
        
        return Hydrator::hydrate($result, new Magasin());
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