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
        $panier->setValide();

        echo '<script> alert("Votre commande est confirmer"); </script>';
        header("refresh: 0;url=../");
        exit;
    }
}
header("../");
exit;