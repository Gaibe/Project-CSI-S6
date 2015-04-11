<?php
$project_name = explode("/", $_SERVER["PHP_SELF"])[1];
session_start();

require_once "base.php";
require_once "modele/Hydrator.php";
require_once "modele/Client.php";


if (isset($_SESSION['membre']) === true) {
    if (isset($_SESSION['admin']) === true) {
        include_once("header/header-admin.php");
    }
    else {
        include_once("header/header-membre.php");
    }
}
else {
    include_once("header/header-visiteur.php");
}