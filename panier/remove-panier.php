<?php
require_once("../base.php");
require_once("../modele/Hydrator.php");
require_once("../modele/Panier.php");

if (isset($_GET['id_produit']) === true && isset($_GET['id_panier']) === true) {
    
    $panier = Panier::findById($_GET['id_panier']);
    $panier->retirerProduit($_GET['id_produit']);
    header("Location: ./");
    exit;
}

header("Location: ../");
exit;
