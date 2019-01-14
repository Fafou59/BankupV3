<?php
    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }

    // Si identifiant bénéficiaire renseigné
    if (isset($_POST['id_Beneficiaire'])) {
        // Connexion à bdd
        include('support/connexion_bdd.php');

        // Requête suppression bénéficiaire
        $sql = "DELETE FROM beneficiaire WHERE beneficiaire.id_Beneficiaire = '".$_POST['id_Beneficiaire']."'";

        // Si requête réalisé
        if ($conn->query($sql) === TRUE) { 
            header('Location: espace_Client.php');
        // Si requête KO
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    $conn->close();
    // Si identifiant bénéficiaire absent
    } else {
        header('Location: espace_Client.php');
    }

?>