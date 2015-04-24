<?php

require_once("../../base.php");
require_once("../../modele/Hydrator.php");
require_once("../../modele/Reduction.php");
require_once("../../modele/Client.php");
require_once("../../modele/Produit.php");
$connection = base::getConnection();


if (isset($_POST['Montant']) === true && isset($_POST['NbProduit']) === true 
    && isset($_POST['DateFin']) === true){

    
    $reduction = new Reduction();
    $reduction->__set('montant_reduction', $_POST['Montant']);
    $reduction->__set('nb_produit', $_POST['NbProduit']);
    $reduction->__set('date_fin', $_POST['DateFin']);
    $reduction->insert();
    $idreduction = $connection->lastInsertId();
    
    if (isset($_POST['Produits']) && !empty($_POST['Produits'])){
        $connection = base::getConnection();
        $list_prod = $_POST['Produits'];
        foreach($list_prod as $prod){
            Reduction::insertReductionHasProduit($idreduction, $prod);
        }
    
    }
    
    if (isset($_POST['Clients']) && !empty($_POST['Clients'])){
        $connection = base::getConnection();
        $list_client = $_POST['Clients'];
        foreach($list_client as $client){
            Reduction::insertReductionHasClient($idreduction, $client);
        }
    
    }
    
    else{
        $connection = base::getConnection();
        $list_client = Client::findAll();
        foreach($list_client as $client){
            $idclient = $client["id_client"];
            Reduction::insertReductionHasClient($idreduction, $idclient);
        }
    }
     
     
}


header("Location: ../../");
exit;
 
 

