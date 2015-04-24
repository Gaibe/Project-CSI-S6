<?php

class Display {

    /**
    *   Affiche un produit dans un cadre
    */
    public static function displayProduit($produit, $categorie) {
        $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
        (isset($_SESSION['membre']) === true) ? $id_client = $_SESSION['membre'] : $id_client = "";
        $reduction = Produit::findReducProd($produit["id_produit"],$id_client);
        echo '
            <div class="col-md-4 col-sm-6">
                <div class="panel panel-default panel-produit">
                    <div class="panel-heading">
                        <a href="/' . $project_name . '/liste-produit.php?categorie=' . $categorie["id_categorie"] . '" class="pull-right">' . $categorie["nom"] . '</a> 
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
                    
                    ';
                    if ($reduction === false) {
                        echo '<p class="price">' . $produit["prix"] .' €</p>';
                    } else {
                        ($reduction['montant_reduction'] == ceil($reduction['montant_reduction'])) ? 
                            $montant_reduction = sprintf('%.0f',$reduction['montant_reduction']) : $montant_reduction = $reduction['montant_reduction'];
                        echo '<span class="label label-warning montant-reduction">-'.$montant_reduction.' %</span>';
                        echo '<p class="price">
                            <strong style="color:red;">'.number_format($reduction['prixreduit'], 2) . ' €</strong>  <s>' . $produit["prix"] . ' €</s>
                            </p>';
                    }
                    echo '
                </div> 
            </div>
        ';
        self::displayProduitModal($produit, $categorie);
    }



    /**
    *   Affichage complet d'un produit dans une fenetre modal
    */
    public static function displayProduitModal($produit, $categorie) {
        $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
        (isset($_SESSION['membre']) === true) ? $id_client = $_SESSION['membre'] : $id_client = "";
        $reduction = Produit::findReducProd($produit["id_produit"],$id_client);
        echo '
            <div class="modal fade" id="produit-id-' . $produit["id_produit"] . '" tabindex="-1" role="dialog" aria-labelledby="#titleLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="titleLabel">' . $produit["libelle"] . '</h3>
                    </br>
                    ';
                    if ($reduction === false) {
                        echo '' . $produit["prix"] .' €';
                    } else {
                        ($reduction['montant_reduction'] == ceil($reduction['montant_reduction'])) ? 
                            $montant_reduction = sprintf('%.0f',$reduction['montant_reduction']) : $montant_reduction = $reduction['montant_reduction'];
                        echo '
                            <s>' . $produit["prix"] . ' €</s>  <strong style="color:red;">'.number_format($reduction['prixreduit'], 2) . ' €</strong>
                            <span class="label label-warning modal-montant-reduction">-'.$montant_reduction.' %</span>
                        ';
                    }
                    echo '
                    <a href="/' . $project_name . '/liste-produit.php?categorie=' . $categorie["id_categorie"] . '" class="pull-right">' . $categorie["nom"] . '</a> 
                  </div>
                  <div class="modal-body">
                    <img src="' . $produit["image_url"] . '" class="img-responsive" alt="image du produit">
                    <center>
                        ' . nl2br($produit["description"]) . '
                    </center>
                  </div>
                  <div class="modal-footer">
        ';
        if (isset($_SESSION["admin"]) === true) {
            echo '
                            <div class="col-md-4">
                                <a class="btn btn-danger" href="/'. $project_name .'/admin/interpreteur/supprimer-produit.php?id_produit=' . $produit["id_produit"] . '">
                                    Supprimer
                                </a>
                            </div>
            ';
        }
        echo '
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


    /**
    *   Affiche le contenu du panier d'un membre
    */
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

    /**
    *   Affiche le panier d'un visiteur
    *   Session have to be started
    */
    public static function displayPanierVisiteur() {
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
                    foreach($_SESSION['panier'] as $id_produit => $produit_in_panier) {
                        $produit = Produit::findById($id_produit);
                        if ($produit !== -1 && $produit_in_panier > 0) {
                            echo '
                            <tr>
                                <td>' . $produit->__get("libelle") . '</td>
                                <td>' . $produit->__get("prix") . '</td>
                                <td id="quantite-panier-' . $produit->__get("id_produit") . '">' . $produit_in_panier . ' 
                                <button id="add-'. $produit->__get("id_produit") .'" class="btn btn-default btn-quantite-change" onclick="addOne('.$produit->__get("id_produit").')">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                <button id="remove-'. $produit->__get("id_produit") .'" class="btn btn-default btn-quantite-change" onclick="removeOne('.$produit->__get("id_produit").')">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                                </td>
                                <td id="montant-panier-'. $produit->__get("id_produit") .'">' . ($produit_in_panier*$produit->__get("prix")) . '</td>
                                <td class="table-delete"><a href="../panier/remove-panier.php?id_produit=' . $produit->__get("id_produit") . '&id_panier=-1">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </a></td>
                            </tr>
                            ';
                        }
                    }
                    echo '
                    </tbody>
                </table>
                <p class="panier-total">
                    Total :
                    <span class="panier-total-quantite">' .  $_SESSION['panier-quantite'] . '</span>
                    <span class="panier-total-prix">' . $_SESSION['panier-prix'] . '</span>
                </p>
            </div>

        </div>
        ';
    }


    /**
    *   Affiche la liste des magasin
    *   Session had to be started
    */
    public static function displayMagasin($list_magasin) {
        echo '
        <div class="panier-table">
            <h3><center>Nos Magasins :</center></h3>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
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
                        if (isset($_SESSION['magasin']) === true && $magasin->__get('id_magasin') == $_SESSION['magasin']) {
                            $class = "active";
                        }
                        else {
                            $class = "";
                        }
                        echo '
                        <tr id="id-magasin-' . $magasin->__get("id_magasin") . '" class="table-magasin ' . $class . '">
                            <td>' . $magasin->__get("nom") . '</td>
                            <td>' . $magasin->__get("adresse")->getRue() . '</td>
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

    public static function displayConfirmation($magasin, $commande) {
        $date_retrait = new DateTime($commande->__get("heure_retrait"));
        echo '
        <h1><center>Confirmer ces informations :</center></h1>
        <h2><center>Commande n°'.$commande->__get("id_commande").'</center></h2>
        <h3>Magasin :</h3>
        <p>
            '. $magasin->__get("nom") . ' - ' . $magasin->__get("adresse")->getRue() . ' - ' . 
            $magasin->__get("adresse")->__get("code_postal") . ' ' . $magasin->__get("adresse")->__get("ville") . '
        </p>
        <h3>Retrait :</h3>
        <p>
            Le '.$date_retrait->format("d/m/Y").' à '.$date_retrait->format("H:i").' 
            au quai n°'.$commande->__get("num_quai").'
        </p>
        ';
    }

    public static function displayCreneau($id_magasin) {
        $date = date("Y-m-d");
        // var_dump(date("d-m-Y", strtotime("$date +8 day")));
        for ($day = date("Y-m-d",strtotime("$date +1 day")); 
            $day < date("Y-m-d", strtotime("$date +5 day")); 
            $day = date("Y-m-d", strtotime("$day +1 day"))) 
        {
            if (date("w", strtotime($day)) !== "6" && date("w", strtotime($day)) !== "0") {
                $list_horaire = Magasin::horaireOuverture($day);
                echo '
                <h4><center>' . date("d/m/Y",strtotime($day)) . '</center></h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        ';
                        foreach($list_horaire as $horaire) {
                            // Verifie si la date n'est pas antérieur
                            if ($horaire > date("d-m-Y H:i")) {
                                // Recherche dans la base de donnée si l'horaire est deja donnée
                                $commande = Commande::findHeureRetrait($id_magasin, $horaire);
                               
                                if ($commande !== -1 && sizeof($commande) >= Magasin::NB_QUAI) {
                                    echo '
                                    <tr class="table-creneau col-xs-2 disabled" title="Tous les quais sont déjà reservé">
                                        <td>
                                            <a class="no-style">
                                                <s>' . $horaire->format("H:i") . '</s>
                                            </a>
                                        </td>
                                        
                                    </tr>
                                    ';
                                }
                                else {
                                    echo '
                                    <tr class="table-creneau col-xs-2">
                                        <td>
                                            <a class="no-style" href="ajout-commande.php?day='.date('d',strtotime($day)).
                                            '&month='.date('m',strtotime($day)).'&year='.date('Y',strtotime($day)).
                                            '&hour='.$horaire->format('H').'&min='.$horaire->format('i').'">
                                                ' . $horaire->format("H:i") . '
                                            </a>
                                        </td>
                                        
                                    </tr>
                                    ';
                                }
                                
                            }
                        }
                        echo '
                        </tbody>
                    </table>
                </div>
                ';
            }
        }
    }

    public static function displayConfirmationPanier($panier, $panier_has_produit) {
        include_once("../modele/Produit.php");
        echo '
        <h3><center>Votre Panier</center></h3>
        <div class="table-responsive">
            <table class="table table-bordered">
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
                        <td>' . $produit_in_panier["quantite"] . ' </td>
                        <td>' . ($produit_in_panier["quantite"]*$produit_in_panier["prix_produit"]) . '</td>
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

        ';
    }

    public static function displayHistoriqueCommande($client) {
        echo '
<center>
    <div class="btn-group" role="group">
        <a href="./" class="btn btn-primary" role="button">Votre profil</a>
        <a href="modifier-mdp.php" class="btn btn-primary" role="button">Modifier votre mot de passe</a>
        <a class="btn btn-primary active" role="button">Vos commandes</a>
    </div>
</center>
</br>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        Voici un texte d exemple
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        Et voici un autre texte d exemple
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
        Voici ici-meme le 3eme texte exemple
      </div>
    </div>
  </div>
</div>
        ';
    }
    
}
