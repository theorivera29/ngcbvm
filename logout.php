<?php 
    session_start();
    session_unset();
    session_destroy();
    header('Location: http://www.ngcbdcinventorysystem.com/index.php');
?>