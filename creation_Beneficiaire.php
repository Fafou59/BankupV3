<?php
    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }
    // AJout du menu
    include('support/menu.php');
    
    // Vérifier si données disponibles
    if (isset($_POST['libelle_Beneficiaire'], $_POST['iban'], $_SESSION['id'])) {
        // Connexion à la bdd
        include('support/connexion_bdd.php');

        // Réaliser requête compte bénéficiaire à création
        $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_POST['iban']."' = compte.iban_Compte");
        $requete->execute();
        $resultat = $requete->get_result();
        $compte = $resultat->fetch_assoc();

        // Si compte bénéficiaire trouvé
        if (isset($compte)) {
            // Si compte trouvé appartenant au client
            if ($compte['id_Detenteur_Compte']==$_SESSION['id']) {
                header('Location: espace_Client.php');
            //Si compte appartient à autre client
            } else {
                // Vérifier si le bénéficiaire est déjà enregistré
                $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire, compte WHERE '".$_SESSION['id']."' = beneficiaire.id_Client_Emetteur AND '".$compte['id_Compte']."' = beneficiaire.id_Compte_Beneficiaire");
                $requete->execute();
                $resultat = $requete->get_result();
                $beneficiaire = $resultat->fetch_assoc();
                // Si déjà enregistré
                if (($beneficiaire['id_Compte_Beneficiaire']==$compte['id_Compte']) AND ($beneficiaire['id_Client_Emetteur']==$_SESSION['id'])) {
                    header('Location: espace_Client.php');
                // Si pas enregistré
                } else {
                    // Réaliser requête pour ajout du bénéficiaire
                    $sql = "INSERT INTO beneficiaire (id_Compte_Beneficiaire, id_Client_Emetteur, libelle_Beneficiaire, validite_Beneficiaire)
                    VALUES ('".$compte['id_Compte']."', '".$_SESSION['id']."', '".$_POST['libelle_Beneficiaire']."', 0)";
                    if ($conn->query($sql) === TRUE) {
                        header('Location: espace_Client.php');
                    // Si requête KO
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        // Si compte bénéficiaire non trouvé
        } else {
            header('Location: espace_Client.php');
        }
    // Si manque données
    } else {
        header('Location: espace_Client.php');
    }
?>
