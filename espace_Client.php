<?php
    // Ajout du menu
    include('support/menu.php');

    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }
    
    include('support/connexion_bdd.php');
    // Réaliser requête client & agence rattaché à l'id client
    $requete = $conn->prepare("SELECT client.*, agence.* FROM client, agence WHERE client.id_Client = '".$_SESSION['id']."' AND agence.id_Agence = client.agence_Client");
    $requete->execute();
    $resultat = $requete->get_result();
    $client = $resultat->fetch_assoc();

    // Réaliser requête comptes rattachés au client
    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_SESSION['id']."' = compte.id_Detenteur_Compte");
    $requete->execute();
    $resultat = $requete->get_result();

    // Réaliser requête bénéficiaires rattachés au client
    $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire WHERE beneficiaire.id_Client_Emetteur = '".$_SESSION['id']."'");
    $requete->execute();
    $beneficiaires = $requete->get_result();

    // Réaliser requête opérations débitrice du client
    $requete = $conn->prepare("SELECT operation.*, compte.* FROM operation, compte WHERE ((id_Compte = id_Emetteur_Operation) AND (operation.id_Emetteur_Operation IN (SELECT compte.id_Compte FROM compte WHERE compte.id_Detenteur_Compte = '".$_SESSION['id']."')))");
    $requete->execute();
    $operations_emetteur = $requete->get_result();

    // Réaliser requête opérations créditrice du client
    $requete = $conn->prepare("SELECT operation.*, compte.* FROM operation, compte WHERE((id_Compte = id_Recepteur_Operation) AND (operation.id_Recepteur_Operation IN (SELECT compte.id_Compte FROM compte WHERE compte.id_Detenteur_Compte = '".$_SESSION['id']."')))");
    $requete->execute();
    $operations_recepteur = $requete->get_result();
    
?>

<!DOCTYPE HTML>

<html>
    <head>
        <script type="text/javascript" src="support/menu_EC.jsx"></script>
        <script type="text/javascript" src="support/tri.jsx"></script>
        <script type="text/javascript" src="support/ouvrir_fermer.jsx"></script>
        <title>BankUP - Espace Client</title>
    </head>


    <body>
        <!-- Menu de l'espace client, affichage quand clic, informations ouvert par défaut -->
        <div id="contenu" style="width:100%">
            <div class="lienEC" style="width: 14%"> </div> 
            <button class="lienEC" onclick="ouvrir_onglet('informations', this, '#f1f1f1')" style="width: 18%" id="defaultOpen">vos informations</button>
            <button class="lienEC" onclick="ouvrir_onglet('comptes', this, '#f1f1f1')"style="width: 18%" >vos comptes</button>
            <button class="lienEC" onclick="ouvrir_onglet('operations', this, '#f1f1f1')" style="width: 18%">vos opérations</button>
            <button class="lienEC" onclick="ouvrir_onglet('beneficiaires', this, '#f1f1f1')" style="width: 18%" >vos bénéficiaires</button>
            <div class="lienEC" style="width: 14%"> </div>
        </div>

        <!-- Récupération de l'onglet informations -->
        <?php include('support/informations_EC.php'); ?>

        <!-- Récupération de l'onglet comptes -->
        <?php include('support/comptes_EC.php'); ?>

        <!-- Récupération de l'onglet opérations -->
        <?php include('support/operations_EC.php'); ?>

        <!-- Récupération de l'onglet bénéficiaires -->
        <?php include('support/beneficiaires_EC.php'); ?>
    
    </body>

    <script>
        //Exécution d'action de base à l'ouverture de la page
        document.addEventListener("load", trier_Table(0)); // Lister les opérations par date (ascendant)
        document.addEventListener("load", trier_Table(0)); // Lister les opérations par date (descendant)
        document.getElementById("defaultOpen").click(); // Ouvrir l'onglet informations par défaut
    </script>

</html>
