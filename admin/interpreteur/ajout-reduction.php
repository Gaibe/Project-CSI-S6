<?php

require_once("../../base.php");
require_once("../../modele/Hydrator.php");
require_once("../../modele/Reduction.php");
require_once("../../modele/Client.php");


if (isset($_POST['Montant']) === true && isset($_POST['NbProduit']) === true 
    && isset($_POST['DateFin']) === true){

    
    $reduction = new Reduction();
    $reduction->__set('montant_reduction', $_POST['Montant']);
    $reduction->__set('nb_produit', $_POST['NbProduit']);
    $reduction->__set('date_fin', $_POST['DateFin']);
    $reduction->insert();
    
    
    if (isset($_POST['Produits']) && !empty($_POST['Produits'])){
        $connection = base::getConnection();
        $list_prod = $_POST['Produits'];
        foreach($list_prod as $prod){
            $stmt = $connection->prepare("INSERT INTO reduction_has_produit (reduction_id_reduction, produit_id_produit) VALUES (:reduction_id_reduction, :produit_id_produit)");
            $stmt->bindParam(':reduction_id_reduction', $reduction->__get('id_reduction'));
            $stmt->bindParam(':produit_id_produit', $prod);
            $stmt->execute();
        }
    
    }
    
    if (isset($_POST['Clients']) && !empty($_POST['Clients'])){
        $connection = base::getConnection();
        $list_client = $_POST['Clients'];
        foreach($list_client as $client){
            $stmt = $connection->prepare("INSERT INTO reduction_has_client (reduction_id_reduction, client_id_client) VALUES (:reduction_id_reduction, :client_id_client)");
            $stmt->bindParam(':reduction_id_reduction', $reduction->__get('id_reduction'));
            $stmt->bindParam(':client_id_client', $client);
            $stmt->execute();
        }
    
    }
    
    else if (isset($_POST['Clients']) && empty($_POST['Clients'])){
        $connection = base::getConnection();
        $list_client = Client::findAll();
        foreach($list_client as $client){
            $stmt = $connection->prepare("INSERT INTO reduction_has_client (reduction_id_reduction, client_id_client) VALUES (:reduction_id_reduction, :client_id_client)");
            $stmt->bindParam(':reduction_id_reduction', $reduction->__get('id_reduction'));
            $stmt->bindParam(':client_id_client', $client->__get('id_client'));
            $stmt->execute();
        }
    }
}


header("Location: ../../");
exit;
 

