<?php
require_once "base.php";
$connection = base::getConnection();
$project_name = explode("/", $_SERVER["PHP_SELF"])[1];


if (isset($_SESSION['membre']) === false) {
    require_once("header/header-visiteur.php");
}
else {
    if (isset($_SESSION['admin']) === false) {
        require_once("header/header-membre.php");
    }
    else {
        if ($_SESSION['admin'] === true) {
            require_once("header/header-admin.php");
        }
    }
}