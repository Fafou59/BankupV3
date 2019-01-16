<?php
    // Ajout du menu admin
    include('support/menu.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }

    // Vérification si donnée disponible
    if (!isset($_POST['id_Compte'])) {
        header("Location: espace_Client.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Création Chéquier</title>
    </head>

    <body>
        <div class="item_EC" style="display: block">
            <?php
                // Recherche d'un chéquier déjà existant
                $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte']);
                $requete->execute();
                $resultat = $requete->get_result();
                $chequier = $resultat->fetch_assoc();

                // Si chéquier déjà existant, désactivation de l'ancien et ajout du nouveau
                if (isset($chequier)) {
                    $sql1 = "UPDATE chequier SET validite_Chequier = 0 WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte'];
                    $sql2 = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier) VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
                    // Si requête réalisée
                    if ($conn->query($sql1) === TRUE AND ($conn->query($sql2) === TRUE)) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le chéquier a bien été créé et l'ancien archivé.</h1></td>	
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
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                        <?php
                    }
                // Si pas de chéquier existant, ajout du nouveau
                } else {
                    $sql = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier) VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
                    // Si requête réalisée
                    if ($conn->query($sql) === TRUE) {?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le chéquier a bien été créé.</h1></td>	
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
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p> <?php
                    }
                }
                $conn->close();
            ?>
        </div>
    </body>
</html>