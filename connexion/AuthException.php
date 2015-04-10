<?php

class AuthException extends Exception {
    function __construct() {
        echo "<script> alert('Mot de passe erroné'); </script>";
    }
}
?>