<?php
    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }

    // Générer des variables aléatoires pour le numéro de carte (16 chiffres) et le cryptogramme (4 chiffres)
    $num_Cb = trim(rand(10000000,99999999)).trim(rand(10000000,99999999));
    $cryptogramme = rand(100,999);

    // Connexion à bdd
    include('support/connexion_bdd.php');

    // Réaliser requête ajout de carte
    $sql = "INSERT INTO cb (id_Compte_Rattache, num_Cb, cryptogramme_Cb, date_Expiration_Cb)
    VALUES ('".$_POST['id_Compte']."', '".$num_Cb."', '".$cryptogramme."', DATE_ADD(NOW(),INTERVAL 5 YEAR))";
    if ($conn->query($sql) === TRUE) {
        header('Location: espace_Client.php');
    // Si requête KO
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>
