<?php
    include('support/menu_Admin.php');

    include('support/connexion_bdd.php');

    if (!isset($_SESSION['admin_Id'])) {
        header('Location : connexion_Admin.php');
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Chèque</title>
    </head>

    <body>
        <?php
            // Opérations sur compte si chèque validé
            if (isset($_POST['id_Cheque_Ajout'])) {
                // Réaliser requête chèques
                $requete = $conn->prepare("SELECT operation.* FROM operation WHERE operation.id_Operation = '".$_POST['id_Cheque_Ajout']."'");
                $requete->execute();
                $resultat = $requete->get_result();
                $cheque = $resultat->fetch_assoc();
                $montant = $cheque['montant_Operation'];
                $sql0 = "UPDATE compte SET solde_Compte = solde_Compte - ".$montant." WHERE compte.id_Compte = '".$cheque['id_Emetteur_Operation']."'";
                $sql1 = "UPDATE compte SET solde_Compte = solde_Compte + ".$montant." WHERE compte.id_Compte = '".$cheque['id_Recepteur_Operation']."'";
                $sql2 = "UPDATE operation SET operation.validite_Operation = 1 WHERE operation.id_Operation = '".$_POST['id_Cheque_Ajout']."'";
                if ($conn->query($sql0) === TRUE AND $conn->query($sql1) === TRUE AND $conn->query($sql2)) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                    <div class="container">
  				        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le chèque a bien été enregistré et les opérations passées.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <h2>Vous allez être redirigé vers l'espace administrateur.</h2>
                    </div>
                <?php } else { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                    <div class="container">
  				        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <h2>Vous allez être redirigé vers l'espace administrateur.</h2>
                    </div> <?php
                }
            } else { // Suppression de l'opération si chèque refusé
                if (isset($_POST['id_Cheque_Suppression'])) {
                    $sql = "DELETE FROM operation WHERE operation.id_Operation = '".$_POST['id_Cheque_Suppression']."'";
                    if ($conn->query($sql) === TRUE) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                        <div class="container">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Le chèque a bien été supprimé.</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <h2>Vous allez être redirigé vers l'espace administrateur.</h2>
                        </div> <?php
                    } else { ?>
                         <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                        <div class="container">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <h2>Vous allez être redirigé vers l'espace administrateur.</h2>
                        </div> <?php
                    }
                } else { // Pas de donnée, retour sur Espace Admin
                    header('Location: espace_Admin.php');
                }
            }
            $conn->close();
        ?>
    </body>
</html>