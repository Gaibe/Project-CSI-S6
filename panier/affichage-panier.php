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
    </div>
</div>
';


require_once("../footer.php");