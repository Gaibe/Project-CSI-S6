<?php
require_once("header.php");
require_once("modele/Produit.php");
require_once("front-office/ProduitAffichage.php")

?>

<div class="container" id="main">
    <div class="row">







        <div class="btn-group btn-group-justified" role="group" id="groupe-de-categorie">
            <?php
            foreach (Categorie::findAll() as $categorie) {
            ?>
                <div class="btn-group" data-toggle="buttons">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" 
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
                $link_categorie = "#";
                foreach (Produit::findByCategorie($categorie['id_categorie']) as $produit) {
                    ProduitAffichage::displayProduit(
                        $produit['libelle'], 
                        $produit['prix'], 
                        $link_categorie, 
                        $categorie['nom'], 
                        $produit['description'],
                        $produit['image_url']);
                }
                ?>
            </div>
        <?php
        }
        ?>

    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#groupe-de-categorie input").click(function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            console.log("#".concat(id));
            $("#".concat(id)).tab('show');
        });
    });
</script>

<?php
require_once("footer.php");