<?php

require_once("../../base.php");
require_once("../../modele/Hydrator.php");
require_once("../../modele/Magasin.php");

if (isset($_POST['Nom']) === true && isset($_POST['Ville']) === true && isset($_POST['Code_postal']) === true) {

    $magasin = new Magasin();
    $magasin->__set('nom', $_POST['Nom']);
    
    $adresse = new Adresse();
    $adresse->__set('rue', $_POST['Rue']);
    $adresse->__set('code_postal', $_POST['Code_postal']);
    $adresse->__set('ville', $_POST['Ville']);

    $magasin->__set('adresse', $adresse);
    $magasin->insert();
}

header("Location: ../../");
exit;