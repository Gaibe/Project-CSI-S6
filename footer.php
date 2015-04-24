

    
    <script type="text/javascript">
        function findActiveTab() {
            var full_path = window.location.pathname;

            $("#navbar-ul li").each(function() {
                var path_li = $(this).children('a').attr('href');
                if (path_li == full_path) {
                    $(this).attr("class", "active");
                }
            });
        }

        function ajouterMagasin(button) {
            var id_magasin = $(button).attr("id").substring(11);
            $.ajax({
                url: '/<?php echo $project_name; ?>/ajout-magasin.php',
                type: 'POST',
                data: { id_magasin : id_magasin },
                success: function(result) {
                    $("#empty-div-magasin").html(result);
                }
            })
            .done(function() {
                alert("Magasin ajouté");
                location.reload();
            });

        }

        function ajouterProduitPanier(button) {
            var id = $(button).attr("id");
            var id_modal = id.substring(0, 5);
            if (id_modal == "modal") {
                var id_produit = id.substring(12);
                var quantite = $("#modal-qte-"+id_produit).val();
            }
            else {
                var id_produit = id.substring(6);
                var quantite = $("#qte-"+id_produit).val();
            }

            if (quantite <= 0 || quantite == null) {
                quantite = 0;
                alert("Aucun produit à ajouté");
            }
            else {
                $.ajax({
                    url: "/<?php echo $project_name; ?>/panier/ajout-produit-panier.php",
                    type: "POST",
                    data: { id_produit : id_produit, quantite : quantite },
                    dataType: "html",
                    success: function(result) {
                        $("#empty-div").html(result);
                    }
                })
                .done(function() {
                    alert("Produit ajouté");
                });
            }
        }

        $(document).ready(function() {
            findActiveTab();
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>
    
    </body>
</html>