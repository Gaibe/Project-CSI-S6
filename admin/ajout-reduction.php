<?php
include_once("../header.php");


if (isset($_SESSION['admin']) === false) {
    $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
    header("Location: /$project_name/");
    exit;
}
else {
    include_once("../header.php");
    include_once("../modele/Produit.php");
    $list_prod = Produit::findAll();
?>

<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm" action="interpreteur/ajout-reduction.php" method="POST">
            <h2 class="col-md-offset-3 col-md-8">Ajout d'une réduction</h2><br>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Nom">Montant réduction (en %)</label>
                <div class="col-md-4">
                    <input id="Montant-reduction" type="text" class="form-control" name="Montant" ng-model="Montant" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Description">Nombre de produits avant application</label>
                <div class="col-md-4">
                    <input id="Nb-produits" type="text" class="form-control" name="NbProduit" ng-model="NbProduit" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Image-produit">Date de fin</label>
                <div class="col-md-4">
                    <input id="Date-fin" type="text" class="form-control" name="DateFin" ng-model="DateFin" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Categorie">Produits</label>
                <div class="col-md-4">
                    <select multiple class="form-control" name="Produits">
                        <?php
                        foreach ($list_prod as $prod) {
                        ?>
                        <option value="<?php echo $prod['id_produit']; ?>"><?php echo $categ['libelle']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            
            <div class="form-group">
                <div class="col-md-offset-4 col-md-9">
                    <input type="submit" class="btn btn-default" value="Ajouter une réduction" />
                </div>
            </div>
        </form>
    </div>

</div>
</div>

<?php
include_once("../footer.php");
}

?>