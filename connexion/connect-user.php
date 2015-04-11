<?php

require_once 'Authentication.php';

if (isset($_POST['Pseudo']) === true && isset($_POST['Password']) === true) { 
    try {
        Authentication::authenticate($_POST['Pseudo'], $_POST['Password']);
        header('Location: ../');
        exit;
    }
    catch (AuthException $e) {
    }
}
else {
    echo "<script> alert('Certain champs ne sont pas renseignés'); </script>";
    exit;
}