<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bankup";
    // Se connecter à la bdd
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Vérifier connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $requete = $conn->prepare("SELECT compte.*, cb.* FROM compte, cb WHERE compte.id_Compte = cb.id_Compte_Rattache");
    $requete->execute();
    $cbs = $requete->get_result();

    $requete = $conn->prepare("SELECT compte.*, chequier.* FROM compte, chequier WHERE compte.id_Compte = chequier.id_Compte_Rattache AND chequier.validite_Chequier = 1");
    $requete->execute();
    $chequiers = $requete->get_result();

    $requete = $conn->prepare("SELECT compte.* FROM compte");
    $requete->execute();
    $comptes = $requete->get_result();

?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <title>BankUP - GOD MODE</title>
    </head>

    <body>
        <?php
            if ((!isset($_POST["emetteur"], $_POST['recepteur'], $_POST['montant']))) { ?>
                <form class="formulaire" method="post" action="godmode.php" style="border:1px solid #ccc">
                <div class="container">
                    <h1>Faire un virement</h1>
                    <p>Merci de compléter les informations ci-dessous pour réaliser votre virement.</p>
                    <hr>
    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><label for="emetteur">Sélectionnez le compte à débiter :</label></td>
                            <td><select name="recepteur" id="pays" required>
                                <?php
                                    echo("<optgroup label='Cartes bancaires'>");
                                    while($cb = $cbs->fetch_row())
                                    {
                                        echo('<option value='.$cb[0].'>'.$cb[4].' - Solde : '.$cb[3].'€</option>');
                                    }
                                    echo("</optgroup><optgroup label='Chéquiers'>");
                                    while($chequier = $chequiers->fetch_row())
                                    {
                                        echo('<option value='.$chequier[0].'>'.$chequier[4].' - Solde : '.$chequier[3].'€</option>');
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
                                    while($compte = $comptes->fetch_row())
                                    {
                                        echo('<option value='.$compte[0].'>'.$compte[4].' - Solde : '.$compte[3].'€</option>');
                                    }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="montant">Indiquez le montant de l'opération :</label></td>
                            <td><input name="montant" type="number" min="0" required>€</td>
                        </tr>
                    </table>
                    <div class="bouton_Form">
                        <button type="button" onclick="location.href='espace_Client.php'" class="bouton_Annuler" >Retour</button>
                        <button type="submit" class="bouton_Valider">Valider</button>
                    </div>
                    </div>
                </form> <?php
            } else { 
                // Réaliser requête compte
                $requete = $conn->prepare("SELECT compte.solde_Compte, compte.autorisation_Decouvert_Compte FROM compte WHERE compte.id_Compte = ".$_POST['emetteur']);
                $requete->execute();
                $resultat = $requete->get_result();
                $solde = $resultat->fetch_assoc();

                if ($solde['solde_Compte'] - $_POST['montant'] >= $solde['autorisation_Decouvert_Compte']*-1) {
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "bankup";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql0 = "UPDATE compte SET solde_Compte = solde_Compte - ".$_POST['montant']." WHERE compte.id_Compte = '".$_POST['emetteur']."'";
                    $sql1 = "UPDATE compte SET solde_Compte = solde_Compte + ".$_POST['montant']." WHERE compte.id_Compte = '".$_POST['recepteur']."'";
                    $sql2 = "INSERT INTO operation (date_Operation, id_Emetteur_Operation, id_Recepteur_Operation, type_Operation, montant_Operation, validite_Operation) VALUES (SYSDATE(), '".$_POST['emetteur']."', '".$_POST['recepteur']."', 'Virement', '".$_POST['montant']."', 1)";
                    if ($conn->query($sql0) === TRUE AND $conn->query($sql1) === TRUE AND $conn->query($sql2)) {
                        header('Location: godmode.php');
                    } else {
                        echo "Error: " . $sql0 . "<br>" . $conn->error;
                        echo "Error: " . $sql1 . "<br>" . $conn->error;
                        echo "Error: " . $sql2 . "<br>" . $conn->error;
                    }
                } else {
                    header('Location: godmode.php');
                }
            $conn->close();
            }
        ?>
        
    </body>


    <footer>
        
    </footer>

</html>
