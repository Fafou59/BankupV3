<?php
    include('menu_Admin.php');
    
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    if (!isset($_SESSION['id_Client_Admin'])) {
        header("Location: espace_Admin.php");
    }

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

    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE  compte.id_Detenteur_Compte = '".$_SESSION['id_Client_Admin']."'");
    $requete->execute();
    $comptes = $requete->get_result();

    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE  compte.id_Detenteur_Compte = '".$_SESSION['id_Client_Admin']."'");
    $requete->execute();
    $comptes2 = $requete->get_result();
    
    $requete = $conn->prepare("SELECT beneficiaire.*, compte.* FROM beneficiaire, compte WHERE beneficiaire.id_Compte_Beneficiaire = compte.id_Compte AND beneficiaire.id_Client_Emetteur = '".$_SESSION['id_Client_Admin']."' AND beneficiaire.validite_Beneficiaire = 1");
    $requete->execute();
    $beneficiaires = $requete->get_result();

    if (isset($_POST['id_Beneficiaire'])) {
        $id_Beneficiaire = $_POST['id_Beneficiaire'];
    } else {
        $id_Beneficiaire = 0;
    }
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <title>ADMIN BankUP - Virement</title>
    </head>

    <body>
        <?php
            if ((!isset($_POST["emetteur"], $_POST['recepteur'], $_POST['montant']))) { ?>
                <form class="formulaire" method="post" action="virement_Admin.php" style="border:1px solid #ccc">
                <div class="container">
                    <h1>Faire un virement</h1>
                    <p>Merci de compléter les informations ci-dessous pour réaliser votre virement.</p>
                    <hr>
    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><label for="emetteur">Sélectionnez le compte à débiter :</label></td>
                            <td><select name="emetteur" id="pays" required>
                            <?php
                                        while($compte2 = $comptes2->fetch_row())
                                        {
                                            echo('<option value='.$compte2[0].'>'.$compte2[4].' - Solde : '.$compte2[3].'€</option>');
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="recepteur">Sélectionnez le bénéficiaire :</label></td>
                            <td>
                                <select name="recepteur" id="pays" required>
                                <?php
                                    echo("<optgroup label='Vos comptes'>");
                                    while($compte = $comptes->fetch_row())
                                    {
                                        echo('<option value='.$compte[0].'>'.$compte[4].' - Solde : '.$compte[3].'€</option>');
                                    }
                                    echo("</optgroup><optgroup label='Vos bénéficiaires'>");
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
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="montant">Indiquez le montant du virement :</label></td>
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
                        header('Location: mirroring_Admin.php');
                    } else {
                        echo "Error: " . $sql0 . "<br>" . $conn->error. "<br>";
                        echo "Error: " . $sql1 . "<br>" . $conn->error. "<br>";
                        echo "Error: " . $sql2 . "<br>" . $conn->error;
                    }
                } else {
                    header('Location: virement.php');
                }
            $conn->close();
            }
        ?>
        
    </body>


    <footer>
        
    </footer>

</html>