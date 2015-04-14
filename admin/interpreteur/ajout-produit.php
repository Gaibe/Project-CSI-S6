<?php

require_once("../../base.php");
require_once("../../modele/Hydrator.php");
require_once("../../modele/Produit.php");

if (isset($_POST['Nom']) === true && isset($_POST['Description']) === true 
    && isset($_POST['Image-produit']) === true && isset($_POST['Prix']) === true) {

    $produit = new Produit();
    $produit->__set('libelle', $_POST['Nom']);
    $produit->__set('prix', $_POST['Prix']);
    $produit->__set('description', $_POST['Description']);
    $produit->__set('image_url', $_POST['Image-produit']);
    $produit->__set('categorie', Categorie::findById($_POST['Categorie']));

    $produit->insert();
}

header("Location: ../../");
exit;