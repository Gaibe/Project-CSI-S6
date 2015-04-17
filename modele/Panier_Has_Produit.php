<?php


final class Panier_Has_Produit {


    protected $panier_id_panier;

    protected $produit_id_produit;

    protected $quantite;

    protected $prix_produit;


    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public static function findById($id_panier, $id_produit) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM panier_has_produit WHERE panier_id_panier = :id_panier AND produit_id_produit = :id_produit");
        $stmt->bindParam(':id_panier', $id_panier);
        $stmt->bindParam(':id_produit', $id_produit);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Panier_Has_Produit());
    }

    public function update() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("UPDATE panier_has_produit 
            SET quantite = :quantite, prix_produit = :prix_produit 
            WHERE panier_id_panier = :id_panier 
            AND produit_id_produit = :id_produit");
        $stmt->bindParam(':quantite', $this->quantite);
        $stmt->bindParam(':prix_produit', $this->prix_produit);
        $stmt->bindParam(':id_panier', $this->panier_id_panier);
        $stmt->bindParam(':id_produit', $this->produit_id_produit);
        $stmt->execute();
    }


    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO panier_has_produit (panier_id_panier, produit_id_produit, quantite, prix_produit) 
            VALUES (:id_panier, :id_produit, :quantite, :prix_produit)");
        $stmt->bindParam(':id_panier', $this->panier_id_panier);
        $stmt->bindParam(':id_produit', $this->produit_id_produit);
        $stmt->bindParam(':quantite', $this->quantite);
        $stmt->bindParam(':prix_produit', $this->prix_produit);
        $stmt->execute();
    }


    
}