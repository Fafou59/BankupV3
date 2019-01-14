<?php
    // Ajout du menu
    include('support/menu.php');

    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Informations modifiées</title>
    </head>

    <body>
        <?php
            // Si données non renseignées, renvoie sur espace client
            if ((!isset($_POST['telephone'])) OR (!isset($_POST['email']))) {
                header('Location: espace_Client.php');
            // Si données renseignées
            } else {
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];

                // Connexion à la bdd
                include('support/connexion_bdd.php');

                //Requête de modification du client
                $sql = "UPDATE client SET adresse_Mail_Client = '".$_POST['email']."', telephone_Client = '".$_POST['telephone']."' WHERE client.id_Client = '".$_SESSION['id']."'";

                // Si requête effectuée
                if ($conn->query($sql) === TRUE) { ?>
                    <div class="container">
                        <h1>Votre profil a bien été modifié.</h1>
                        <button type="button" class="bouton_Annuler" onclick="location.href='espace_Client.php'">Aller sur Espace Client</button>
                    </div> <?php
                // Si requête KO
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            $conn->close();
            }
        ?>
    </body>

</html>





