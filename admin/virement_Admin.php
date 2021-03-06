<?php
    // Ajout du menu
    include('support/menu_Admin.php');

    // Vérifier si admin connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    // Vérifier si client en mirroring
    if (!isset($_SESSION['id_Client_Admin'])) {
        header("Location: espace_Admin.php");
    }
    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Requête comptes du client pour débit
    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE  compte.id_Detenteur_Compte = '".$_SESSION['id_Client_Admin']."'");
    $requete->execute();
    $comptes = $requete->get_result();

    // Requête comptes du client pour crédit
    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE  compte.id_Detenteur_Compte = '".$_SESSION['id_Client_Admin']."'");
    $requete->execute();
    $comptes2 = $requete->get_result();
    
    // Requête comptes bénéficiaires pour crédit
    $requete = $conn->prepare("SELECT beneficiaire.*, compte.* FROM beneficiaire, compte WHERE beneficiaire.id_Compte_Beneficiaire = compte.id_Compte AND beneficiaire.id_Client_Emetteur = '".$_SESSION['id_Client_Admin']."' AND beneficiaire.validite_Beneficiaire = 1");
    $requete->execute();
    $beneficiaires = $requete->get_result();

    // Si le virement a été initié par la liste des bénéficiaires, paramétrage auto du compte créditeur
    if (isset($_POST['id_Beneficiaire'])) {
        $id_Beneficiaire = $_POST['id_Beneficiaire'];
    } else {
        $id_Beneficiaire = 0;
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Virement</title>
    </head>

    <body>
        <div class="item" style="display: block; margin-top:60px;">
            <?php
                // Si données non renseignées
                if ((!isset($_POST["emetteur"], $_POST['recepteur'], $_POST['montant']))) { ?>
                    <form class="formulaire" style="width:100%; margin:0px 0px 0px 0px; margin-bottom:100px;" method="post" action="virement_Admin.php">
                        <h1>Faire un virement</h1>
                        <p>Merci de compléter les informations ci-dessous pour réaliser votre virement.</p>
                        <hr>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="emetteur">compte à débiter :</label></td>
                                <td><select class="info_Requise" name="emetteur" id="pays" required>
                                    <?php
                                    while($compte2 = $comptes2->fetch_row())
                                    {
                                        echo('<option value='.$compte2[0].'>'.$compte2[4].' - Solde : '.$compte2[3].'€</option>');
                                    } ?>
                                </select></td>
                            </tr>
                            <tr>
                                <td><label for="recepteur">bénéficiaire :</label></td>
                                <td><select class="info_Requise" name="recepteur" id="pays" required>
                                    <?php
                                    echo("<optgroup label='Comptes'>");
                                    while($compte = $comptes->fetch_row())
                                    {
                                        echo('<option value='.$compte[0].'>'.$compte[4].' - Solde : '.$compte[3].'€</option>');
                                    }
                                    echo("</optgroup><optgroup label='Bénéficiaires'>");
                                    while($beneficiaire = $beneficiaires->fetch_row())
                                    {
                                        if ($beneficiaire[0]==$id_Beneficiaire) { // Bénéficiaire sélectionné par défaut
                                            echo('<option value='.$beneficiaire[5].' selected="selected">'.$beneficiaire[3].' - IBAN : '.$beneficiaire[10].'</option>');
                                        } else {
                                            echo('<option value='.$beneficiaire[5].'>'.$beneficiaire[3].' - IBAN : '.$beneficiaire[10].'</option>');
                                        }
                                    }
                                    echo("</optgroup>");
                                    ?>
                                </select></td>
                            </tr>
                            <tr>
                                <td><label for="montant">montant :</label></td>
                                <td><input name="montant" class="info_Requise" type="number" min="0" max="99999" required>€</td>
                            </tr>
                        </table>
                        <div class="bouton_Form">
                            <button type="button" onclick="location.href='mirroring_Admin.php'" class="bouton_Ouvrir" Style="background-color:#555; margin-top: 50px; margin-left: 5px; float:right; width: 150px; margin-right:20px;" >Retour</button>
                            <button type="submit" class="bouton_Ouvrir" style="margin-top: 50px; margin-right: 5px; float:right; width: 150px;">Valider</button>
                        </div>
                    </form>
                    <?php
                // Si données renseignées
                } else { 
                    // Réaliser requête compte débiteur pour vérifier solde
                    $requete = $conn->prepare("SELECT compte.solde_Compte, compte.autorisation_Decouvert_Compte FROM compte WHERE compte.id_Compte = ".$_POST['emetteur']);
                    $requete->execute();
                    $resultat = $requete->get_result();
                    $solde = $resultat->fetch_assoc();

                    // Si solde suffisant pour effectuer le virement
                    if ($solde['solde_Compte'] - $_POST['montant'] >= $solde['autorisation_Decouvert_Compte']*-1) {
                        // Requête mise à jour solde compte débiteur
                        $sql0 = "UPDATE compte SET solde_Compte = solde_Compte - '".$_POST['montant']."' WHERE compte.id_Compte = '".$_POST['emetteur']."'";
                        // Requête mise à jour solde compte créditeur
                        $sql1 = "UPDATE compte SET solde_Compte = solde_Compte + '".$_POST['montant']."' WHERE compte.id_Compte = '".$_POST['recepteur']."'";
                        // Requête ajout opération
                        $sql2 = "INSERT INTO operation (date_Operation, id_Emetteur_Operation, id_Recepteur_Operation, type_Operation, montant_Operation, validite_Operation) VALUES (SYSDATE(), '".$_POST['emetteur']."', '".$_POST['recepteur']."', 'Virement', '".$_POST['montant']."', 1)";
                        // Si requêtes bien effectuées
                        if ($conn->query($sql0) === TRUE AND $conn->query($sql1) === TRUE AND $conn->query($sql2)) { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Le virement a bien été effectué.</h1></td>	
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
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Le solde de ce compte est insuffisant !</h1></td>	
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