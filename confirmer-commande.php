<?php
require_once("header.php");
require_once("front-office/Display.php");
require_once("modele/Magasin.php");
require_once("modele/Commande.php");


if (isset($_SESSION['membre']) === true) {
    // si le magasin et la commande sont renseigné
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
        // si le magasin n'est pas encore en session
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
        // si le quai et la date de retrait ne sont pas en session
        else {
            echo '
            <div class="container" id="main">
                <div class="row panier-table">
                    <h3>Selectionner un horaire pour le retrait</h3>
                    <small>Le retrait doit se faire au minimum le lendemain de la commande (nos magasins sont fermés le week-end)</small>
                    </br>
                    <small>Une commande ne peut se faire au maximum 5 jours avant son retrait</small>
                    </br>
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
// si l'utilisateur n'est pas membre
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