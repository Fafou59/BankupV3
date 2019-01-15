<?php
    // Ajout du menu admin
    include('support/menu_Admin.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Vérification si admin connecté
    if (!isset($_SESSION['admin_Id'])) {
        header('Location : connexion_Admin.php');
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Suppression bénéficiaire</title>
    </head>

    <body>
        <?php
            // Vérification si donnée disponible
            if (isset($_POST['id_Beneficiaire'])) {
                // Suppression du bénéficiaire
                $sql = "DELETE FROM beneficiaire WHERE beneficiaire.id_Beneficiaire = '".$_POST['id_Beneficiaire']."'"; ?>
                <div class="item_EC" style="display: block"> <?php
                    // Si requête réalisée
                    if ($conn->query($sql) === TRUE) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le bénéficiaire a bien été supprimé.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                        <?php
                    // Si requête KO
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 50px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace administrateur.</p>
                        <?php
                    } ?>
                </div> <?php
            // Si données indispo
            } else {
                header('Location: espace_Admin.php');
            }
        ?>
    </body>
</html>