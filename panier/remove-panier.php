<?php
require_once("../base.php");
require_once("../modele/Panier.php");

if (isset($_GET['id_produit']) === true && isset($_GET['id_panier']) === true) {
    $produit_panier = new Panier_Has_Produit();
    $produit_panier->__set("produit_id_produit", $_GET['id_produit']);
    $produit_panier->__set("panier_id_panier", $_GET['id_panier']);
    $produit_panier->delete();
    header("Location: ./");
    exit;
}

header("Location: ../");
exit;
