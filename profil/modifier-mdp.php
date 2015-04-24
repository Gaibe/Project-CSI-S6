<?php

require_once("../header.php");
require_once("../front-office/Formulaire.php");

if (isset($_SESSION['membre']) == true) {
    $client = Client::findById($_SESSION['membre']);
    Formulaire::changerMDP();
}
else {
    header("Location: ../");
    exit;
}

require_once("../footer.php");