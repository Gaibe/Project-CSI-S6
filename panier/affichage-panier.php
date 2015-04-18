<?php

require_once("../header.php");
require_once("../front-office/ProduitAffichage.php");

echo '
<div class="container" id="main">
    <div class="row">
';

if (isset($_SESSION['membre']) === true) {
    $panier = Panier::findByClientIdValide($_SESSION['membre']);
    $panier_has_produit = Panier_Has_Produit::findByPanierId($panier->__get("id_panier"));

    ProduitAffichage::displayPanierMembre($panier, $panier_has_produit);
}
else {
}

echo '
        <a href="#" class="btn btn-primary pull-right" role="button">Confirmer la commande</a>
    </div>
</div>
';


require_once("../footer.php");

?>

 <script type="text/javascript">
    function addOne() {
        var id = $(this).attr("id");
        var id_produit = id.substring(4);

        refreshQuantite(id_produit, parseInt(quantite)+1);
    }

    function removeOne() {
        var id = $(this).attr("id");
        var id_produit = id.substring(7);
        var quantite_actuel = $("#quantite-panier-"+id_produit);

        refreshQuantite(id_produit, parseInt(quantite)-1);
    }

    function refreshQuantite(id_produit, quantite) {
        if (quantite <= 0) {
            location.reload();
        }
        else {
            var quantite_actuel = $("#quantite-panier"+id_produit).html();
            var montant_actuel = $("#montant-panier"+id_produit).html();
            var montant_unitaire = parseInt(montant_actuel) / parseInt(quantite_actuel);
            var nouvelle_quantite = parseInt(quantite) + parseInt(quantite_actuel);
            var nouveau_montant = parseInt(nouvelle_quantite)*parseInt(montant_unitaire);
            $("#quantite-panier"+id_produit).html(nouvelle_quantite);
            $("#montant-panier"+id_produit).html(nouveau_montant);
            $(".panier-total-quantite").html(parseInt($(".panier-total-quantite").html())+parseInt(quantite));
            $(".panier-total-prix").html(parseInt($(".panier-total-prix").html())+nouveau_montant);
        }
    }

    $(document).ready(function() {
        findActiveTab();
    });

</script>