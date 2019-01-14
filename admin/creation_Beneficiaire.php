<?php
    include('support/menu_Admin.php');

    include('support/connexion_bdd.php');

    if (!isset($_SESSION['admin_Id'])) {
        header('Location : connexion_Admin.php');
    }

    if (!isset($_SESSION['id_Client_Admin'])) {
        header("Location: espace_Admin.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Informations modifiées</title>
    </head>

    <body>
        <?php
            $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_POST['iban']."' = compte.iban_Compte");
            $requete->execute();
            $resultat = $requete->get_result();
            $compte = $resultat->fetch_assoc();

            if (isset($compte)) {
                if ($compte['id_Detenteur_Compte']==$id_Emetteur) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                    <div class="container">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Vous ne pouvez pas ajouter un compte du client comme bénéficiaire.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <h2>Vous allez être redirigé vers l'espace client.</h2>
                    </div> <?php
                } else {
                    $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire, compte WHERE '".$id_Emetteur."' = beneficiaire.id_Client_Emetteur AND '".$compte['id_Compte']."' = beneficiaire.id_Compte_Beneficiaire");
                    $requete->execute();
                    $resultat = $requete->get_result();
                    $beneficiaire = $resultat->fetch_assoc();

                    if (($beneficiaire['id_Compte_Beneficiaire']==$compte['id_Compte']) AND ($beneficiaire['id_Client_Emetteur']==$id_Emetteur)) {
                        header('Location: mirroring_Admin.php');
                    } else {    
                        // Réaliser requête
                        $sql = "INSERT INTO beneficiaire (id_Compte_Beneficiaire, id_Client_Emetteur, libelle_Beneficiaire, validite_Beneficiaire)
                        VALUES ('".$compte['id_Compte']."', '".$id_Emetteur."', '".$libelle_Beneficiaire."', 1)";
                        
                        if ($conn->query($sql) === TRUE) {
                            header('Location: mirroring_Admin.php');
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }
            } else {
                //messsage compte non trouvé
                header('Location: mirroring_Admin.php');
            }
        ?>
