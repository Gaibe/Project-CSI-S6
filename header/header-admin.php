<!-- Appeler dans /header.php -->

<?php 
$client = Client::findById($_SESSION['membre']);

$nb_article_panier = 0;
$montant_panier = "0.00";

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
        <div class="pull-right" style="margin-top:8px; width: 900px;">

            <div class="col-xs-4">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $montant_panier; ?> €</span>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button">
                          Panier <span class="badge"><?php echo $nb_article_panier; ?></span>
                        </button>
                    </span>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="encart-profil bg-info">
                    <span class="glyphicon glyphicon-star" title="admin"></span>
                    <?php echo " " . ucfirst($client->__get('prenom')) . " " . ucfirst($client->__get('nom')); ?>
                </div>
            </div>
            <div class="col-xs-2">
                <a class="btn btn-default center-block" href="/<?php echo $project_name; ?>/deconnexion">
                    <span class="glyphicon glyphicon-remove"></span> Déconnexion
                </a>
            </div>
            <div class="col-xs-2">
                <a class="btn btn-default center-block" href="/<?php echo $project_name; ?>/profil">
                    <span class="glyphicon glyphicon-cog"></span> Profil
                </a>
            </div>
        </div>
    </div>
    <div class="navbar navbar-default" id="subnav">
        <div class="container">

            <div class="col-md-12">
                <div class="navbar-header">            
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Meilleures ventes</a></li>
                        <li><a href="#">Les produits</a></li>
                        <li><a href="#">Les magasins</a></li>
                        <li><a href="#">Ajouter un produit</a></li>
                        <li><a href="#">Bilan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>