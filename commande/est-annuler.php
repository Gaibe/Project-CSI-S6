<?php

session_start();

require_once("../base.php");
require_once("../modele/Hydrator.php");
require_once("../modele/Panier.php");
require_once("../modele/Commande.php");

if (isset($_SESSION['membre']) === true) {
    $panier = Panier::findByClientIdValide($_SESSION['membre']);
    $commande = Commande::findByPanierId($panier->__get("id_panier"));
    if ($commande !== -1) {
        $commande->delete();

        header("Location: ../");
        exit;
    }
}
header("Location: ../");
exit;