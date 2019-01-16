<?php
    // Pas d'accueil sur site admin
    // Si admin connecté, renvoie vers espace admin
    if (isset($_SESSION['admin_Id'])) {
      header('Location: espace_Admin.php');
    // Si non, renvoie vers connexion admin
    } else {
      header('Location: connexion_Admin.php');
    }
?>