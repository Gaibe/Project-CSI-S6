<?php
require_once("header.php");
require_once("front-office/Display.php");
require_once("modele/Magasin.php");
require_once("modele/Commande.php");


if (isset($_SESSION['membre']) === true) {
    if (isset($_SESSION['magasin']) === true && isset($_SESSION["quai"]) === true && isset($_SESSION["date_retrait"]) === true) {
        echo '
        <div class="container" id="main">
            <div class="row">
        ';
        $magasin = Magasin::findById($_SESSION['magasin']);
        Display::displayConfirmation($magasin);
        echo '
            </div>
        </div>
        ';
    }
    else {
        if (isset($_SESSION['magasin']) === false) {
            $list_magasin = Magasin::findAll();

            echo '
            <div class="container" id="main">
                <div class="row">
            ';
            Display::displayMagasin($list_magasin);
            echo '
                    <div id="empty-div-magasin">
                    </div>
                </div>
            </div>
            ';
            echo '<script> alert("Veuillez selectionner un magasin pour continuer"); </script>';
        }
        else {
            echo '
            <div class="container" id="main">
                <div class="row">
                    <h3>Selectionner un horaire cette semaine</h3>
            ';
            Display::displayCreneau($_SESSION['magasin']);
            echo '
                <div id="empty-div-magasin">
                </div>
                </div>
            </div>
            ';
        }
    }
}
else {
    echo '<script> alert("Veuillez vous inscrire pour continuer"); </script>';
    header("refresh: 0;url=inscription/");
    exit;
}

?>
<script type="text/javascript">
    $(document).ready(function() {
        $('tr.table-magasin').click(function() {
            ajouterMagasin(this);
        });
    });
</script>

<?php

require_once("footer.php");