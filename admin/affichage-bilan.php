<?php
session_start();

if (isset($_SESSION['admin']) === false) {
    $project_name = explode("/", $_SERVER["PHP_SELF"])[1];
    header("Location: /$project_name/");
    exit;
}
else {
    include_once("../header.php");
    
?>



<?php
include_once("../footer.php");
}

?>