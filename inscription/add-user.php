<?php
session_start();

require_once("../base.php");
require_once("../modele/Client.php");
require_once("../connexion/Authentication.php");
require_once("../modele/Panier.php");

if(isset($_POST['Nom']) === true && isset($_POST['Prenom']) === true && 
    isset($_POST['Email']) === true && isset($_POST['Pseudo']) === true && isset($_POST['Password']) === true && 
    $_POST['Password'] === $_POST['ConfirmPassword']) {

    $crypte = sha1($_POST['Password']);
    // créer et sauvegarder l'utilisateur
    $client = new Client();
    $client->__set('nom',strtolower($_POST['Nom']));
    $client->__set('prenom',strtolower($_POST['Prenom']));
    $client->__set('email',strtolower($_POST['Email']));
    $client->__set('pseudo',strtolower($_POST['Pseudo']));
    $client->__set('mot_passe',$crypte);


    $adresse = new Adresse();
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
    $adresse->__set('code_postal', $code_postal);

    $client->__set('adresse', $adresse);
    $client->insert();

    $client_inserer = Client::findLastInserted();
    // stockage de l'id client en session
    $_SESSION['membre'] = $client_inserer->__get("id_client");

    // Création d'un nouveau panier
    $panier = Panier::panierVide($_SESSION['membre']);
    $panier->insert();

    Authentication::savePanier($panier);

    header('Location: ../');
    exit;
}
else {
    header('Location: ./');
    exit;
}