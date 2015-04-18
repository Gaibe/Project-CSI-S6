<?php
include_once("../header.php");

if (isset($_SESSION['admin']) === false) {
    $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
    header("Location: /$project_name/");
    exit;
}
else {
    include_once("../header.php");
    include_once("../front-office/Formulaire.php");
    
    Formulaire::ajoutMagasin();  


    include_once("../footer.php");
}

?>