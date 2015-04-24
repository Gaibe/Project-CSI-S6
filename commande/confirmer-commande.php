<?php
require_once("../header.php");
require_once("../front-office/Display.php");
require_once("../modele/Magasin.php");
require_once("../modele/Commande.php");
require_once("../modele/Panier.php");

if (isset($_SESSION['membre']) === true) {
    // si le magasin et la commande sont renseigné => demande de confirmation et paiement
    $panier = Panier::findbyClientIdValide($_SESSION['membre']);
    $panier_has_produit = Panier_Has_Produit::findByPanierId($panier->__get("id_panier"));
    $commande = Commande::findByPanierId($panier->__get("id_panier"));
    if (isset($_SESSION['magasin']) === true && $commande !== -1) {
        echo '
        <div class="container" id="main">
            <div class="row">
                <div class="page-content">
        ';
        $magasin = Magasin::findById($_SESSION['magasin']);
        Display::displayConfirmation($magasin, $commande);
        Display::displayConfirmationPanier($panier, $panier_has_produit);
        echo '
                    
                </div>
                <div class="pull-right">
                    <a href="est-confirmer.php" class="btn btn-primary" role="button">Confirmer et payer</a>
                    <a href="est-annuler.php" class="btn btn-danger" role="button">Annuler</a>
                </div>
            </div>
        </div>
        ';
    }
    else {
        // si le magasin n'est pas encore en session
        if (isset($_SESSION['magasin']) === false) {
            $list_magasin = Magasin::findAll();

            echo '
            <div class="container" id="main">
                <div class="row">
            ';
            Display::displayMagasin($list_magasin);
            echo '
                    <div id="empty-div-magasin">
                    </div>
                </div>
            </div>
            ';
            echo '<script> alert("Veuillez selectionner un magasin pour continuer"); </script>';
        }
        // si le quai et la date de retrait ne sont pas dans la base de données
        else {
            echo '
            <div class="container" id="main">
                <div class="row page-content">
                    <h3>Selectionner un horaire pour le retrait</h3>
                    <small>Le retrait doit se faire au minimum le lendemain de la commande (nos magasins sont fermés le week-end)</small>
                    </br>
                    <small>Une commande ne peut se faire au maximum 5 jours avant son retrait</small>
                    </br>
            ';
            Display::displayCreneau($_SESSION['magasin']);
            echo '
                    <div id="empty-div-magasin">
                    </div>
                </div>
            </div>
            ';
        }
    }
}
// si l'utilisateur n'est pas membre
else {
    echo '<script> alert("Veuillez vous inscrire pour continuer"); </script>';
    header("refresh: 0;url=inscription/");
    exit;
}

?>
<script type="text/javascript">
    $(document).ready(function() {
        $('tr.table-magasin').click(function() {
            ajouterMagasin(this);
        });
    });
</script>

<?php

require_once("../footer.php");