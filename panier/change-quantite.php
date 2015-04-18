<?php
session_start();
require_once("../base.php");
require_once("../modele/Hydrator.php");
require_once("../modele/Panier.php");


if (isset($_POST['action']) === true && isset($_POST['id_produit']) === true) {
    if (isset($_SESSION['membre'])) {

        $panier = Panier::findByClientIdValide($_SESSION['membre']);
        switch($_POST['action']) {
            case "add":
            $panier->ajouterUnProduit($_POST['id_produit']);
            break;

            case "remove":
            $panier->retirerUnProduit($_POST['id_produit']);
            break;
        }
    }
    else {
        switch($_POST['action']) {
            case "add":
            $_SESSION['panier'][$id_produit]++;
            $_SESSION['panier-quantite']++;
            $_SESSION['panier-prix'] += Produit::findById($id_produit);
            break;

            case "remove":
            $_SESSION['panier'][$id_produit]--;
            $_SESSION['panier-quantite']--;
            $_SESSION['panier-prix'] -= Produit::findById($id_produit);
            break;
        }
    }
}
else {
    header("Location: ../");
    exit;
}