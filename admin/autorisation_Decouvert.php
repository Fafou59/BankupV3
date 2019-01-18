<?php
    // Ajout du menu
    include('support/menu_Admin.php');

    // Vérifier si admin connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    // Vérifier si données disponibles
    if (!isset($_POST['id_Compte'], $_POST['decouvert'])) {
        header("Location: espace_Admin.php");
    }

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Réaliser requête compte à modifier
    $requete = $conn->prepare("SELECT compte.solde_Compte FROM compte WHERE compte.id_Compte = '".$_POST['id_Compte']."'");
    $requete->execute();
    $resultat = $requete->get_result();
    $compte = $resultat->fetch_assoc();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Autorisation découvert</title>
    </head>

    <body>
        <div class="item" style="display: block">
            <?php
                // Vérification du solde et comparaison avec nouveau découvert autorisé
                if ($_POST['decouvert'] < $compte['solde_Compte']*-1) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                    <table>
                        <tr>
                            <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                            <td><h1 style="font-variant: small-caps;">L'autorisation de découvert est inférieur au solde du compte.</h1></td>	
                        </tr>
                    </table>
                    <hr>
                    <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace admin.</p> <?php
                // Si solde supérieur à l'autorisation de découvert
                } else {
                    //Requête de modification de l'autorisation découvert du compte
                    $sql = "UPDATE compte SET autorisation_Decouvert_Compte = '".$_POST['decouvert']."' WHERE compte.id_Compte = '".$_POST['id_Compte']."'";
                    // Si requête effectuée
                    if ($conn->query($sql) === TRUE) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">L'autorisation de découvert a bien été modifiée.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace admin.</p>
                        <?php
                    // Si requête KO
                    } else { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                        <?php
                    }
                $conn->close();
                }
            ?>
        </div>
    </body>
</html>





