<?php

final class Bilan_Has_Produit {
    

    protected $bilan_id_bilan;

    protected $produit_id_produit;

    protected $quantite;

    // prix * quantite du produit
    protected $montant;


    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }



    public static function findById($id_bilan, $id_produit) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM bilan_has_produit WHERE bilan_id_bilan = :id_bilan AND produit_id_produit = :id_produit");
        $stmt->bindParam(':id_bilan', $id_bilan);
        $stmt->bindParam(':id_produit', $id_produit);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Bilan_Has_Produit());
    }

    public static function findByBilanId($id_bilan) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM bilan_has_produit WHERE bilan_id_bilan = :id_bilan");
        $stmt->bindParam(':id_bilan', $id_bilan);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();
        return Hydrator::hydrate($result, new Bilan_Has_Produit());
    }

    public function update() {
        $connection = base::getConnection();
      
        $stmt = $connection->prepare("UPDATE bilan_has_produit 
            SET quantite = :quantite, montant = :montant 
            WHERE bilan_id_bilan = :id_bilan 
            AND produit_id_produit = :id_produit");
        $stmt->bindParam(':quantite', $this->quantite);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':id_bilan', $this->bilan_id_bilan);
        $stmt->bindParam(':id_produit', $this->produit_id_produit);
        $stmt->execute();
    }

    public function delete() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("DELETE FROM bilan_has_produit 
            WHERE bilan_id_bilan = :id_bilan 
            AND produit_id_produit = :id_produit");
        $stmt->bindParam(':id_bilan', $this->bilan_id_bilan);
        $stmt->bindParam(':id_produit', $this->produit_id_produit);
        $stmt->execute();
    }


    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO bilan_has_produit (bilan_id_bilan, produit_id_produit, quantite, montant) 
            VALUES (:id_bilan, :id_produit, :quantite, :montant)");
        $stmt->bindParam(':id_bilan', $this->bilan_id_bilan);
        $stmt->bindParam(':id_produit', $this->produit_id_produit);
        $stmt->bindParam(':quantite', $this->quantite);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->execute();
    }
}