<?php
    // Connexion à la bdd
    include('../support/connexion_bdd.php');

    // Requête de toutes les CB, avec leur compte rattaché et le client détenteur
    $requete = $conn->prepare("SELECT compte.id_Compte, compte.libelle_Compte, compte.iban_Compte, compte.solde_Compte, cb.id_Cb, client.id_Client, client.nom_Client, client.prenom_Client FROM compte, cb, client WHERE client.id_Client = compte.id_Detenteur_Compte AND compte.id_Compte = cb.id_Compte_Rattache ORDER BY client.id_Client ASC");
    $requete->execute();
    $cbs = $requete->get_result();

    // Requête de tous les chéquiers, avec leur compte rattaché et le client détenteur
    $requete = $conn->prepare("SELECT compte.id_Compte, compte.libelle_Compte, compte.iban_Compte, compte.solde_Compte, chequier.id_Chequier, client.id_Client, client.nom_Client, client.prenom_Client FROM compte, chequier, client WHERE client.id_Client = compte.id_Detenteur_Compte AND compte.id_Compte = chequier.id_Compte_Rattache AND chequier.validite_Chequier = 1 ORDER BY client.id_Client ASC");
    $requete->execute();
    $chequiers = $requete->get_result();

    // Requête de tous les comptes et leur client détenteur 1
    $requete = $conn->prepare("SELECT compte.id_Compte, compte.libelle_Compte, compte.iban_Compte, client.id_Client, client.nom_Client, client.prenom_Client FROM compte, client WHERE client.id_Client = compte.id_Detenteur_Compte ORDER BY client.id_Client ASC");
    $requete->execute();
    $comptes = $requete->get_result();

    // Requête de tous les comptes et leur client détenteur 2
    $requete = $conn->prepare("SELECT compte.id_Compte, compte.libelle_Compte, compte.iban_Compte, client.id_Client, client.nom_Client, client.prenom_Client FROM compte, client WHERE client.id_Client = compte.id_Detenteur_Compte ORDER BY client.id_Client ASC");
    $requete->execute();
    $comptes2 = $requete->get_result();

?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Au cas où on ajoute du css, à supprimer sinon
        <link rel="stylesheet" type="text/css" href="code.css" /> -->
        <title>BankUP - GOD MODE</title>
    </head>

    <body>
        <?php
            // Si les données ne sont pas renseignées
            if (!isset($_POST["emetteur"], $_POST['recepteur'], $_POST['montant'], $_POST['type_Operation'])) { ?>
                <h1>Console de simulation d'opérations</h1>
                <hr>
                <!-- Formulaire de création d'un opération par CB -->
                <form class="formulaire" method="post" action="godmode.php">
                    <div class="container">
                        <h3>Faire une opération par CB</h3>
                        <p>Merci de compléter les informations ci-dessous pour réaliser votre opération par CB.</p>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="emetteur">Sélectionnez le compte à débiter :</label></td>
                                <td><select name="emetteur" id="pays" required>
                                    <?php
                                        // Liste toutes les CB avec détails du comtpe et du détenteur
                                        echo("<optgroup label='Cartes bancaires'>");
                                        while($cb = $cbs->fetch_row())
                                        {
                                            echo('<option value='.$cb[4].'>Client : '.$cb[7].' '.$cb[6].' / Compte : '.$cb[1].' ('.$cb[2].') / Solde : '.$cb[3].'€</option>');
                                        }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="recepteur">Sélectionnez le compte à créditer :</label></td>
                                <td>
                                    <select name="recepteur" id="pays" required>
                                    <?php
                                        // Liste tous les comptes
                                        while($compte = $comptes->fetch_row())
                                        {
                                            echo('<option value='.$compte[0].'>Client : '.$compte[5].' '.$compte[4].' / Compte : '.$compte[1].' ('.$compte[2].')</option>');
                                        }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="montant">Indiquez le montant de l'opération :</label></td>
                                <td><input name="montant" type="number" min="0" required>€</td>
                            </tr>
                        </table><br>
                        <div class="bouton_Form">
                            <button type="submit" name="type_Operation" value="CB" class="bouton_Ouvrir">Valider l'opération par CB</button>
                        </div>
                    </div>
                </form>
                <hr>

                <!-- Formulaire de création d'un opération par Chéquier -->
                <form class="formulaire" method="post" action="godmode.php">
                    <div class="container">
                        <h3>Faire une opération par chèque</h3>
                        <p>Merci de compléter les informations ci-dessous pour réaliser votre opération par chèque.</p>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="emetteur">Sélectionnez le compte à débiter :</label></td>
                                <td><select name="emetteur" id="pays" required>
                                    <?php
                                        // Liste tous les chèques avec détails du compte et du détenteur
                                        echo("</optgroup><optgroup label='Chéquiers'>");
                                        while($chequier = $chequiers->fetch_row())
                                        {
                                            echo('<option value='.$chequier[4].'>Client : '.$chequier[7].' '.$chequier[6].' / Compte : '.$chequier[1].' ('.$chequier[2].') / Solde : '.$chequier[3].'€</option>');
                                        }
                                        echo("</optgroup>");
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="recepteur">Sélectionnez le compte à créditer :</label></td>
                                <td>
                                    <select name="recepteur" id="pays" required>
                                    <?php
                                        // Liste tous les comptes
                                        while($compte2 = $comptes2->fetch_row())
                                        {
                                            echo('<option value='.$compte2[0].'>Client : '.$compte2[5].' '.$compte2[4].' / Compte : '.$compte2[1].' ('.$compte2[2].')</option>');
                                        }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="montant">Indiquez le montant de l'opération :</label></td>
                                <td><input name="montant" type="number" min="0" required>€</td>
                            </tr>
                        </table><br>
                        <div class="bouton_Form">
                            <button type="submit" name="type_Operation" value="Chequier" class="bouton_Ouvrir">Valider l'opération par chèque</button>
                        </div>
                    </div>
                </form>
                <hr>
            <!-- Données renseignées -->
            <?php } else {
                // Si chèque, opération à valider sur espace Admin
                if ($_POST['type_Operation'] == 'Chequier') {
                    // Requête pour obtenir les infos du compte rattaché au chéquier
                    $requete = $conn->prepare("SELECT compte.id_Compte, compte.solde_Compte, compte.autorisation_Decouvert_Compte FROM compte, chequier WHERE chequier.id_Chequier = ".$_POST['emetteur']." AND compte.id_Compte = chequier.id_Compte_Rattache");
                    $requete->execute();
                    $resultat = $requete->get_result();
                    $compte = $resultat->fetch_assoc();

                    // Si solde suffisant
                    if ($compte['solde_Compte'] - $_POST['montant'] >= $compte['autorisation_Decouvert_Compte']*-1) {
                        // Ajout de l'opération, mais pas d'opération sur les soldes des comptes (attente de validation)
                        $sql = "INSERT INTO operation (date_Operation, id_Emetteur_Operation, id_Recepteur_Operation, type_Operation, montant_Operation, id_Chequier_Operation, validite_Operation) VALUES (SYSDATE(), '".$compte['id_Compte']."', '".$_POST['recepteur']."', '".$_POST['type_Operation']."', '".$_POST['montant']."', '".$_POST['emetteur']."', 0)";
                        if ($conn->query($sql) === TRUE) { ?>
                            <meta http-equiv="Refresh" content="3;URL=godmode.php">
                            <h1>Opération par chèque réalisée avec succès !</h1>
                            <h3>L'opération sera effective après validation du chèque.</h3>
                        <?php } else {
                            echo('<meta http-equiv="Refresh" content="3;URL=godmode.php">');
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    // Si solde insuffisant
                    } else { ?>
                        <meta http-equiv="Refresh" content="3;URL=godmode.php">
                        <h1>Solde insuffisant...</h1>
                    <?php }
                // Si CB, opération directement validée et soldes des comptes mis à jour
                } else {
                if ($_POST['type_Operation'] == 'CB') {
                    // Requête pour obtenir les infos du compte rattaché à la CB
                    $requete = $conn->prepare("SELECT compte.id_Compte, compte.solde_Compte, compte.autorisation_Decouvert_Compte FROM compte, cb WHERE cb.id_Cb = ".$_POST['emetteur']." AND compte.id_Compte = cb.id_Compte_Rattache");
                    $requete->execute();
                    $resultat = $requete->get_result();
                    $compte = $resultat->fetch_assoc();
                    // Si solde suffisant pour effectuer le virement
                    if ($compte['solde_Compte'] - $_POST['montant'] >= $compte['autorisation_Decouvert_Compte']*-1) {
                        // Requêtes pour mettre à jour les soldes et l'opération
                        $sql0 = "UPDATE compte SET solde_Compte = solde_Compte - '".$_POST['montant']."' WHERE compte.id_Compte = '".$compte['id_Compte']."'";
                        $sql1 = "UPDATE compte SET solde_Compte = solde_Compte + '".$_POST['montant']."' WHERE compte.id_Compte = '".$_POST['recepteur']."'";
                        $sql2 = "INSERT INTO operation (date_Operation, id_Emetteur_Operation, id_Recepteur_Operation, type_Operation, montant_Operation, id_CB_Operation, validite_Operation) VALUES (SYSDATE(), '".$compte['id_Compte']."', '".$_POST['recepteur']."', '".$_POST['type_Operation']."', '".$_POST['montant']."', '".$_POST['emetteur']."', 1)";    
                        if ($conn->query($sql0) === TRUE AND $conn->query($sql1) === TRUE AND $conn->query($sql2)) { ?>
                            <meta http-equiv="Refresh" content="3;URL=godmode.php">
                            <h1>Opération par CB réalisée avec succès !</h1>
                        <?php } else {
                            echo('<meta http-equiv="Refresh" content="3;URL=godmode.php">');
                            echo "Error: " . $sql0 . "<br>" . $conn->error;
                            echo "Error: " . $sql1 . "<br>" . $conn->error;
                            echo "Error: " . $sql2 . "<br>" . $conn->error;
                        }
                    // Si solde insuffisant 
                    } else { ?>
                        <meta http-equiv="Refresh" content="3;URL=godmode.php">
                        <h1>Solde insuffisant...</h1>
                    <?php }
                }
                }
            $conn->close();
            }
        ?>
        
    </body>
</html>
