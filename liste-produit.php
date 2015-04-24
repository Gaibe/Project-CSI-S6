<?php
require_once("header.php");
require_once("modele/Produit.php");
require_once("front-office/Display.php");

?>

<div class="container" id="main">
    <div class="row">


        <div class="btn-group btn-group-justified" role="group" id="groupe-de-categorie">
            <?php
            foreach (Categorie::findAll() as $categorie) {
            ?>
                <div class="btn-group" data-toggle="buttons">
                    <button id="button-<?php echo $categorie['id_categorie'] ?>" 
                        class="btn btn-primary btn-categorie" 
                        type="button" data-toggle="collapse" 
                        data-target="#id-<?php echo $categorie['id_categorie'] ?>" 
                        aria-expanded="false" aria-controls="collapseExample">
                      <?php echo $categorie['nom']; ?>
                    </button>
                </div>

                
            <?php
            }
            ?>
        </div>

        <?php
        foreach (Categorie::findAll() as $categorie) {
        ?>
            <div class="collapse" id="id-<?php echo $categorie['id_categorie'] ?>">
                <?php
                
                foreach (Produit::findByCategorie($categorie['id_categorie']) as $produit) {
                    Display::displayProduit($produit, $categorie);
                }
                ?>
            </div>
        <?php
        }
        ?>
        <noscript>
            Activer Javascript pour pouvoir accéder à l'ensemble du contenu
        </noscript>

    </div>
</div>

<div id="empty-div">

</div>



<script type="text/javascript">


    $(document).ready(function(){
        

        $(".ajout-produit-panier").click(function(){
            ajouterProduitPanier(this);
        });

        <?php
        if (isset($_GET['categorie']) === true) {
        ?>
            var id_categorie = <?php echo $_GET['categorie']; ?>;
            $("#button-"+id_categorie).addClass("active");
            $("#id-"+id_categorie).collapse("toggle");
        <?php
        }
        else {
        ?>
            $(".collapse").first().collapse("toggle");
            $(".btn-categorie").first().addClass("active");
        <?php
        }
        ?>

    });
</script>


<?php
require_once("footer.php");