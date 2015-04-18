<?php
session_start();
require_once("../base.php");
require_once("../modele/Hydrator.php");
require_once("../modele/Client.php");

if ($_SESSION['membre']) {
    $client = new Client();
    $client->__set('nom',strtolower($_POST['Nom']));
    $client->__set('prenom',strtolower($_POST['Prenom']));
    $client->__set('email',strtolower($_POST['Email']));
    $client->__set('pseudo',strtolower($_POST['Pseudo']));
    $client->__set('id_client', $_SESSION['membre']);

    $adresse = Adresse::findByClientId($_SESSION['membre']);
    $rue = $_POST['Rue'];
    if ($_POST['Rue'] == null) {
        $rue ="";
    }
    $ville = $_POST['Ville'];
    if ($_POST['Ville'] == null) {
        $ville ="";
    }
    $code_postal = $_POST['Code_postal'];
    if ($_POST['Code_postal'] == null) {
        $code_postal ="";
    }
    $adresse->__set('rue', $rue);
    $adresse->__set('ville', $ville);
    $adresse->__set('code_postal', (int)$code_postal);

    $client->__set('adresse', $adresse);
    $client->update();

    header("Location: ./");
    exit;
}

header("Location: ../");
exit;