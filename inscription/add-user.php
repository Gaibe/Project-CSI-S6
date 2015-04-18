<?php
require_once("../base.php");

require_once("../modele/Client.php");

$crypte = sha1($_POST['Password']);
// créer et sauvegarder l'utilisateur
$client = new Client();
$client->__set('nom',strtolower($_POST['Nom']));
$client->__set('prenom',strtolower($_POST['Prenom']));
$client->__set('email',strtolower($_POST['Email']));
$client->__set('pseudo',strtolower($_POST['Pseudo']));
$client->__set('mot_passe',$crypte);


$adresse = new Adresse();
$adresse->__set('rue',$_POST['Rue']);
$adresse->__set('ville',$_POST['Ville']);
$adresse->__set('code_postal',$_POST['Code_postal']);

$client->__set('adresse', $adresse);
$client->insert();

header('Location: ../');
exit;