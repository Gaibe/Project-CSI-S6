<?php

require_once("header.php");
?>

<div class="container" id="main">
    <div class="row">






    <?php
    $nb_produit = 12;

    for ($i = 0; $i < $nb_produit; $i++) {

        // A modifier
        $name_produit = "Nom de l'article";
        $name_categorie = "Categorie";

        $link_produit = "#";
        $link_categorie = "#";

        $description = "Surmontant la crainte que le débit de la parole est inutile. Pourvu que ce soit 
                        un motif pour le détenir. Oubliés pendant près de cinq cents francs d'appointements et 
                        recevant de temps en temps elle sont bonnes les oranges même pour un prix aussi bas !";
        $prix = "0,00";
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
                        <img src="http://www.fid-jaques.ch/wp_2014/wp-content/uploads/2014/04/Icon_WriteArticles-1.png" 
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