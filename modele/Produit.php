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

    public function getPrixUnitaire($id_client = null) {
        if ($id_client !== null) { 
            $reduction = self::findReducProd($this->id_produit,$id_client);
        } else {
            $reduction = false;
        }

        if ($reduction !== false) {
            if ($reduction["nombre_produit"] < 1) {
                return number_format($reduction["prixreduit"], 2);
            }
        }
        return $this->prix;
        
    }


    public function getPrixQuantite($id_client = null, $quantite = 1) {
        if ($id_client !== null) { 
            $reduction = self::findReducProd($this->id_produit,$id_client);
        } else {
            $reduction = false;
        }
        if ($reduction !== false) {
            if ($reduction["nombre_produit"] < 1) {
                return number_format($reduction["prixreduit"] * $quantite, 2);
            }
            else {
                if ($quantite >= $reduction["nombre_produit"]) {
                    return number_format($reduction["prixreduit"] + ($this->prix*($quantite-1)), 2);
                }
                else {
                    return $this->prix*$quantite;
                }
            }
        }
        else {
            return $this->prix*$quantite;
        }
    }

    public static function findById($id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM produit WHERE id_produit = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();


        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $produit = new Produit();
        $produit->categorie = Categorie::findByProduitId($id);
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

        return Hydrator::hydrate($result, new Produit());
    }
    
    /*Pour récupérer le montant de la réduction (en pourcentage), faire : $result["montant_reduction"]
     * Pour récupérer le nouveau prix après application de la réduction  : $result["prixreduit"]
     * Pour récupérer le nombre de produits avant application de la réduction  : $result["nombre_produit"] */
    public static function findReducProd($id_produit, $id_client) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT montant_reduction, prix - (prix * montant_reduction/100) AS prixreduit, nombre_produit
        FROM reduction INNER JOIN reduction_has_produit ON reduction.id_reduction = reduction_has_produit.reduction_id_reduction 
        INNER JOIN produit ON reduction_has_produit.produit_id_produit = produit.id_produit 
        INNER JOIN reduction_has_client ON reduction_has_client.reduction_id_reduction = reduction.id_reduction

        WHERE date_fin > NOW() AND produit_id_produit = :id_produit AND client_id_client = :id_client AND date_fin = 

        (SELECT MAX(date_fin) FROM reduction INNER JOIN reduction_has_produit ON reduction.id_reduction = reduction_has_produit.reduction_id_reduction 
            INNER JOIN produit ON reduction_has_produit.produit_id_produit = produit.id_produit 
            INNER JOIN reduction_has_clienT ON reduction_has_client.reduction_id_reduction = reduction.id_reduction
            WHERE produit_id_produit = :id_produit AND client_id_client = :id_client
        ) 
        
        AND montant_reduction = 
        
        (SELECT MAX(montant_reduction) FROM
            reduction INNER JOIN reduction_has_produit ON reduction.id_reduction = reduction_has_produit.reduction_id_reduction 
            INNER JOIN produit ON reduction_has_produit.produit_id_produit = produit.id_produit 
            INNER JOIN reduction_has_clienT ON reduction_has_client.reduction_id_reduction = reduction.id_reduction

            WHERE date_fin > NOW() AND produit_id_produit = :id_produit AND client_id_client = :id_client AND date_fin = 

            (SELECT MAX(date_fin) FROM reduction INNER JOIN reduction_has_produit ON reduction.id_reduction = reduction_has_produit.reduction_id_reduction 
            INNER JOIN produit ON reduction_has_produit.produit_id_produit = produit.id_produit 
            INNER JOIN reduction_has_clienT ON reduction_has_client.reduction_id_reduction = reduction.id_reduction
            WHERE produit_id_produit = :id_produit AND client_id_client = :id_client)
        )");
        $stmt->bindParam(':id_categorie', $id_categ);
        $stmt->bindParam(':id_produit', $id_produit);
        $stmt->bindParam(':id_client', $id_client);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        return $result;
    }
    
    
  

    public static function findProduit($recherche) {
        $recherche = htmlspecialchars(trim(strtolower($recherche)));
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM produit 
            WHERE libelle LIKE '%" . $recherche . "%' 
            OR description LIKE '%" . $recherche . "%' 
            ORDER BY libelle");
        $stmt->execute();
 
        // set the resulting array to associative
        $result = $stmt->fetchAll();

        return Hydrator::hydrate($result, new Produit());
    }
    
    
    
    public static function findBestSellers($nbV) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT DISTINCT id_produit, libelle, nom AS nomcateg, prix, description, image_url, SUM(quantite) AS nbVentes 
            FROM produit 
            INNER JOIN bilan_has_produit ON bilan_has_produit.produit_id_produit = id_produit
            INNER JOIN produit_has_categorie ON produit_has_categorie.produit_id_produit = id_produit
            INNER JOIN categorie ON categorie_id_categorie = id_categorie
            GROUP BY id_produit
            ORDER BY nbVentes DESC
            LIMIT ".$nbV);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();
        if ($result == null) {
            $connection = base::getConnection();
            $stmt = $connection->prepare("SELECT *
                FROM produit
                LIMIT ".$nbV);
            $stmt->execute();
            $result = $stmt->fetchAll();
        }
        return $result;
    }
    

    public static function findAll() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM produit ORDER BY libelle");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();

        return Hydrator::hydrate($result, new Produit());
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
        $stmt2 = $connection->prepare("DELETE FROM produit_has_categorie WHERE produit_id_produit = :id");
        $stmt2->bindParam(':id', $this->id_produit);
        $stmt2->execute();

        $stmt = $connection->prepare("DELETE FROM produit WHERE id_produit = :id");
        $stmt->bindParam(':id', $this->id_produit);
        $stmt->execute();
    }


    
}