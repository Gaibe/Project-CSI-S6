<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm">
            <h2 class="col-md-offset-4 col-md-8">Inscription</h2><br>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Nom">Nom</label>
                <div class="col-md-4">
                    <input id="Nom" type="text" class="form-control" name="Nom" ng-model="Nom" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Prenom">Prénom</label>
                <div class="col-md-4">
                    <input id="Prenom" type="text" class="form-control" name="Prenom" ng-model="Prenom" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Email">Email</label>
                <div class="col-md-4">
                    <input id="Email" type="email" class="form-control" name="Email" ng-model="Email" placeholder="exemple@mail.com" />
                </div>
            </div>

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
                <label class="col-md-3 control-label" for="ConfirmPassword">Confirmer le mot de passe</label>
                <div class="col-md-4">
                    <input id="ConfirmPassword" type="password" class="form-control" name="ConfirmPassword" 
                    ng-model="ConfirmPassword" placeholder="Retaper votre mot de passe" />
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
                    <input type="submit" class="btn btn-default" value="S'inscrire" />
                </div>
            </div>
        </form>
    </div>

</div>
</div>