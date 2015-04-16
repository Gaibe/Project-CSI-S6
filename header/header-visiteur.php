<!-- Appeler dans /header.php -->

<?php
if (isset($_SESSION['panier-prix']) === false) {
    $panier = Panier::panierVide();
    $_SESSION['panier-prix'] = $panier->__get("prix_total");
    $_SESSION['panier-quantite'] = $panier->__get("quantite_totale");
}

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>MegaDrive : faites vos courses en ligne</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="/<?php echo $project_name; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="/<?php echo $project_name; ?>/css/styles.css" rel="stylesheet">
        <!-- script references -->
        <script src="/<?php echo $project_name; ?>/js/jquery-2.1.3.min.js"></script>
        <script src="/<?php echo $project_name; ?>/js/bootstrap.min.js"></script>
    </head>
    <body>

<nav class="navbar navbar-fixed-top header">
    <div class="col-md-12">
        
        <div class="navbar-header">
            <a href="/<?php echo $project_name; ?>/" class="navbar-brand">MegaDRIVE</a>
        </div>
        <form class="navbar-form pull-left">
            <div class="input-group" style="max-width:600px;">
                <input type="text" class="form-control" placeholder="Rechercher un produit" name="srch-term" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-default btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
        <div class="pull-right" style="margin-top:8px; width: 600px;">
            <div class="col-xs-4">
                <div class="input-group">
                    <span class="input-group-addon"><span id="panier-prix"><?php echo $_SESSION['panier-prix'] ?></span> €</span>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button">
                          Panier <span id="panier-quantite" class="badge"><?php echo $_SESSION['panier-quantite'] ?></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-xs-4"><a class="btn btn-default center-block" href="/<?php echo $project_name; ?>/inscription"><span class="glyphicon glyphicon-th-list"></span> Inscription</a></div>
            <div class="col-xs-4"><a class="btn btn-default center-block" href="/<?php echo $project_name; ?>/connexion"><span class="glyphicon glyphicon-user"></span> Connexion</a></div>
        </div>
    </div>
</div>
<div class="navbar navbar-default" id="subnav">
    <div class="container">

        <div class="col-md-12">
            <div class="navbar-header">            
                <ul id="navbar-ul" class="nav navbar-nav">
                    <li><a href="/<?php echo $project_name ?>/">Meilleures ventes</a></li>
                    <li><a href="/<?php echo $project_name ?>/liste-produit.php">Les produits</a></li>
                    <li><a href="/<?php echo $project_name ?>/liste-magasin.php">Les magasins</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</nav>