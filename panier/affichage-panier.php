<?php

require_once("../header.php");
require_once("../front-office/Display.php");

echo '
<div class="container" id="main">
    <div class="row">
';

if (isset($_SESSION['membre']) === true) {
    $panier = Panier::findByClientIdValide($_SESSION['membre']);
    $panier_has_produit = Panier_Has_Produit::findByPanierId($panier->__get("id_panier"));
    if ($panier_has_produit !== -1) {
        Display::displayPanierMembre($panier, $panier_has_produit);
        echo '<a href="#" class="btn btn-primary pull-right" role="button">Confirmer la commande</a>';
    }
    else {
        echo '<h4><center>Aucun produit dans votre panier</center></h4>';
    }
}
else {
    if ($_SESSION['panier-quantite'] > 0) {
        Display::displayPanierVisiteur();
        echo '<a href="#" class="btn btn-primary pull-right" role="button">Confirmer la commande</a>';
    }
    else {
        echo '<h4><center>Aucun produit dans votre panier</center></h4>';
    }
}

echo '
    <div id="empty-div-panier">
    </div>
    </div>
</div>
';


require_once("../footer.php");

?>

 <script type="text/javascript">
    function addOne(id_produit) {
        var quantite = $("#quantite-panier-"+id_produit).html();
        $.ajax({
            url: 'change-quantite.php',
            data: {action: 'add', id_produit: id_produit},
            type: 'POST',
            success: function(result) {
                $("#empty-div-panier").html(result);
            }
        })
        .done(function() {
            location.reload();
        });
    }

    function removeOne(id_produit) {
        var quantite = $("#quantite-panier-"+id_produit).html();
        $.ajax({
            url: 'change-quantite.php',
            data: {action: 'remove', id_produit: id_produit},
            type: 'POST',
            success: function(result) {
                $("#empty-div-panier").html(result);
            }
        })
        .done(function() {
            location.reload();
        });
    }

</script>