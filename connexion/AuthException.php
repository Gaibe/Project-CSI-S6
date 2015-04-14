<?php

class AuthException extends Exception {
    function __construct() {
        // mauvais mot de passe
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
?>