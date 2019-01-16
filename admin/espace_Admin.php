<?php
    include('support/menu_Admin.php');

    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    include('support/connexion_bdd.php');

    // Réaliser requête client
    $requete = $conn->prepare("SELECT client.* FROM client WHERE client.agence_Client = '".$_SESSION['admin_Agence']."' ORDER BY client.id_Client ASC");
    $requete->execute();
    $clients = $requete->get_result();

    // Réaliser requête bénéficiaires
    $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire WHERE beneficiaire.validite_Beneficiaire = 0 AND beneficiaire.id_Client_Emetteur IN (SELECT client.id_Client FROM client WHERE client.agence_Client = '".$_SESSION['admin_Agence']."')");
    $requete->execute();
    $beneficiaires = $requete->get_result();

    // Réaliser requête chèques
    $requete = $conn->prepare("SELECT operation.*, chequier.* FROM operation, chequier WHERE operation.validite_Operation = 0 AND operation.id_Chequier_Operation = chequier.id_Chequier AND chequier.id_Chequier IN (SELECT chequier.id_Chequier FROM chequier, client, compte WHERE client.agence_Client = '".$_SESSION['admin_Agence']."' AND client.id_Client = compte.id_Detenteur_Compte AND chequier.id_Compte_Rattache = compte.id_Compte)");
    $requete->execute();
    $cheques = $requete->get_result();



?>

<!DOCTYPE HTML>
<html>
    <head>
        <script type="text/javascript" src="support/menu_EC.jsx"></script>
        <title>ADMIN BankUP - Espace Admin</title>
    </head>


    <body>
        <div id="contenu">
            <button class="lienEC" onclick="ouvrir_onglet('clients', this, '#E80969')" id="defaultOpen">Liste des clients</button>
            <button class="lienEC" onclick="ouvrir_onglet('beneficiaires', this, '#E80969')" >Bénéficiaires à valider</button>
            <button class="lienEC" onclick="ouvrir_onglet('cheques', this, '#E80969')">Chèques à valider</button>
            <button class="lienEC" onclick="ouvrir_onglet('autorisations', this, '#E80969')">Autorisations découvert</button>
        </div>

        <div id="clients" class="item_EC">
            <h1 style="font-variant: small-caps;">clients de votre agence</h1>
            <p style="font-size: 15px; margin-top: 15px;margin-bottom: 15px;">Vous pouvez consulter la liste des clients de votre agence et accéder à leur espace client. Vous pouvez également créer un nouveau client.</p>
            <hr>
            <button type="submit" class="bouton_Ouvrir" onclick="location.href='inscription_Admin.php'"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">Créer un client</button><br><br><br>
            <br>
            <hr>
            <table id='liste_Operations' width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
                <tr>
                    <th style="width:5%">N°</th>
                    <th style="width:25%">Prénom</th>
                    <th style="width:25%">Nom</th>
                    <th style="width:35%">Adresse mail</th>
                    <th style="width:10%"></th>
                </tr>
                <?php 
                $i = 1;
                while($client = $clients->fetch_row()) { ?>
                    <tr>
                        <td><?php echo($i)?></td>
                        <td><?php echo($client[3])?></td>
                        <td><?php echo($client[2])?></td>
                        <td><?php echo($client[6])?></td>
                        <td><form method="post" action="mirroring_Admin.php">
                            <button name="id_Client" type="submit" class="bouton_Profil" value="<?php echo ($client[0]) ?>">Profil</button>
                        </form></td>
                    </tr>
                    <?php
                    $i = $i + 1;
                } ?>
            </table>
        </div>

        <div id="beneficiaires" class="item_EC">
            <h1 style="font-variant: small-caps;">bénéficiaires à valider</h1>
            <p style="font-size: 15px; margin-top: 15px;margin-bottom: 15px;">Vous pouvez consulter la liste demandes d'ajout de bénéficiaire en attente de validation. Vous pouvez accepter une demande ou la supprimer.</p>
            <hr>
            <table id='liste_Operations' width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
                <tr>
                    <th style="width:20%">Client demandeur</th>
                    <th style="width:40%">Compte bénéficiaire (IBAN)</th>
                    <th style="width:20%">Détenteur compte</th>
                    <th style="width:10%"></th>
                    <th style="width:10%"></th>
                </tr>
                <?php
                while($beneficiaire = $beneficiaires->fetch_row()) { ?>
                    <tr>
                        <td><?php
                            $requete = $conn->prepare("SELECT client.prenom_Client, client.nom_Client FROM client WHERE client.id_Client = ".$beneficiaire[2]);
                            $requete->execute();
                            $resultat = $requete->get_result();
                            $emetteur_detail = $resultat->fetch_assoc();
                            echo($emetteur_detail['prenom_Client'].' '.$emetteur_detail['nom_Client']); ?>
                        </td>
                        <td><?php 
                            $requete = $conn->prepare("SELECT compte.libelle_Compte, compte.iban_Compte, client.prenom_Client, client.nom_Client FROM compte, client WHERE compte.id_Compte = ".$beneficiaire[1]." AND compte.id_Detenteur_Compte = client.id_Client");
                            $requete->execute();
                            $resultat = $requete->get_result();
                            $beneficiaire_detail = $resultat->fetch_assoc();
                            echo($beneficiaire_detail['libelle_Compte'].' ('.$beneficiaire_detail['iban_Compte']."')"); ?>
                        </td>
                        <td><?php
                            echo($beneficiaire_detail['prenom_Client'].' '.$beneficiaire_detail['nom_Client']); ?>
                        </td>
                        <td><form method="post" action="validation_Beneficiaire.php">
                            <button name="id_Beneficiaire_Ajout" type="submit" class="bouton_Ajout" value="<?php echo ($beneficiaire[0]) ?>">Valider</button>
                        </form></td>
                        <td><form method="post" action="validation_Beneficiaire.php">
                            <button name="id_Beneficiaire_Suppression" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>">Supprimer</button>
                        </form></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div id="cheques" class="item_EC">
            <h1 style="font-variant: small-caps;">chèques à valider</h1>
            <p style="font-size: 15px">Vous pouvez consulter la liste des chèques en attente de validation. Vous pouvez valider un chèque ou le supprimer.</p>
            <hr>
            <table id='liste_Operations' width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
                <tr>
                    <th style="width:20%">Client émetteur</th>
                    <th style="width:34%">Compte bénéficiaire (IBAN)</th>
                    <th style="width:20%">Détenteur compte</th>
                    <th style="width:10%">Montant</th>
                    <th style="width:8%"></th>
                    <th style="width:8%"></th>
                </tr>
                <?php
                while($cheque = $cheques->fetch_row()) { ?>
                    <tr>
                        <td><?php
                            $requete = $conn->prepare("SELECT client.prenom_Client, client. nom_Client FROM client, compte WHERE client.id_Client = compte.id_Detenteur_Compte AND compte.id_Compte = ".$cheque[2]);
                            $requete->execute();
                            $resultat = $requete->get_result();
                            $emetteur_detail = $resultat->fetch_assoc();
                            echo($emetteur_detail['prenom_Client'].' '.$emetteur_detail['nom_Client']); ?>
                        </td>
                        <td><?php 
                            $requete = $conn->prepare("SELECT compte.libelle_Compte, compte.iban_Compte, client.prenom_Client, client.nom_Client FROM compte, client WHERE compte.id_Compte = ".$cheque[3]." AND compte.id_Detenteur_Compte = client.id_Client");
                            $requete->execute();
                            $resultat = $requete->get_result();
                            $beneficiaire_detail = $resultat->fetch_assoc();
                            echo($beneficiaire_detail['libelle_Compte'].' ('.$beneficiaire_detail['iban_Compte']."')"); ?>
                        </td>
                        <td><?php
                            echo($beneficiaire_detail['prenom_Client'].' '.$beneficiaire_detail['nom_Client']); ?>
                        </td>
                        <td><?php
                            echo($cheque[5].'€');?>
                        </td>
                        <td><form method="post" action="cheque.php">
                            <button name="id_Cheque_Ajout" type="submit" class="bouton_Ajout" value="<?php echo ($cheque[0]) ?>">Valider</button>
                        </form></td>
                        <td><form method="post" action="cheque.php">
                            <button name="id_Cheque_Suppression" type="submit" class="bouton_Suppression" value="<?php echo ($cheque[0]) ?>">Supprimer</button>
                        </form></td>                            
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div id="autorisations" class="item_EC">
            <h1>Autorisations de découvert</h1>
            <p>Vous pouvez paramétrer les autorisations de découvert des comptes des clients de votre agence.</p>
            <hr>
            
        </div>
    </body>

    <script>
        document.getElementById("defaultOpen").click();
    </script>

</html>