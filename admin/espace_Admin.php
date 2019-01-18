<?php
    // Ajout du menu Admin
    include('support/menu_Admin.php');

    // Vérificaiton si admin connecté
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    // Vérificaiton si agence renseignée
    if (!isset($_SESSION['admin_Agence'])) {
        header("Location: connexion_Admin.php");
    }

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Réaliser requête liste des clients rattachés à l'agence
    $requete = $conn->prepare("SELECT client.* FROM client WHERE client.agence_Client = '".$_SESSION['admin_Agence']."' ORDER BY client.id_Client ASC");
    $requete->execute();
    $clients = $requete->get_result();

    // Réaliser requête liste des bénéficiaires à valider des clients de l'agence
    $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire WHERE beneficiaire.validite_Beneficiaire = 0 AND beneficiaire.id_Client_Emetteur IN (SELECT client.id_Client FROM client WHERE client.agence_Client = '".$_SESSION['admin_Agence']."')");
    $requete->execute();
    $beneficiaires = $requete->get_result();

    // Réaliser requête liste des chèques à valider des clients de l'agence
    $requete = $conn->prepare("SELECT operation.*, chequier.* FROM operation, chequier WHERE operation.validite_Operation = 0 AND operation.id_Chequier_Operation = chequier.id_Chequier AND chequier.id_Chequier IN (SELECT chequier.id_Chequier FROM chequier, client, compte WHERE client.agence_Client = '".$_SESSION['admin_Agence']."' AND client.id_Client = compte.id_Detenteur_Compte AND chequier.id_Compte_Rattache = compte.id_Compte)");
    $requete->execute();
    $cheques = $requete->get_result();

    // Réaliser requête liste des comptes des clients de l'agence
    $requete = $conn->prepare("SELECT compte.id_Compte, Compte.solde_Compte, compte.libelle_Compte, compte.iban_Compte, compte.autorisation_Decouvert_Compte, client.prenom_Client, client.nom_Client FROM compte, client WHERE client.agence_Client = '".$_SESSION['admin_Agence']."' AND client.id_Client = compte.id_Detenteur_Compte ORDER BY client.prenom_Client ASC");
    $requete->execute();
    $comptes = $requete->get_result();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <script type="text/javascript" src="support/menu_EC.jsx"></script>
        <script type="text/javascript" src="support/tri.jsx"></script>
        <title>ADMIN BankUP - Espace Admin</title>
    </head>


    <body>
        <!-- Menu de l'espace admin, affichage quand clic, clients ouvert par défaut -->
        <div id="contenu" style="width:100%">
            <div class="lienEC" style="width: 14%"> </div>
            <button class="lienEC" onclick="ouvrir_onglet('clients', this, '#f1f1f1')" style="width: 18%" id="defaultOpen">liste des clients</button>
            <button class="lienEC" onclick="ouvrir_onglet('beneficiaires', this, '#f1f1f1')" style="width: 18%" >bénéficiaires à valider</button>
            <button class="lienEC" onclick="ouvrir_onglet('cheques', this, '#f1f1f1')" style="width: 18%">chèques à valider</button>
            <button class="lienEC" onclick="ouvrir_onglet('autorisations', this, '#f1f1f1')" style="width: 18%">autorisations découvert</button>
            <div class="lienEC" style="width: 14%"> </div>
        </div>

        <!-- Liste des clients de l'agence -->
        <div id="clients" class="item">
            <h1 style="font-variant: small-caps;">clients de votre agence</h1>
            <p style="font-size: 15px">Vous pouvez consulter la liste des clients de votre agence et accéder à leur espace client. Vous pouvez également créer un nouveau client.</p>
            <hr>
            <button type="submit" class="bouton_Ouvrir" onclick="location.href='inscription_Admin.php'"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">Créer un client</button><br><br><br>
            <br>
            <hr>
            <table class="liste" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th style="width:7%; text-align:left">N°</th>
                    <th style="width:20%">Prénom</th>
                    <th style="width:20%">Nom</th>
                    <th style="width:38%">Adresse mail</th>
                    <th style="width:15%"></th>
                </tr>
                <?php 
                // Récupération de tous les clients
                $i = 1;
                while($client = $clients->fetch_row()) { ?>
                    <tr>
                        <td style="font-weight:bold"><?php echo($i)?></td>
                        <td><?php echo($client[3])?></td>
                        <td><?php echo($client[2])?></td>
                        <td><?php echo($client[6])?></td>
                        <td><form method="post" action="mirroring_Admin.php">
                            <button name="id_Client" type="submit" class="bouton_Profil" value="<?php echo ($client[0]) ?>"><img src="images/pencil.png" style="width:15px; margin-right:10px;">Profil</button>
                        </form></td>
                    </tr>
                    <?php
                    $i = $i + 1;
                } ?>
            </table>
        </div>

        <!-- Liste des bénéficiaires à valider pour les clients de l'agence -->
        <div id="beneficiaires" class="item">
            <h1 style="font-variant: small-caps;">bénéficiaires à valider</h1>
            <p style="font-size: 15px">Vous pouvez consulter la liste demandes d'ajout de bénéficiaire en attente de validation. Vous pouvez accepter une demande ou la supprimer.</p>
            <hr>
            <table class="liste" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th style="width:20%">Client demandeur</th>
                    <th style="width:50%">Compte bénéficiaire (IBAN)</th>
                    <th style="width:20%">Détenteur compte</th>
                    <th style="width:5%"></th>
                    <th style="width:5%"></th>
                </tr>
                <?php
                // Récupération de tous les bénéficiaires à valider
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
                        <td><form method="post" action="validation_Beneficiaire.php" style="height: 40px;">
                            <button name="id_Beneficiaire_Ajout" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>"><img src="images/bouton_Ok.png" style="width:25px; margin-right:20px;"></button>
                        </form></td>
                        <td><form method="post" action="validation_Beneficiaire.php" style="height: 40px;">
                            <button name="id_Beneficiaire_Suppression" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>"><img src="images/bouton_Ko.png" style="width:25px; margin-right:20px;"></button>
                        </form></td>  
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Liste des chèques à valider pour les clients de l'agence -->
        <div id="cheques" class="item">
            <h1 style="font-variant: small-caps;">chèques à valider</h1>
            <p style="font-size: 15px">Vous pouvez consulter la liste des chèques en attente de validation. Vous pouvez valider un chèque ou le supprimer.</p>
            <hr>
            <table class='liste' border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th style="width:19%">Client émetteur</th>
                    <th style="width:45%">Compte bénéficiaire (IBAN)</th>
                    <th style="width:19%">Détenteur compte</th>
                    <th style="width:7%">Montant</th>
                    <th style="width:5%"></th>
                    <th style="width:5%"></th>
                </tr>
                <?php
                // Récupération de tous les chèques à valider
                while($cheque = $cheques->fetch_row()) { ?>
                    <tr>
                        <td><?php
                            // Requête informations du client émetteur du chèque
                            $requete = $conn->prepare("SELECT client.prenom_Client, client. nom_Client FROM client, compte WHERE client.id_Client = compte.id_Detenteur_Compte AND compte.id_Compte = ".$cheque[2]);
                            $requete->execute();
                            $resultat = $requete->get_result();
                            $emetteur_detail = $resultat->fetch_assoc();
                            echo($emetteur_detail['prenom_Client'].' '.$emetteur_detail['nom_Client']); ?>
                        </td>
                        <td><?php 
                            // Requête informations du client récepteur du chèque et de son compte bénéficiaire
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
                        <td><form method="post" action="cheque.php" style="height: 40px;">
                            <button name="id_Cheque_Ajout" type="submit" class="bouton_Suppression" value="<?php echo ($cheque[0]) ?>"><img src="images/bouton_Ok.png" style="width:25px; margin-right:20px;"></button>
                        </form></td>
                        <td><form method="post" action="cheque.php" style="height: 40px;">
                            <button name="id_Cheque_Suppression" type="submit" class="bouton_Suppression" value="<?php echo ($cheque[0]) ?>"><img src="images/bouton_Ko.png" style="width:25px; margin-right:20px;"></button>
                        </form></td>                           
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Liste des comptes des clients de l'agence -->
        <div id="autorisations" class="item">
        <h1 style="font-variant: small-caps;">comptes et autorisations découvert</h1>
            <p style="font-size: 15px">Vous pouvez consulter la liste des comptes et paramétrer les autorisations de découvert.</p>
            <hr>
            <table class='liste' border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th style="width:20%">Client détenteur</th>
                    <th style="width:20%">Libellé compte</th>
                    <th style="width:30%">IBAN</th>
                    <th style="width:10%">Solde</th>
                    <th style="width:15%">Découvert autorisé</th>
                    <th style="width:5%"></th>
                </tr>
                <?php
                // Récupération de tous les comptes
                while($compte = $comptes->fetch_row()) { ?>
                    <tr>
                        <td><?php 
                            echo($compte[5].' '.$compte[6]); ?>
                        </td>
                        <td><?php
                            echo($compte[2]); ?>
                        </td>
                        <td><?php
                            echo($compte[3]);?>
                        </td>
                        <td><?php
                            echo($compte[1].'€');?>
                        </td>
                        <form method="post" action="autorisation_Decouvert.php" style="height: 40px;"><td>
                            <input type="number" class="info_Requise" name="decouvert" id="decouvert" size="1" min="0" max="500" value="<?php echo($compte[4]) ?>" required />
                        </td>
                        <td>
                            <button name="id_Compte" type="submit" class="bouton_Suppression" value="<?php echo ($compte[0]) ?>"><img src="images/bouton_Ok.png" style="width:25px; margin-right:20px;"></button>
                        </form></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </body>

    <script> // Script Javascript au chargement de la page
        document.getElementById("defaultOpen").click(); // Ouvre l'onglet clients par défaut
    </script>

</html>