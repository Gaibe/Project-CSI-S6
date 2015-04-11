<?php

session_start();
if (isset($_SESSION["membre"]) === true) {
    session_destroy();
}

header("Location: ../");