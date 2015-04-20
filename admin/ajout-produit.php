<?php
include_once("../header.php");

if (isset($_SESSION['admin']) === false) {
    $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
    header("Location: /$project_name/");
    exit;
}
else {
    include_once("../modele/Categorie.php");
    include_once("../front-office/Formulaire.php");
    $list_categ = Categorie::findAll();
    
    Formulaire::ajoutProduit($list_categ);  
?>


<script type="text/javascript">
    function readURL(input) {    
        $('#preview')
            .attr('src', input.value)
            .attr('style', 'display: block');

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