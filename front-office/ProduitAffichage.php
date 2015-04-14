<?php
class ProduitAffichage {


    public static function displayProduit($produit, $categorie) {
        echo '
            <div class="col-md-4 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href=categorie/"' . $categorie["id_categorie"] . '" class="pull-right">' . $categorie["nom"] . '</a> 
                        <a class="no-style" data-toggle="modal" data-target="#produit-id-' . $produit["id_produit"] . '">
                            <h4 class="article-titre">' . $produit["libelle"] . '</h4>
                        </a>
                    </div>
                    <div class="panel-body">
                        <a class="no-style" data-toggle="modal" data-target="#produit-id-' . $produit["id_produit"] . '">
                            <img src="' . $produit["image_url"] . '" 
                                class="img-responsive" alt="image du produit">
                        </a>
                        <a class="no-style" data-toggle="modal" data-target="#produit-id-' . $produit["id_produit"] . '">
                            <center class="panel-content">
                                ' . $produit["description"] . '
                            </center>
                        </a>
                    </div>
                    <p class="price">
                        ' . $produit["prix"] .' €
                    </p>
                </div> 
            </div>
        ';
        self::displayProduitModal($produit, $categorie);
    }




    public static function displayProduitModal($produit, $categorie) {
        echo '
            <div class="modal fade" id="produit-id-' . $produit["id_produit"] . '" tabindex="-1" role="dialog" aria-labelledby="#titleLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="titleLabel">' . $produit["libelle"] . '</h3>
                    </br>
                    <span>
                        ' . $produit["prix"] .' €
                    </span>
                    <a href=categorie/"' . $categorie["id_categorie"] . '" class="pull-right">' . $categorie["nom"] . '</a> 
                  </div>
                  <div class="modal-body">
                    <img src="' . $produit["image_url"] . '" class="img-responsive" alt="image du produit">
                    <center>
                        ' . $produit["description"] . '
                    </center>
                  </div>
                  <div class="modal-footer">
                    <?php
                    if (isset($_SESSION["admin"]) === true) {
                    ?>
                      <button type="button" class="btn btn-danger">Supprimer</button>
                    <?php
                    }
                    ?>
                    <button type="button" class="btn btn-primary">Ajouter au panier</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                  </div>
                </div>
              </div>
            </div>
        ';
    }
}