<?php
session_start();

if (isset($_POST['id_magasin'])) {
    $_SESSION['magasin'] = $_POST['id_magasin'];
}