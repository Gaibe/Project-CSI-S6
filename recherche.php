<?php

require_once("header.php");
require_once("front-office/ProduitAffichage.php");
require_once("modele/Produit.php");


if (isset($_POST["recherche"]) === true) {
    $list_produit = Produit::findProduit($_POST["recherche"]);
    echo '
<div class="container" id="main">
    <div class="row">
    ';
    if ($list_produit !== -1) {
        foreach ($list_produit as $produit) {
            $categorie = Categorie::findByProduitId($produit['id_produit']);
            
            ProduitAffichage::displayProduit($produit, $categorie);
            
        }
    }
    else {
        echo '<h4><center>Aucun élément ne correspond à votre recherche</center></h4>';
    }
    echo '
    </div>
</div>
    ';
}
else {
    header("Location: ./");
    exit;
}


require_once("footer.php");