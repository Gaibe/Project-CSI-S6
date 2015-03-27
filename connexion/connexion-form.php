<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm">
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