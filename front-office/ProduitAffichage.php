<?php
class ProduitAffichage {


    public static function displayProduit($name_produit, $prix, $link_categorie, $name_categorie, $description, $image_url) {
        echo '
            <div class="col-md-4 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="' . $link_categorie . '" class="pull-right">' . $name_categorie . '</a> 
                        <a class="no-style" data-toggle="modal" data-target="#modal-produit">
                            <h4 class="article-titre">' . $name_produit . '</h4>
                        </a>
                    </div>
                    <div class="panel-body">
                        <a class="no-style" data-toggle="modal" data-target="#modal-produit">
                            <img src="' . $image_url . '" 
                                class="img-circle img-responsive" alt="image du produit">
                        </a>
                        <a class="no-style" data-toggle="modal" data-target="#modal-produit">
                            <center class="panel-content">
                                ' . $description . '
                            </center>
                        </a>
                    </div>
                    <p class="price">
                        ' . $prix .' €
                    </p>
                </div> 
            </div>
        ';
        self::displayProduitModal($name_produit, $prix, $link_categorie, $name_categorie, $description, $image_url);
    }




    public static function displayProduitModal($name_produit, $prix, $link_categorie, $name_categorie, $description, $image_url) {
        echo '
            <div class="modal fade" id="modal-produit" tabindex="-1" role="dialog" aria-labelledby="#titleLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="titleLabel">' . $name_produit . '</h3>
                    </br>
                    <span>
                        ' . $prix .' €
                    </span>
                    <a href="' . $link_categorie . '" class="pull-right">' . $name_categorie . '</a> 
                  </div>
                  <div class="modal-body">
                    <img src="' . $image_url . '" class="img-circle img-responsive" alt="image du produit">
                    <center>
                        ' . $description . '
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