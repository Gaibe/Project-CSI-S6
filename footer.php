

    
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

        $(document).ready(function() {
            findActiveTab();
        });

    </script>
    
    </body>
</html>