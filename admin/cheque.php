<?php
    // Ajout du menu
    include('support/menu_Admin.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');
    
    // Vérifier si admin connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Chèque</title>
    </head>

    <body>
        <div class="item" style="display: block">
            <?php
                // Opérations sur compte si chèque validé
                if (isset($_POST['id_Cheque_Ajout'])) {
                    // Réaliser requête récupérer les informations de l'opération et du compte débiteur à partir de l'id du chèque
                    $requete = $conn->prepare("SELECT compte.solde_Compte, compte.autorisation_Decouvert_Compte, operation.*  FROM compte, operation WHERE compte.id_Compte = operation.id_Emetteur_Operation AND operation.id_Operation = '".$_POST['id_Cheque_Ajout']."'");
                    $requete->execute();
                    $resultat = $requete->get_result();
                    $cheque = $resultat->fetch_assoc();

                    // Si solde suffisant pour effectuer le virement
                    if ($cheque['solde_Compte'] - $cheque['montant_Operation'] >= $cheque['autorisation_Decouvert_Compte']*-1) {
                        // Requêtes pour mettre à jour les soldes et l'opération
                        $sql0 = "UPDATE compte SET solde_Compte = solde_Compte - '".$cheque['montant_Operation']."' WHERE compte.id_Compte = '".$cheque['id_Emetteur_Operation']."'";
                        $sql1 = "UPDATE compte SET solde_Compte = solde_Compte + '".$cheque['montant_Operation']."' WHERE compte.id_Compte = '".$cheque['id_Recepteur_Operation']."'";
                        $sql2 = "UPDATE operation SET operation.validite_Operation = 1 WHERE operation.id_Operation = '".$_POST['id_Cheque_Ajout']."'";
                        if ($conn->query($sql0) === TRUE AND $conn->query($sql1) === TRUE AND $conn->query($sql2)) { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Le chèque a bien été enregistré et les opérations passées.</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                            <?php
                        } else { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                            <?php
                        }
                    // Si solde insuffisant, suppression de l'opération
                    } else {
                        $sql = "DELETE FROM operation WHERE operation.id_Operation = '".$_POST['id_Cheque_Ajout']."'";
                        if ($conn->query($sql) === TRUE) { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Le solde du compte est insuffisant. Le chèque a été supprimé.</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                            <?php
                        } else { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                            <?php
                        }
                    }
                } else { // Suppression de l'opération si chèque refusé
                    if (isset($_POST['id_Cheque_Suppression'])) {
                        $sql = "DELETE FROM operation WHERE operation.id_Operation = '".$_POST['id_Cheque_Suppression']."'";
                        if ($conn->query($sql) === TRUE) { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Le chèque a bien été supprimé.</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                            <?php
                        } else { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                            <?php
                        }
                    } else { // Pas de donnée, retour sur Espace Admin
                        header('Location: espace_Admin.php');
                    }
                }
            $conn->close();
            ?>
        </div>
    </body>
</html>