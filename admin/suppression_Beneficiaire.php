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
        <title>ADMIN BankUP - Suppression bénéficiaire</title>
    </head>

    <body>
        <?php
            if (isset($_POST['id_Beneficiaire'])) {
                $sql = "DELETE FROM beneficiaire WHERE beneficiaire.id_Beneficiaire = '".$_POST['id_Beneficiaire']."'";
                ?> <div class="item_EC" style="display: block"> <?php
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
                }?> </div> <?php
            } else {
                header('Location: espace_Admin.php');
            }
        ?>
    </body>
</html>