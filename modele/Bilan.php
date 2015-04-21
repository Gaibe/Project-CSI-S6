<?php

final class Bilan {

    
    // type de bilan
    const JOURNALIER = "journalier";
    const HEBDOMADAIRE = "hebdomadaire";
    const MENSUEL = "mensuel";


    protected $id_bilan;

    protected $montant_total;
    
    protected $date_creation;
    
    protected $type;



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
        $stmt = $connection->prepare("SELECT * FROM bilan WHERE id_bilan = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Bilan());
    }

    public static function findAll() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM bilan ORDER BY id_bilan");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();

        return Hydrator::hydrate($result, new Bilan());
    }
    
    public static function findByProduitId($id, $type) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM bilan INNER JOIN bilan_has_produit 
            ON bilan_id_bilan = id_bilan
            WHERE produit_id_produit = :id AND type = :type AND date_creation = 
            (SELECT MAX(date_creation) FROM bilan INNER JOIN bilan_has_produit
            ON bilan_id_bilan = id_bilan
            WHERE produit_id_produit = :id AND type = :type)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':type', $type);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return Hydrator::hydrate($result, new Bilan());
    }
    
    
    
    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO bilan (montant_total, type) 
            VALUES (:montant_total, :type)");
        $stmt->bindParam(':montant_total', $this->montant_total);
        $stmt->bindParam(':type', $this->type);
        $stmt->execute();
    }
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

}