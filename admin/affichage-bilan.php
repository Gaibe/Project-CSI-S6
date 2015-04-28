<?php
include_once("../header.php");
include_once("../modele/Bilan.php");


if (isset($_SESSION['membre']) === false && isset($_SESSION['admin']) === false) {
    $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
    header("Location: /$project_name/");
    exit;
}
else {


echo '
<div class="container" id="main">
    <div class="row">
    
    </br>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

';
    $list_bilan = Bilan::findAll();

    if ($list_bilan == null) {
        echo '
        <h4>Aucun bilan</h4>
        ';
    }
    else {
        foreach ($list_bilan as $bilan) {
            $bilan = Hydrator::hydrate($bilan, new Bilan());
            Display::displayBilan($bilan);
        }
    }
    echo '
    </div>
    <noscript>Activer Javascript pour un rendu optimal</noscript>
    </div>
</div>
';





include_once("../footer.php");
}

?>