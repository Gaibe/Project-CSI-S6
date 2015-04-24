<?php
require_once("../header.php");
require_once("../front-office/Display.php");

if (isset($_SESSION['membre']) == true) {
    $client = Client::findById($_SESSION['membre']);
echo '
<div class="container" id="main">
    <div class="row">
';
    Display::displayHistoriqueCommande($client);
    echo '
    </div>
</div>
';
}
else {
    header("Location: ../");
    exit;
}

require_once("../footer.php");