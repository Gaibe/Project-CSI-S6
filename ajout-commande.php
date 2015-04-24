<?php
session_start();
require_once("base.php");
require_once("modele/Hydrator.php");
require_once("modele/Panier.php");
require_once("modele/Commande.php");


if (isset($_SESSION['membre']) === true && isset($_GET['day']) === true && isset($_GET['month']) === true && isset($_GET['year'])
    && isset($_GET['hour']) === true && isset($_GET['min'])) {


    $panier = Panier::findByClientIdValide($_SESSION['membre']);
    $commande = new Commande();
    // date au format americain Y-m-d H:i:s
    $date_retrait = new DateTime($_GET['year']."-".$_GET['month']."-".$_GET['day']." ".$_GET['hour'].":".$_GET['min'].":00");
    $commande_in_database = Commande::findHeureRetrait($_SESSION['magasin'], $date_retrait);
    $commande->__set("id_magasin", $_SESSION['magasin']);
    $commande->__set("id_panier", $panier->__get("id_panier"));
    $commande->__set("heure_retrait", $date_retrait);
    $commande->__set("num_quai", sizeof($commande_in_database));
    $commande->insert();


}
else {
    header("Location: confirmer-commande.php");
    exit;
}