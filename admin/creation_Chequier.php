<?php
    // Ajout du menu
    include('support/menu_Admin.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');
    
    // Vérifier si admin connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    // Vérifier si client en mirroring
    if (!isset($_SESSION['id_Client_Admin'])) {
        header("Location: espace_Admin.php");
    }

    // Vérification si identifiant compte renseigné
    if (!isset($_POST['id_Compte'])) {
        header('Location: mirroring_Admin.php');
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Création Chéquier</title>
    </head>

    <body>
        <div class="item" style="display: block"> 
            <?php
                // Recherche d'un chéquier rattaché au compte
                $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte']);
                $requete->execute();
                $resultat = $requete->get_result();
                $chequier = $resultat->fetch_assoc();

                // Si un chéquier existe déjà, archivage de l'existant et création du nouveau
                if (isset($chequier)) {
                    $sql1 = "UPDATE chequier SET validite_Chequier = 0 WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte'];
                    $sql2 = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier) VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
                    // Si requête réalisée
                    if ($conn->query($sql1) === TRUE AND $conn->query($sql2) === TRUE) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le chéquier a bien été créé et l'ancien archivé.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                    <?php
                    // Si requête KO
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                    <?php
                    }
                // Si pas de chéquier existant, création d'un nouveau
                } else {
                    $sql = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier) VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
                    // SI requête réalisée
                    if ($conn->query($sql) === TRUE) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le chéquier a bien été créé.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                        <?php
                    // Si requête KO
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                        <?php
                    } 
                }
                $conn->close();
            ?>
        </div>
    </body>
</html>