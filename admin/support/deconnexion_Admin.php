<?php
    // Suppression des données de session et redirection vers connexion
    session_start();
    session_destroy();
    header("Location: ../connexion_Admin.php");
?>
    