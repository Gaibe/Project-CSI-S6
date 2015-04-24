<?php

session_start();
require_once("../base.php");
require_once("../modele/Hydrator.php");
require_once("../modele/Client.php");

if ($_SESSION['membre'] && isset($_POST['ancien-mdp']) === true && isset($_POST['nouveau-mdp']) === true && isset($_POST['confirmation-mdp']) === true) {
    if ($_POST['nouveau-mdp'] === $_POST['confirmation-mdp']) {
        $client = Client::findById($_SESSION['membre']);

        if (sha1($_POST['ancien-mdp']) === $client->__get("mot_passe")){

            $client->__set("mot_passe", sha1($_POST['nouveau-mdp']));
            $client->updateMDP();

            header("Location: ./");
            exit;
        }
        else {
            echo '<script> alert("Votre ancien mot de passe ne correspond pas"); </script>';
            header("refresh: 0;url=modifier-mdp.php");
            exit;
        }
    }
    else {
        echo '<script> alert("La confirmation est differente de votre mot de passe"); </script>';
        header("refresh: 0;url=modifier-mdp.php");
        exit;
    }
}

header("Location: ../");
exit;