<?php

require_once("header.php");
require_once("modele/Produit.php");
?>

<div class="container" id="main">
    <div class="row">





    <?php
// Tout est a refaire ici

    $result = Produit::findBestSellers(10);

    for ($i = 0; $i < 10; $i++) {

        // A modifier
        $name_produit = $result[$i]["libelle"];
        $name_categorie = $result[$i]["nomcateg"];

        $link_produit = "#";
        $link_categorie = "#";

        $description = $result[$i]["description"];
        $prix = $result[$i]["prix"];
    ?>
      




        <div class="col-md-4 col-sm-6">

            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="<?php echo $link_categorie; ?>" class="pull-right"><?php echo $name_categorie; ?></a> 
                    <a class="no-style" data-toggle="modal" data-target="#modal-produit">
                        <h4><?php echo $name_produit; ?></h4>
                    </a>
                </div>
                <div class="panel-body">
                    <a class="no-style" data-toggle="modal" data-target="#modal-produit">
                        <img src= "<?php $result[$i]["image_url"] ?>"
                            class="img-circle img-responsive" alt="image du produit">
                    </a>
                    <a class="no-style" data-toggle="modal" data-target="#modal-produit">
                        <center class="panel-content">
                            <?php echo $description; ?>
                        </center>
                    </a>
                </div>
                <p class="price pull-right">
                    <?php echo $prix; ?> €
                </p>
            </div> 
        </div>


    <?php
        include "modal/modal-produit.php";
        // ProduitAffichage::displayProduit($produit, $categorie);
    }
    ?>

</div>
</div>

<?php

require_once("footer.php");