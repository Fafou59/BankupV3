<?php
    // Ajout du menu
    include('support/menu.php');

    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Recherche d'un client avec la même adresse mail
    if (isset($_POST['email'])) {
        // Réaliser requête client & agence rattaché à l'id client
        $requete = $conn->prepare("SELECT client.adresse_Mail_Client FROM client WHERE client.adresse_Mail_Client = '".$_POST['email']."'");
        $requete->execute();
        $resultat = $requete->get_result();
        $client = $resultat->fetch_assoc();
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Informations modifiées</title>
    </head>

    <body>
        <div class="item" style="display: block">
            <?php
                // Si données non renseignées, renvoie sur espace client
                if (!isset($_POST['telephone'], $_POST['email'])) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                    <div class="container">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Il manque des informations... Veuillez réessayer !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <h2>Vous allez être redirigé vers l'espace client.</h2>
                    </div> <?php
                // Si données renseignées
                } else {
                    // Si un autre client a déjà cette adresse mail
                    if (isset($client)) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Un profil avec la même adresse mail existe déjà !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p> <?php
                    // Si l'adresse n'est pas déjà utilisée
                    } else {
                        $email = $_POST['email'];
                        $telephone = $_POST['telephone'];

                        // Connexion à la bdd
                        include('support/connexion_bdd.php');

                        //Requête de modification du client
                        $sql = "UPDATE client SET adresse_Mail_Client = '".$_POST['email']."', telephone_Client = '".$_POST['telephone']."' WHERE client.id_Client = '".$_SESSION['id']."'";

                        // Si requête effectuée
                        if ($conn->query($sql) === TRUE) { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Votre profil a bien été modifié.</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p><?php
                        // Si requête KO
                        } else { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'inscription.</p> <?php
                        }
                    }
                $conn->close();
                }
            ?>
        </div>
    </body>

</html>





