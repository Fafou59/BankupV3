<?php
    // Ajout du menu
    include('support/menu.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }
?>


<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Création bénéficiaire</title>
    </head>

    <body>
        <div class="item_EC" style="display: block">
            <?php
                // Vérifier si données disponibles
                if (isset($_POST['libelle_Beneficiaire'], $_POST['iban'], $_SESSION['id'])) {

                    // Réaliser requête compte bénéficiaire à création
                    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_POST['iban']."' = compte.iban_Compte");
                    $requete->execute();
                    $resultat = $requete->get_result();
                    $compte = $resultat->fetch_assoc();

                    // Si compte bénéficiaire trouvé
                    if (isset($compte)) {
                        // Si compte trouvé appartenant au client
                        if ($compte['id_Detenteur_Compte']==$_SESSION['id']) {?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Vous ne pouvez pas enregistré un de vos comptes en bénéficiaire.</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p> <?php
                        //Si compte appartient à autre client
                        } else {
                            // Vérifier si le bénéficiaire est déjà enregistré
                            $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire, compte WHERE '".$_SESSION['id']."' = beneficiaire.id_Client_Emetteur AND '".$compte['id_Compte']."' = beneficiaire.id_Compte_Beneficiaire");
                            $requete->execute();
                            $resultat = $requete->get_result();
                            $beneficiaire = $resultat->fetch_assoc();
                            // Si déjà enregistré
                            if (($beneficiaire['id_Compte_Beneficiaire']==$compte['id_Compte']) AND ($beneficiaire['id_Client_Emetteur']==$_SESSION['id'])) { ?>
                                <!-- Redirection après 3 secondes -->
                                <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                                <table>
                                    <tr>
                                        <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                        <td><h1 style="font-variant: small-caps;">Ce bénéficiaire est déjà enregistré.</h1></td>	
                                    </tr>
                                </table>
                                <hr>
                                <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p> <?php
                            // Si pas enregistré
                            } else {
                                // Réaliser requête pour ajout du bénéficiaire
                                $sql = "INSERT INTO beneficiaire (id_Compte_Beneficiaire, id_Client_Emetteur, libelle_Beneficiaire, validite_Beneficiaire)
                                VALUES ('".$compte['id_Compte']."', '".$_SESSION['id']."', '".$_POST['libelle_Beneficiaire']."', 0)";
                                if ($conn->query($sql) === TRUE) { ?>
                                    <!-- Redirection après 3 secondes -->
                                    <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                                    <table>
                                        <tr>
                                            <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                            <td><h1 style="font-variant: small-caps;">Le bénéficiaire a bien été enregistré. Il est en attente de validation.</h1></td>	
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
                        }
                    // Si compte bénéficiaire non trouvé
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Client.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">L'IBAN renseigné semble eronné. Veuillez réessayer.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p> <?php
                    }
                // Si données manquantes
                } else {
                    header('Location: espace_Client.php');
                }
            $conn->close();
            ?>
        </div>
    </body>
</html>
