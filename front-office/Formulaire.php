<?php


class Formulaire {



    public static function inscription() {
        echo '
<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm" action="add-user.php" method="POST">
            <h2 class="col-md-offset-4 col-md-8">Inscription</h2><br>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Nom">Nom *</label>
                <div class="col-md-4">
                    <input id="Nom" type="text" class="form-control" name="Nom" ng-model="Nom" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Prenom">Prénom *</label>
                <div class="col-md-4">
                    <input id="Prenom" type="text" class="form-control" name="Prenom" ng-model="Prenom" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Email">Email *</label>
                <div class="col-md-4">
                    <input id="Email" type="email" class="form-control" name="Email" ng-model="Email" placeholder="exemple@mail.com" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Pseudo">Pseudo *</label>
                <div class="col-md-4">
                    <input id="Pseudo" type="text" class="form-control" name="Pseudo" ng-model="Pseudo" required />
                </div>
            </div>
     
            <div class="form-group">
                <label class="col-md-3 control-label" for="Password">Mot de passe *</label>
                <div class="col-md-4">
                    <input id="Password" type="password" class="form-control" name="Password" ng-model="Password" required />
                </div>
            </div>
     
            <div class="form-group">
                <label class="col-md-3 control-label" for="ConfirmPassword">Confirmer le mot de passe *</label>
                <div class="col-md-4">
                    <input id="ConfirmPassword" type="password" class="form-control" name="ConfirmPassword" 
                    ng-model="ConfirmPassword" placeholder="Retaper votre mot de passe" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Rue">Adresse</label>
                <div class="col-md-4">
                    <input id="Rue" type="text" class="form-control" name="Rue" ng-model="Rue" 
                    placeholder="Ex: 6, rue de la Fontaine" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Code_postal">Code postal</label>
                <div class="col-md-4">
                    <input id="Code_postal" type="text" class="form-control" name="Code_postal" ng-model="Code_postal" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Ville">Ville</label>
                <div class="col-md-4">
                    <input id="Ville" type="text" class="form-control" name="Ville" ng-model="Ville" />
                </div>
            </div>
     
            <div class="form-group">
                <div class="col-md-offset-4 col-md-9">
                    <input type="submit" class="btn btn-default" value="S\'inscrire" />
                </div>
            </div>
        </form>
    </div>

</div>
</div>
        ';
    }

    public static function connexion() {
        echo '
<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm" method="POST" action="connect-user.php">
            <h2 class="col-md-offset-4 col-md-8">Connexion</h2><br>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Pseudo">Pseudo</label>
                <div class="col-md-4">
                    <input id="Pseudo" type="text" class="form-control" name="Pseudo" ng-model="Pseudo" />
                </div>
            </div>
           
            <div class="form-group">
                <label class="col-md-3 control-label" for="Password">Mot de passe</label>
                <div class="col-md-4">
                    <input id="Password" type="password" class="form-control" name="Password" ng-model="Password" />
                </div>
            </div>
     
     
            <div class="form-group">
                <div class="col-md-offset-4 col-md-9">
                    <input type="submit" class="btn btn-default" value="Se connecter" />
                </div>
            </div>
        </form>
    </div>

</div>
</div>
        ';
    }


    public static function ajoutProduit($list_categ) {
        echo '
<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm" action="interpreteur/ajout-produit.php" method="POST">
            <h2 class="col-md-offset-3 col-md-8">Ajout d\'un produit</h2><br>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Nom">Nom du produit</label>
                <div class="col-md-4">
                    <input id="Nom-produit" type="text" class="form-control" name="Nom" ng-model="Nom" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Description">Description</label>
                <div class="col-md-4">
                    <textarea id="Description" type="text" class="form-control" name="Description" ng-model="Description" rows="4"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Image-produit">Url de l\'image</label>
                <div class="col-md-4">
                    <input id="Image-produit" type="url" class="form-control" name="Image-produit" ng-model="Image-produit" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Prix">Prix du produit</label>
                <div class="col-md-4">
                    <input id="Prix" type="text" class="form-control" name="Prix" ng-model="Prix" placeholder="0.00" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Categorie">Catégorie</label>
                <div class="col-md-4">
                    <select class="form-control" name="Categorie">';

        foreach ($list_categ as $categ) {
            echo '
                        <option value="' . $categ['id_categorie'] . '">' . $categ['nom'] . '</option>
            ';
        }
        echo '
                    </select>
                </div>
            </div>

            <div class="col-md-offset-2 col-md-6">
                <div class="image-preview">
                    <img id="preview" class="img-responsive img-circle" style="display: none;" src="#" alt="Previsuialisation" title="Previsuialisation">
                </div>
            </div>

            
            <div class="form-group">
                <div class="col-md-offset-4 col-md-9">
                    <input type="submit" class="btn btn-default" value="Ajouter un produit" />
                </div>
            </div>
        </form>
    </div>

</div>
</div>
        ';
    }


    public static function profil($client) {
        if ($client->__get("adresse") === -1) {
            $rue = "";
            $ville = "";
            $code_postal = "";
        }
        else {
            $rue = $client->__get("adresse")->__get("rue");
            $ville = $client->__get("adresse")->__get("ville");
             if ($client->__get("adresse")->__get("code_postal") == 0) {
                $code_postal = "";
            }
            else {
                $code_postal = $client->__get("adresse")->__get("code_postal");
            }
        }

        echo '
<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm" action="update-user.php" method="POST">
            <h2 class="col-md-offset-4 col-md-8">Profil</h2><br>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Nom">Nom</label>
                <div class="col-md-4">
                    <input id="Nom" type="text" class="form-control" name="Nom" ng-model="Nom" value="' . $client->__get("nom") . '" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Prenom">Prénom</label>
                <div class="col-md-4">
                    <input id="Prenom" type="text" class="form-control" name="Prenom" ng-model="Prenom" value="' . $client->__get("prenom") . '" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Email">Email</label>
                <div class="col-md-4">
                    <input id="Email" type="email" class="form-control" name="Email" ng-model="Email" value="' . $client->__get("email") . '" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Pseudo">Pseudo</label>
                <div class="col-md-4">
                    <input id="Pseudo" type="text" class="form-control" name="Pseudo" ng-model="Pseudo" value="' . $client->__get("pseudo") . '" required />
                </div>
            </div>
     
            <div class="form-group">
                <label class="col-md-3 control-label" for="Rue">Adresse</label>
                <div class="col-md-4">
                    <input id="Rue" type="text" class="form-control" name="Rue" ng-model="Rue" 
                    value="' . $rue . '" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Code_postal">Code postal</label>
                <div class="col-md-4">
                    <input id="Code_postal" type="text" class="form-control" name="Code_postal" ng-model="Code_postal" 
                    value="' . $code_postal . '" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Ville">Ville</label>
                <div class="col-md-4">
                    <input id="Ville" type="text" class="form-control" name="Ville" ng-model="Ville" value="' . $ville . '"/>
                </div>
            </div>
     
            <div class="form-group">
                <div class="col-md-offset-4 col-md-9">
                    <input type="submit" class="btn btn-default" value="Modifier mon profil" />
                </div>
            </div>
        </form>
    </div>

</div>
</div>
        ';
    }

    public static function ajoutMagasin() {
        echo '
<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm" action="interpreteur/ajout-magasin.php" method="POST">
            <h2 class="col-md-offset-3 col-md-8">Ajout d\'un magasin</h2><br>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Nom">Nom *</label>
                <div class="col-md-4">
                    <input id="Nom" type="text" class="form-control" name="Nom" ng-model="Nom" required />
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label" for="Rue">Adresse</label>
                <div class="col-md-4">
                    <input id="Rue" type="text" class="form-control" name="Rue" ng-model="Rue" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Code_postal">Code postal *</label>
                <div class="col-md-4">
                    <input id="Code_postal" type="text" class="form-control" name="Code_postal" ng-model="Code_postal" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Ville">Ville *</label>
                <div class="col-md-4">
                    <input id="Ville" type="text" class="form-control" name="Ville" ng-model="Ville" required />
                </div>
            </div>
     
            <div class="form-group">
                <div class="col-md-offset-4 col-md-9">
                    <input type="submit" class="btn btn-default" value="Ajouter" />
                </div>
            </div>
        </form>
    </div>

</div>
</div>
        ';
    }

}