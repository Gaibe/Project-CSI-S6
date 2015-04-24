<?php

require_once("header.php");
require_once("modele/Produit.php");
require_once("front-office/Display.php");
?>



<?php
    $nb_best_seller = 12;
    $best_seller = Produit::findBestSellers($nb_best_seller);
?>


<div class="container" id="main">
    <div class="row">


    <?php
    foreach ($best_seller as $produit) {
        $categorie = Categorie::findByProduitId($produit["id_produit"]);
        Display::displayProduit($produit, $categorie);
    }
    ?>

    </div>
</div>

<div id="empty-div">

</div>



<script type="text/javascript">
    

    $(document).ready(function(){
        

        $(".ajout-produit-panier").click(function(){
            ajouterProduitPanier(this);
        });

        

    });
</script>

<?php

require_once("footer.php");