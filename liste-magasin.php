<?php
require_once("header.php");
require_once("front-office/Display.php");
require_once("modele/Magasin.php");

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