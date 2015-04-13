<?php
session_start();

if (isset($_SESSION['admin']) === false) {
    $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
    header("Location: /$project_name/");
    exit;
}
else {
    include_once("../header.php");
    
    $list_categ = array("Boisson", "Alimentaire");
    
?>
<div class="container" id="main">
<div class="row">
    <div class="col-md-offset-2" ng-app="sample">
        <form class="form-horizontal" name="registerForm" action="add-user.php" method="POST">
            <h2 class="col-md-offset-3 col-md-8">Ajout d'un produit</h2><br>

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
                <label class="col-md-3 control-label" for="Prix">Prix du produit</label>
                <div class="col-md-4">
                    <input id="Prix" type="text" class="form-control" name="Prix" ng-model="Prix" placeholder="0.00" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Categorie">Catégorie</label>
                <div class="col-md-4">
                    <select class="form-control">
                        <?php
                        foreach ($list_categ as $categ) {
                        ?>
                        <option value="<?php echo $categ; ?>"><?php echo $categ; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="Image-produit">Url de l'image</label>
                <div class="col-md-4">
                    <input id="Image-produit" type="url" class="form-control" name="Image-produit" ng-model="Image-produit" />
                </div>
            </div>

            <div class="image-preview">
                <img id="preview" class="img-responsive" style="display: none;" src="#" alt="Previsuialisation">
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

<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $('#preview').attr('style', 'display: block');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).ready(function() {
        $("#Image-produit").change(function(){
            readURL(this);
        });
    });
</script>  


<?php
include_once("../footer.php");
}

?>