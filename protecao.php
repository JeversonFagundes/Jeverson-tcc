<?php

if (!isset($_SESSION)) {
    session_start();
}

session_regenerate_id(true);

?>

