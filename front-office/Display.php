<?php

class Display {


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
                                ' . nl2br($produit["description"]) . '
                            </center>
                        </a>
                    </div>
                    <div class="col-md-4 input-group ajout-panier-panel">
                        <span class="input-group-btn">
                            <button id="ajout-' . $produit["id_produit"] . '" type="button" class="btn btn-primary ajout-produit-panier">Ajouter au panier</button>
                        </span>
                        <textarea id="qte-' . $produit["id_produit"] . '" type="text" class="form-control quantite-produit-panier" rows="1">1</textarea>
                    </div><!-- /input-group -->
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
                        ' . nl2br($produit["description"]) . '
                    </center>
                  </div>
                  <div class="modal-footer">
                        <?php
                        if (isset($_SESSION["admin"]) === true) {
                        ?>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger">Supprimer</button>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button id="modal-ajout-' . $produit["id_produit"] . '" type="button" class="btn btn-primary ajout-produit-panier btn-modal">Ajouter au panier</button>
                                </span>
                                <textarea id="modal-qte-' . $produit["id_produit"] . '" type="text" class="form-control quantite-produit-panier" rows="1">1</textarea>
                            </div><!-- /input-group -->
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        ';
    }


    public static function displayPanierMembre($panier, $panier_has_produit) {
        include_once("../modele/Produit.php");
        echo '
        <div class="panier-table">
            <h3><center>Votre Panier</center></h3>
            <div class="table-responsive">
                <table class="table table-bordered table-panier">
                    <thead>
                        <tr>
                        <th>Libelle</th>
                        <th>Prix unitaire</th>
                        <th>Quantite</th>
                        <th>Montant total</th>
                    </tr>
                    </thead>
                        <tbody>
                        ';
                    foreach($panier_has_produit as $produit_in_panier) {
                        $produit = Produit::findById($produit_in_panier["produit_id_produit"]);
                        echo '    
                            
                        <tr>
                            <td>' . $produit->__get("libelle") . '</td>
                            <td>' . $produit_in_panier["prix_produit"] . '</td>
                            <td id="quantite-panier-' . $produit->__get("id_produit") . '">' . $produit_in_panier["quantite"] . ' 
                            <button id="add-'. $produit->__get("id_produit") .'" class="btn btn-default btn-quantite-change" onclick="addOne('.$produit->__get("id_produit").')">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                            <button id="remove-'. $produit->__get("id_produit") .'" class="btn btn-default btn-quantite-change" onclick="removeOne('.$produit->__get("id_produit").')">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                            </td>
                            <td id="montant-panier-'. $produit->__get("id_produit") .'">' . ($produit_in_panier["quantite"]*$produit_in_panier["prix_produit"]) . '</td>
                            <td class="table-delete"><a href="../panier/remove-panier.php?id_produit=' . $produit->__get("id_produit") . '&id_panier='. $panier->__get("id_panier") .'">
                                <span class="glyphicon glyphicon-remove-sign"></span>
                            </a></td>
                        </tr>
                        ';
                    }
                    echo '
                    </tbody>
                </table>
                <p class="panier-total">
                    Total :
                    <span class="panier-total-quantite">' . $panier->__get("quantite_totale") . '</span>
                    <span class="panier-total-prix">' . $panier->__get("prix_total") . '</span>
                </p>
            </div>

        </div>
        ';
    }


    public static function displayMagasin($list_magasin) {
        echo '
        <div class="panier-table">
            <h3><center>Nos Magasins :</center></h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>Nom</th>
                        <th>Rue</th>
                        <th>Code postal</th>
                        <th>Ville</th>
                    </tr>
                    </thead>
                        <tbody>
                        ';
                    foreach($list_magasin as $magasin) {
                        $magasin = Hydrator::hydrate($magasin, new Magasin());
                        $magasin->__set('adresse', Adresse::findByMagasinId($magasin->__get('id_magasin')));
                        echo '    
                            
                        <tr>
                            <td>' . $magasin->__get("nom") . '</td>
                            <td>' . $magasin->__get("adresse")->__get("rue") . '</td>
                            <td>' . $magasin->__get("adresse")->__get("code_postal") . '</td>
                            <td>' . $magasin->__get("adresse")->__get("ville") . '</td>
                        </tr>
                        ';
                    }
                    echo '
                    </tbody>
                </table>
            </div>

        </div>
        ';
    }
    
}
