

    
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
                url: 'ajout-magasin.php',
                type: 'POST',
                data: { id_magasin : id_magasin },
                success: function(result) {
                    $("#empty-div-magasin").html(result);
                }
            })
            .done(function() {
                alert("Magasin ajouté");
            });

        }

        $(document).ready(function() {
            findActiveTab();
        });

    </script>
    
    </body>
</html>