<?php
session_start();

require_once("base.php");
require_once("modele/Hydrator.php");
require_once("modele/Produit.php");
require_once("modele/Panier.php");

if (isset($_POST['id_produit']) === true) {


    $id_produit = $_POST['id_produit'];
    $quantite = $_POST['quantite'];

    $produit = Produit::findById($id_produit);
    $montant = $produit->__get("prix")*$quantite;


    if (isset($_SESSION['membre']) === true) {
        $panier = Panier::findByClientIdValide($_SESSION['membre']);
        $panier->addMontant($montant);
        $panier->addQuantite($quantite);
        $panier->ajouterProduit($produit->__get("id_produit"), $quantite, $produit->__get("prix"));
    }

    else {
        if (isset($_SESSION['panier'][$id_produit]) === true) {
            $_SESSION['panier'][$id_produit] += $quantite;
        }
        else {
            $_SESSION['panier'][$id_produit] = $quantite;
        }
        $_SESSION['panier-quantite'] += $quantite;
        $_SESSION['panier-prix'] += $montant;

    }

}
else {
    header("Location: ./");
}
?>


<script type="text/javascript">
    function refreshPanier() {
        var montant = '<?php echo $montant; ?>';
        var quantite = '<?php echo $quantite; ?>';
        var montant_actuel = $("#panier-prix").html();
        var quantite_actuel = $("#panier-quantite").html();
        montant = parseFloat(montant) + parseFloat(montant_actuel);
        quantite = parseInt(quantite) + parseInt(quantite_actuel);
        $("#panier-prix").html(parseFloat(montant).toFixed(2));
        $("#panier-quantite").html(quantite);
    }

    $(document).ready(function() {
        refreshPanier();
    });

</script>