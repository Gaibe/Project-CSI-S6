<?php
require_once("../header.php");
require_once("../front-office/Display.php");
require_once("../modele/Commande.php");

if (isset($_SESSION['membre']) == true) {
    $client = Client::findById($_SESSION['membre']);
echo '
<div class="container" id="main">
    <div class="row">
    <center>
        <div class="btn-group" role="group">
            <a href="./" class="btn btn-primary" role="button">Votre profil</a>
            <a href="modifier-mdp.php" class="btn btn-primary" role="button">Modifier votre mot de passe</a>
            <a class="btn btn-primary active" role="button">Vos commandes</a>
        </div>
    </center>
    </br>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

';
    $list_panier = Panier::findByClientIdConfirmer($_SESSION['membre']);

    if ($list_panier == null) {
        echo '
        <h4>Vous n\'avez pas encore passé de commandes</h4>
        ';
    }
    else {
        foreach ($list_panier as $panier) {
            $panier = Hydrator::hydrate($panier, new Panier());
            $commande = Commande::findByPanierId($panier->__get("id_panier"));
            Display::displayHistoriqueCommande($panier, $commande);
        }
    }
    echo '
    </div>
    <noscript>Activer Javascript pour un rendu optimal</noscript>
    </div>
</div>
';
}
else {
    header("Location: ../");
    exit;
}

require_once("../footer.php");