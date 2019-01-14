<?php
    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }
    // COnnexion à la bdd
    include('support/connexion_bdd.php');

    // Recherche d'un chéquier déjà existant
    $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte']);
    $requete->execute();
    $resultat = $requete->get_result();
    $chequier = $resultat->fetch_assoc();

    // Si chéquier déjà existant, désactivation de l'ancien et ajout du nouveau
    if (isset($chequier)) {
        $sql1 = "UPDATE chequier SET validite_Chequier = 0 WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte'];
        $sql2 = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier) VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
        if ($conn->query($sql1) === TRUE AND ($conn->query($sql2) === TRUE)) {
            header('Location: espace_Client.php');
        } else {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    // Si pas de chéquier existant, ajout du nouveau
    } else {
        $sql = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier)VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
        if ($conn->query($sql) === TRUE) {
            header('Location: espace_Client.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


?>
