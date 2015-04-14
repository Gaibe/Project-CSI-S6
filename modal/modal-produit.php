<?php
// CONTRAINTES :
// $name_produit      Nom du produit
// $prix              Prix du produit
// $link_categorie    Lien vers la catégorie
// $name_categorie    Nom de la catégorie
// $description       Description du produit

?>


<!-- Modal -->
<div class="modal fade" id="modal-produit" tabindex="-1" role="dialog" aria-labelledby="#titleLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="titleLabel"><?php echo $name_produit; ?></h3>
        </br>
        <span class="price">
            <?php echo $prix; ?> €
        </span>
        <a href="<?php echo $link_categorie; ?>" class="pull-right"><?php echo $name_categorie; ?></a> 
      </div>
      <div class="modal-body">
        <img src="http://www.fid-jaques.ch/wp_2014/wp-content/uploads/2014/04/Icon_WriteArticles-1.png" class="img-circle img-responsive" alt="image du produit">
        <center>
            <?php echo $description; ?>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Ajouter au panier</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>