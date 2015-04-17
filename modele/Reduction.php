<?php

final class Reduction {

    protected $id_reduction;

    protected $montant_reduction;
    
    protected $nb_produit;
    
    protected $date_debut;
    
    protected $date_fin;



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
        $stmt = $connection->prepare("SELECT * FROM reduction WHERE id_reduction = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Reduction());
    }

    public static function findAll() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM reduction");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();

        return Hydrator::hydrate($result, new Reduction());
    }
    
    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO reduction (montant_reduction, nb_produit, date_fin) 
            VALUES (:montant_reduction, :nb_produit, :date_fin)");
        $stmt->bindParam(':montant_reduction', $this->montant_reduction);
        $stmt->bindParam(':nb_produit', $this->nb_produit);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->execute();
        
    }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

