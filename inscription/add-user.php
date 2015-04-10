<?php
require_once("../modele/Client.php");

$crypte = sha1($_POST['Password']);
// créer et sauvegarder l'utilisateur
$client = new Client();
$client->__set('nom',strtolower($_POST['Nom']));
$client->__set('prenom',strtolower($_POST['Prenom']));
$client->__set('email',strtolower($_POST['Email']));
$client->__set('pseudo',strtolower($_POST['Pseudo']));
$client->__set('mot_passe',$crypte);
//$client->__set('rue',$_POST['Rue']);
//$client->__set('pseudo',$_POST['Code_Postal']);
//$client->__set('pseudo',$_POST['Ville']);
$client->insert();

echo "Utilisateur enregistré !";