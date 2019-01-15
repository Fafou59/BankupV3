<?php
    if (isset($_SESSION['admin_Id'])) {
      header('Location: espace_Admin.php');
    } else {
      header('Location: connexion_Admin.php');
    }
?>