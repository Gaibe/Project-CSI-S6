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

    public function addProduitPanier($produit) {
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

    public static function findByClientIdConfirmer($id_client) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM panier 
            WHERE id_client = :id_client
            AND est_valide = true
            ORDER BY date_creation DESC");
        $stmt->bindParam(':id_client', $id_client);
        $stmt->execute();

        // set the resulting array to associative
        return $result = $stmt->fetchAll();
    }

    public function ajouterProduit($id_produit, $quantite) {
        include_once("Produit.php");
        $connection = base::getConnection();
        $reduction = Produit::findReducProd($id_produit, $this->id_client);
        $produit = Produit::findById($id_produit);
        $panier_produit = Panier_Has_Produit::findById($this->id_panier, $id_produit);
        $this->quantite_totale += $quantite;
        $montant = $produit->getPrixQuantite($_SESSION['membre'],$this->__get("quantite_totale"));
        $prix = $montant/$this->__get("quantite_totale");
        

        //  if ($reduction !== false && $reduction["nombre_produit"] > 1 && ($reduction["nombre_produit"]) < ($panier_produit->__get("quantite")+$quantite)){
        //     $panier_produit->__set("prix_produit", $produit->__get("prix"));
        // }

        $stmt = $connection->prepare("UPDATE panier SET prix_total = :prix_total, quantite_totale = :quantite_totale WHERE id_panier = :id_panier");
        $stmt->bindParam(':prix_total', $montant);
        $stmt->bindParam(':quantite_totale', $this->quantite_totale);
        $stmt->bindParam(':id_panier', $this->id_panier);
        $stmt->execute();

        if ($panier_produit === -1) {
            $panier_produit = new Panier_Has_Produit();
            $panier_produit->__set("panier_id_panier", $this->id_panier);
            $panier_produit->__set("produit_id_produit", $id_produit);
            $panier_produit->__set("quantite", $quantite);
            $panier_produit->__set("prix_produit", $prix);

            $panier_produit->insert();
        }
        else {
            $panier_produit->__set("quantite", $quantite+$panier_produit->__get("quantite"));
            $panier_produit->__set("prix_produit", $prix);

            $panier_produit->update();
        }
        $this->addProduitPanier($panier_produit);
    }

    public function retirerProduit($id_produit) {
        $connection = base::getConnection();

        $panier_produit = Panier_Has_Produit::findById($this->id_panier, $id_produit);
        $this->quantite_totale -= $panier_produit->__get("quantite");
        $this->prix_total -= ($panier_produit->__get("prix_produit")*$panier_produit->__get("quantite"));
        $panier_produit->delete();
        $this->update();
    }

    public function ajouterUnProduit($id_produit) {
        $this->ajouterProduit($id_produit, 1);
    }

    public function retirerUnProduit($id_produit) {
        include_once("Produit.php");
        $connection = base::getConnection();

        $reduction = Produit::findReducProd($id_produit, $this->id_client);
        $produit_panier = Panier_Has_Produit::findById($this->id_panier, $id_produit);

        if ($reduction !== false && $reduction["nombre_produit"] > 1 && ($reduction["nombre_produit"]+1) == $produit_panier->__get("quantite")) {
            $produit = Produit::findById($id_produit);
            $produit_panier->__set("prix_produit", $produit->__get("prix"));
        }
        $prix_total = $this->prix_total - $produit_panier->__get("prix_produit");
        $stmt = $connection->prepare("UPDATE panier 
            SET quantite_totale = quantite_totale-1, prix_total = :prix_total 
            WHERE id_panier = :id_panier");
        $stmt->bindParam(':prix_total', $prix_total);
        $stmt->bindParam(':id_panier', $this->id_panier);
        $stmt->execute();

        $produit_panier->decQuantite();
        $produit_panier->update();
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

    public function update() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("UPDATE panier 
            SET quantite_totale = :quantite_totale, prix_total = :prix_total 
            WHERE id_panier = :id_panier");
        $stmt->bindParam(':quantite_totale', $this->quantite_totale);
        $stmt->bindParam(':prix_total', $this->prix_total);
        $stmt->bindParam(':id_panier', $this->id_panier);
        $stmt->execute();
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