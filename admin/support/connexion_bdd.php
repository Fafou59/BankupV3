<?php
    // Définition des paramètres de connexion à la bdd
    $serveur_bdd = "localhost";
    $utilisateur_bdd = "root";
    $mdp_bdd = "";
    $nom_bdd = "bankup";

    // Se connecter à la bdd
    $conn = new mysqli($serveur_bdd, $utilisateur_bdd, $mdp_bdd, $nom_bdd);
    // Vérifier que la connexion est ok
    if ($conn->connect_error) {
        die("Echec de la connexion : " . $conn->connect_error);
    }
?>