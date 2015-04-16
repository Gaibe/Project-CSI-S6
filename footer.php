

    
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
        
        function refreshPanier() {
            var montant = '. $montant . ';
            var quantite = ' . $quantite . ';
            var montant_actuel = $("#panier-montant").html();
            var quantite_actuel = $("#panier-quantite").html();
            montant = montant + montant_actuel;
            quantite = quantite + quantite_actuel;
            $("#panier-montant").html(montant);
            $("#panier-quantite").html(quantite);
        }

        $(document).ready(function() {
            findActiveTab();
        });

    </script>
    
    </body>
</html>