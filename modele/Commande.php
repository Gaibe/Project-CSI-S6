<?php

final class Commande {
    
    protected $id_commande;

    protected $id_panier;

    protected $id_magasin;

    protected $date_creation;

    protected $heure_retrait;

    protected $num_quai;



    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public static function findById($id_commande) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM commande WHERE id_commande = :id_commande");
        $stmt->bindParam(':id_commande', $id_commande);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Commande());
    }

    public static function findByPanierId($id_panier) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM commande WHERE id_panier = :id_panier");
        $stmt->bindParam(':id_panier', $id_panier);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Commande());
    }

    public static function findByMagasinId($id_magasin) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM commande WHERE id_magasin = :id_magasin");
        $stmt->bindParam(':id_magasin', $id_magasin);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();
        return Hydrator::hydrate($result, new Commande());
    }


    public static function findHeureRetrait($id_magasin, $heure_retrait) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM commande 
            WHERE id_magasin = :id_magasin AND heure_retrait >= CURDATE() AND heure_retrait = :heure_retrait");
        $stmt->bindParam(':id_magasin', $id_magasin);
        $hr = $heure_retrait->format('Y-m-d H:i:s');
        $stmt->bindParam(':heure_retrait', $hr);
        $stmt->execute();

        // set the resulting array to associative
        return $result = $stmt->fetchAll();;
    }



    public function insert() {
        $connection = base::getConnection();        
        $stmt = $connection->prepare("INSERT INTO commande (id_panier, id_magasin, heure_retrait, num_quai) 
            VALUES (:id_panier, :id_magasin, :heure_retrait, :num_quai)");
        $stmt->bindParam(':id_panier', $this->id_panier);
        $stmt->bindParam(':id_magasin', $this->id_magasin);
        $hr = $this->heure_retrait->format('Y-m-d H:i:s');
        $stmt->bindParam(':heure_retrait', $hr);
        $stmt->bindParam(':num_quai', $this->num_quai);

        $stmt->execute();
    }

    public function delete() {
        $connection = base::getConnection();        
        $stmt = $connection->prepare("DELETE FROM commande
            WHERE id_commande = :id_commande");
        $stmt->bindParam(':id_commande', $this->id_commande);

        $stmt->execute();
    }

}