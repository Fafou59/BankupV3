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
            if (!isset($_POST['civilite'], $_POST['telephone'], $_POST['email'], $_POST['ville'], $_POST['code_Postal'], $_POST['voie'], $_POST['numero_Voie'], $_POST['nom'], $_POST['prenom'], $_POST['date_Naissance'], $_POST['pays'])) { ?>
                <!-- Redirection après 3 secondes -->
               <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
               <div class="container">
                   <table>
                       <tr>
                           <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                           <td><h1 style="font-variant: small-caps;">Il manque des informations... Veuillez réessayer !</h1></td>	
                       </tr>
                   </table>
                   <hr>
                   <h2>Vous allez être redirigé vers l'espace client.</h2>
               </div> <?php
            } else {
                if ($_POST['civilite'] == "monsieur") {
                    $civilite = "H";
                }
                else {
                    $civilite = "F";
                }
                $nom = $_POST['nom'];
                $date_Naissance = $_POST['date_Naissance'];
                $prenom = $_POST['prenom'];
                $pays = $_POST['pays'];
                $numero_Voie = $_POST['numero_Voie'];
                $voie = $_POST['voie'];
                $code_Postal = $_POST['code_Postal'];
                $ville = $_POST['ville'];
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                if (substr($code_Postal,0,2)==75) {
                    $agence = 1;
                } else {
                    $agence = 2;
                }

                $sql = "UPDATE client SET civilite_Client = '".$civilite."', nom_Client = '".$nom."', prenom_Client = '".$prenom."', date_Naissance_Client = '".$date_Naissance."', adresse_Mail_Client = '".$email."', telephone_Client = '".$telephone."', num_Voie_Client = '".$numero_Voie."', voie_Client = '".$voie."', code_Postal_Client = '".$code_Postal."', ville_Client = '".$ville."', agence_Client = '".$agence."', pays_Client = '".$pays."' WHERE client.id_Client = '".$_SESSION['id_Client_Admin']."'";

                if ($conn->query($sql) === TRUE) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                    <div class="container">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Les informations ont bien été modifiées.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <h2>Vous allez être redirigé vers l'espace client.</h2>
                    </div> <?php
                } else { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                    <div class="container">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <h2>Vous allez être redirigé vers l'espace client.</h2>
                    </div> <?php
                }
            $conn->close();
            }
        ?> 
    </body>
</html>





