

    
    <script type="text/javascript">
        $(document).ready(function() {
            var full_path = window.location.pathname;

            $("#navbar-ul li").each(function() {
                var path_li = $(this).children('a').attr('href');
                console.log(path_li);
                console.log(this);
                if (path_li == full_path) {
                    $(this).attr("class", "active");
                }
            });
        });

    </script>
    
    </body>
</html>