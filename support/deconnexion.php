<?php
    // Suppression des données de session et redirection vers accueil
    session_start();
    session_destroy();
    header("Location: ../index.php");
?>
    