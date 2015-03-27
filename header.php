<?php
require_once "base.php";
$connection = base::getConnection();
$project_name = explode("/", $_SERVER["PHP_SELF"])[1];
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Drive : faites vos courses en ligne</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="/<?php echo $project_name; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="/<?php echo $project_name; ?>/css/styles.css" rel="stylesheet">
    </head>
    <body>

<nav class="navbar navbar-fixed-top header">
    <div class="col-md-12">
        <div class="navbar-header">
            <a href="/<?php echo $project_name; ?>/" class="navbar-brand">DRIVE</a>
        </div>
        <form class="navbar-form pull-left">
            <div class="input-group" style="max-width:600px;">
                <input type="text" class="form-control" placeholder="Rechercher un produit" name="srch-term" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-default btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
        <div class="pull-right" style="margin-top:8px;">
            <div class="col-xs-6"><a class="btn btn-default center-block" href="/<?php echo $project_name; ?>/inscription"><span class="glyphicon glyphicon-th-list"></span> Inscription</a></div>
            <div class="col-xs-6"><a class="btn btn-default center-block" href="/<?php echo $project_name; ?>/connexion"><span class="glyphicon glyphicon-user"></span> Connexion</a></div>
        </div>
    </div>
</div>
<div class="navbar navbar-default" id="subnav">
    <div class="col-md-12">
        <div class="navbar-header">            
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Meilleures ventes</a></li>
                <li><a href="#">Les produits</a></li>
                <li><a href="#">Les magasins</a></li>
            </ul>
            
        </div>
    </div>
</nav>