<?php

require_once 'Authentication.php';

if (isset($_POST['Pseudo']) === true && isset($_POST['Password'])) { 

    Authentication::authenticate($_POST['Pseudo'], $_POST['Password']);
}

header('Location: ../');
exit;
