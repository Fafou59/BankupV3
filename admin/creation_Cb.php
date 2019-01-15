<?php
    include('support/menu_Admin.php');

    include('support/connexion_bdd.php');

    if (!isset($_SESSION['admin_Id'])) {
        header('Location : connexion_Admin.php');
    }

    if (!isset($_POST['id_Compte'])) {
        header('Location: mirroring_Admin.php');
    }

    if (!isset($_POST['id_Client_Admin'])) {
        header('Location: mirroring_Admin.php');
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Création CB</title>
    </head>

    <body>
        <?php
            $num_Cb = trim(rand(10000000,99999999)).trim(rand(10000000,99999999));
            $cryptogramme = rand(100,999);

            // Réaliser requête
            $sql = "INSERT INTO cb (id_Compte_Rattache, num_Cb, cryptogramme_Cb, date_Expiration_Cb)
            VALUES ('".$_POST['id_Compte']."', '".$num_Cb."', '".$cryptogramme."', DATE_ADD(NOW(),INTERVAL 5 YEAR))";
            
            if ($conn->query($sql) === TRUE) { ?>
                <!-- Redirection après 3 secondes -->
                <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                <div class="container">
                    <table>
                        <tr>
                            <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                            <td><h1 style="font-variant: small-caps;">La carte a bien été créée.</h1></td>	
                        </tr>
                    </table>
                    <hr>
                    <h2>Vous allez être redirigé vers l'espace administrateur.</h2>
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
                   <h2>Vous allez être redirigé vers l'espace administrateur.</h2>
               </div> <?php
            }
        ?>
    </body>
</html>
