<?php
    include('support/menu_Admin.php');

    include('support/connexion_bdd.php');

    if (!isset($_SESSION['admin_Id'])) {
        header('Location : connexion_Admin.php');
    }

    if (!isset($_POST['id_Compte'])) {
        header('Location: mirroring_Admin.php');
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Création Chéquier</title>
    </head>

    <body>
        <div class="item_EC" style="display: block"> 
        <?php
            // Recherche d'un chéquier rattaché
            $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte']);
            $requete->execute();
            $resultat = $requete->get_result();
            $chequier = $resultat->fetch_assoc();

            if (isset($chequier)) {
                $sql1 = "UPDATE chequier SET validite_Chequier = 0 WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte'];
                $sql2 = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier) VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
                if ($conn->query($sql1) === TRUE AND $conn->query($sql2) === TRUE) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le chéquier a bien été créé et l'ancien archivé.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <<p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                    <?php
                } else { ?>
                    <!-- Redirection après 3 secondes -->
                   <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                       <table>
                           <tr>
                               <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                               <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                           </tr>
                       </table>
                       <hr>
                       <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                   <?php
                }
            } else {
                $sql = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier)
                VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
                if ($conn->query($sql) === TRUE) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le chéquier a bien été créé.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                    <?php
                } else { ?>
                    <!-- Redirection après 3 secondes -->
                   <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                       <table>
                           <tr>
                               <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                               <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                           </tr>
                       </table>
                       <hr>
                       <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                    <?php
                } 
            } ?> </div>
    
    </body>
</html>