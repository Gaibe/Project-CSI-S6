<?php
session_start();

require_once("base.php");
require_once("modele/Hydrator.php");
require_once("modele/Produit.php");
require_once("modele/Panier.php");

if (isset($_POST['id_produit']) === true) {


    echo "SAAAAAAAAAAAAALUUUUUUUUUUUT !!!!!!";
    $id_produit = $_POST['id_produit'];
    $quantite = $_POST['quantite'];

    $produit = Produit::findById($id_produit);
    $montant = $produit->__get("prix")*$quantite;

    if (isset($_POST['membre']) === true) {
        $panier = Panier::findByClientId($_POST['membre']);
        $panier->addMontant($montant);
        $panier->addQuantite($quantite);
        $panier->ajouterProduit($produit->__get("id_produit"), $quantite, $produit->__get("prix"));
    }

    else {
        if (isset($_POST['panier'][$id_produit]) === true) {
            $_POST['panier'][$id_produit] += $quantite;
        }
        else {
            $_POST['panier'][$id_produit] = $quantite;
        }
    }

}
else {
    header("Location: ./");
}