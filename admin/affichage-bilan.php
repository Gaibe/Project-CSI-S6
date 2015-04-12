<?php
session_start();
if (isset($_SESSION['admin']) === false) {
    header("Location: /$project_name/");
    exit;
}
else {
    include_once("$project_name/header.php");
?>



<?php
}
include_once("$project_name/footer.php")
?>