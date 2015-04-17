<?php
require_once("header.php");
require_once("modele/Produit.php");
require_once("front-office/ProduitAffichage.php");

$link_categorie = "#";
?>

<div class="container" id="main">
    <div class="row">


        <div class="btn-group btn-group-justified" role="group" id="groupe-de-categorie">
            <?php
            foreach (Categorie::findAll() as $categorie) {
            ?>
                <div class="btn-group" data-toggle="buttons">
                    <button id="button-<?php echo $categorie['id_categorie'] ?>" class="btn btn-primary btn-categorie" type="button" data-toggle="collapse"
                        data-target="#id-<?php echo $categorie['id_categorie'] ?>" aria-expanded="false" aria-controls="collapseExample">
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
                    ProduitAffichage::displayProduit($produit, $categorie);
                }
                ?>
            </div>
        <?php
        }
        ?>

    </div>
</div>

<div id="empty-div">

</div>



<script type="text/javascript">
    $(document).ready(function(){
        $(".ajout-produit-panier").click(function(){
            var id = $(this).attr("id");
            if ($(this).attr("id") == $(".btn-modal").attr("id")) {
                var id_produit = id.substring(12);
                var quantite = $("#modal-qte-"+id_produit).val();
            }
            else {
                var id_produit = id.substring(6);
                var quantite = $("#qte-"+id_produit).val();
            }

            if (quantite <= 0 || quantite == null) {
                quantite = 0;
                alert("Aucun produit à ajouté");
            }
            else {
                $.ajax({
                    url: "ajout-produit-panier.php",
                    type: "POST",
                    data: { id_produit : id_produit, quantite : quantite },
                    dataType: "html",
                    success: function(result) {
                        $("#empty-div").html(result);
                    }
                })
                .done(function() {
                    alert("Produit ajouté");
                });
            }
        });

    });
</script>


<?php
require_once("footer.php");