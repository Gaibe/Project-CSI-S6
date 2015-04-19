<?php
session_start();

require_once("../base.php");
require_once("../modele/Hydrator.php");
require_once("../modele/Panier.php");

if (isset($_GET['id_produit']) === true && isset($_GET['id_panier']) === true) {

    if ($_GET['id_panier'] != -1) {   
        $panier = Panier::findById($_GET['id_panier']);
        $panier->retirerProduit($_GET['id_produit']);
    }
    else {
        include_once("../modele/Produit.php");

        $produit = Produit::findById($_GET['id_produit']);
        $_SESSION['panier-quantite'] -= $_SESSION['panier'][$_GET['id_produit']];
        $_SESSION['panier-prix'] -= ($_SESSION['panier'][$_GET['id_produit']] * $produit->__get("prix"));
        unset($_SESSION['panier'][$_GET['id_produit']]);
    }
    header("Location: ./");
    exit;
}

header("Location: ../");
exit;
