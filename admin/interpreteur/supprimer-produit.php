<?php
session_start();

require_once("../../base.php");
require_once("../../modele/Hydrator.php");
require_once("../../modele/Produit.php");

if (isset($_SESSION['membre']) === true && isset($_SESSION['admin']) === true && isset($_GET['id_produit']) === true) {

    $produit = Produit::findById($_GET['id_produit']);
    $produit->delete();
}

header("Location: ../../liste-produit.php");
exit;