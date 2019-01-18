<?php
    // Ajout du menu
    include('support/menu_Admin.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');
    
    // Vérifier si admin connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    // Vérifier si client en mirroring
    if (!isset($_SESSION['id_Client_Admin'])) {
        header("Location: espace_Admin.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Création CB</title>
    </head>

    <body>
        <div class="item" style="display: block">
            <?php
                // Si donnée dispo
                if (isset($_POST['id_Compte'])) {
                    // Générer des variables aléatoires pour le numéro de carte (16 chiffres) et le cryptogramme (4 chiffres)
                    $num_Cb = trim(rand(10000000,99999999)).trim(rand(10000000,99999999));
                    $cryptogramme = rand(100,999);

                    // Réaliser requête ajout de carte
                    $sql = "INSERT INTO cb (id_Compte_Rattache, num_Cb, cryptogramme_Cb, date_Expiration_Cb)
                    VALUES ('".$_POST['id_Compte']."', '".$num_Cb."', '".$cryptogramme."', DATE_ADD(NOW(),INTERVAL 5 YEAR))";
                    // Si requête réalisée
                    if ($conn->query($sql) === TRUE) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">La CB a bien été créée.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p><?php
                    // Si requête KO
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p> <?php
                    }
                // Si donnée indispo
                } else {
                    header("Location: mirroring_Admin.php");
                }
                $conn->close();
            ?>
        </div>
    </body>
</html>