<!-- Appeler dans /header.php -->

<?php 
$client = Client::findById($_SESSION['membre']);


$panier = Panier::findByClientIdValide($_SESSION['membre']);
if ($panier === -1) {
    // Si le client n'a pas de panier, on lui en créé un
    $panier = Panier::panierVide($_SESSION['membre']);
    $panier->insert();
}


if (isset($_SESSION['admin']) === true && $_SESSION['admin'] === true) {
    $is_admin = true;
}
else {
    $is_admin = false;
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
        <form class="navbar-form pull-left" action="/<?php echo $project_name; ?>/recherche.php" method="POST">
            <div class="input-group" style="max-width:600px;">
                <input type="search" class="form-control" placeholder="Rechercher un produit" name="recherche" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-default btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
        <div class="pull-right" style="margin-top:8px; width: 600px;">

            <div class="col-md-4">
                <a href="/<?php echo $project_name; ?>/panier/">
                    <div class="input-group">
                        <span class="input-group-addon"><span id="panier-prix"><?php echo $panier->__get("prix_total"); ?></span> €</span>
                        <span class="input-group-btn">
                            <button class="btn btn-primary disabled" type="button">
                              Panier <span id="panier-quantite" class="badge"><?php echo $panier->__get("quantite_totale"); ?></span>
                            </button>
                        </span>
                    </div>
                </a>
            </div>

            <div class="col-md-5">
                <a class="no-style" href="/<?php echo $project_name; ?>/profil">
                    <div class="encart-profil bg-info" data-toggle="tooltip" data-placement="bottom" title="Accéder à votre profil">
                        <?php if ($is_admin === true) { ?>
                        <span class="glyphicon glyphicon-star" title="admin"></span> 
                        <?php } ?>
                        <?php echo ucfirst($client->__get('prenom')) . " " . ucfirst($client->__get('nom')); ?>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn btn-default center-block" href="/<?php echo $project_name; ?>/deconnexion">
                    <span class="glyphicon glyphicon-remove"></span> Déconnexion
                </a>
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
                        <?php if ($is_admin === true) { ?>
                        <li><a href="/<?php echo $project_name ?>/admin/ajout-produit.php">Ajouter un produit</a></li>
                        <li><a href="/<?php echo $project_name ?>/admin/ajout-reduction.php">Ajouter une réduction</a></li>
                        <li><a href="/<?php echo $project_name ?>/admin/ajout-magasin.php">Ajouter un magasin</a></li>
                        <li><a href="/<?php echo $project_name ?>/admin/affichage-bilan.php">Bilan</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>