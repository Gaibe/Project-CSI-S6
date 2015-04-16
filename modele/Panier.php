<?php

require_once("Panier_Has_Produit.php");

final class Panier {


    protected $id_panier;

    protected $id_client;

    protected $prix_total;

    protected $date_creation;

    protected $est_valide;

    protected $quantite_totale;

    protected $panier_has_produit = array();



    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public function addProduitPanier($panier_has_produit) {
        array_push($this->panier_has_produit, $produit);
    }

    public function addQuantite($qte) {
        $this->quantite_totale += $qte;
    }

    public function addMontant($montant) {
        $this->prix_total += $montant;
    }

    public static function findById($id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM panier WHERE id_panier = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Panier());
    }

    public static function findByClientIdValide($id_client) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM panier 
            WHERE id_client = :id_client
            AND est_valide = false");
        $stmt->bindParam(':id_client', $id_client);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Panier());
    }

    public function setValide() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("UPDATE panier SET est_valide = true WHERE id_panier = :id_panier");
        $stmt->bindParam(':id_panier', $this->id_panier);
        $stmt->execute();
    }

    public function ajouterProduit($id_produit, $quantite, $prix) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("UPDATE panier SET prix_total = :prix_total, quantite_totale = :quantite_totale WHERE id_panier = :id_panier");
        $stmt->bindParam(':prix_total', $this->prix_total);
        $stmt->bindParam(':quantite_totale', $this->quantite_totale);
        $stmt->bindParam(':id_panier', $this->id_panier);
        $stmt->execute();

        $panier_produit = new Panier_Has_Produit();
        $panier_produit->__set("panier_id_panier", $this->id_panier);
        $panier_produit->__set("produit_id_produit", $this->id_produit);
        $panier_produit->__set("quantite", $quantite);
        $panier_produit->__set("prix_produit", $prix);
        $this->addProduitPanier($panier_produit);

        $panier_produit->insert();
    }

    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO panier (id_client, prix_total, quantite_totale) 
            VALUES (:id_client, :prix_total, :quantite_totale)");
        $stmt->bindParam(':prix_total', $this->prix_total);
        $stmt->bindParam(':id_client', $this->id_client);
        $stmt->bindParam(':quantite_totale', $this->quantite_totale);
        $stmt->execute();

        $this->id_panier = $connection->lastInsertId();

        foreach ($this->panier_has_produit as $produit) {
            $produit->__set('panier_id_panier', $this->id_panier);
            $produit->insert();
        }
    }


    public static function panierVide($id_client = null) {
        $panier = new Panier();
        if ($id_client !== null) {
            $panier->__set("id_client", $id_client);
        }
        $panier->__set("prix_total", 0.00);
        $panier->__set("quantite_totale", 0);
        return $panier;
    }


    
}