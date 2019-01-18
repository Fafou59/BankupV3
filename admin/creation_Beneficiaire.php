<?php
    // Ajout du menu admin
    include('support/menu_Admin.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Vérification si admin connecté
    if (!isset($_SESSION['admin_Id'])) {
        header('Location : connexion_Admin.php');
    }

    // Vérification si identifiant client
    if (!isset($_SESSION['id_Client_Admin'])) {
        header("Location: espace_Admin.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Ajout bénéficiaire</title>
    </head>

    <body>
        <div class="item" style="display: block">
            <?php
                // Si données renseignées
                if (isset($_POST['libelle_Beneficiaire'], $_POST['iban'])) {
                    // Requête compte correspondant à l'iban renseigné
                    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_POST['iban']."' = compte.iban_Compte");
                    $requete->execute();
                    $resultat = $requete->get_result();
                    $compte = $resultat->fetch_assoc();

                    // Si un compte a été trouvé
                    if (isset($compte)) {
                        // Vérification si le compte appartient au client
                        if ($compte['id_Detenteur_Compte']==$_SESSION['id_Client_Admin']) { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                                <table>
                                    <tr>
                                        <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                        <td><h1 style="font-variant: small-caps;">Vous ne pouvez pas ajouter un compte du client comme bénéficiaire.</h1></td>	
                                    </tr>
                                </table>
                                <hr>
                                <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                            <?php
                        // S'il n'appartient pas au client, vérification si bénéficiaire déjà enregistré
                        } else {
                            $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire, compte WHERE '".$_SESSION['id_Client_Admin']."' = beneficiaire.id_Client_Emetteur AND '".$compte['id_Compte']."' = beneficiaire.id_Compte_Beneficiaire");
                            $requete->execute();
                            $resultat = $requete->get_result();
                            $beneficiaire = $resultat->fetch_assoc();
                            // Si bénéficiaire déjà enregistré
                            if (($beneficiaire['id_Compte_Beneficiaire']==$compte['id_Compte']) AND ($beneficiaire['id_Client_Emetteur']==$_SESSION['id_Client_Admin'])) { ?>
                                <!-- Redirection après 3 secondes -->
                                <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                                    <table>
                                        <tr>
                                            <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                            <td><h1 style="font-variant: small-caps;">Ce bénéficiaire est déjà enregistré.</h1></td>	
                                        </tr>
                                    </table>
                                    <hr>
                                    <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                                <?php
                            // Si nouveau bénéficiaire, création du bénéficiaire
                            } else {    
                                // Réaliser requête pour ajout du bénéficiaire
                                $sql = "INSERT INTO beneficiaire (id_Compte_Beneficiaire, id_Client_Emetteur, libelle_Beneficiaire, validite_Beneficiaire)
                                VALUES ('".$compte['id_Compte']."', '".$_SESSION['id_Client_Admin']."', '".$_POST['libelle_Beneficiaire']."', 1)";
                                // Si requête effectuée
                                if ($conn->query($sql) === TRUE) {?>
                                    <!-- Redirection après 3 secondes -->
                                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                                    <table>
                                        <tr>
                                            <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                            <td><h1 style="font-variant: small-caps;">Le bénéficiaire a bien été créé et validé.</h1></td>	
                                        </tr>
                                    </table>
                                    <hr>
                                    <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p><?php
                                // Si requête KO
                                } else { ?>
                                    <!-- Redirection après 3 secondes -->
                                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
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
                    // Si aucun compte ne correspond à l'iban renseigné
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">L'IBAN est incorrect ! Veuillez réessayer.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                        <?php
                    }
            // Si les données ne sont pas renseignées
            } else {
                header('Location: espace_Client.php');
            }
        $conn->close();
        ?>
    </div>
</body>
</html>