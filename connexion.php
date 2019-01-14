<?php
    // Ajout du menu
    include('support/menu.php');

    // Si déjà connecté, redirection vers espace client
    if (isset($_SESSION['id'])) {
        header("Location: espace_Client.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Connexion</title>
    </head>

    <body>
        <div id="contenu">
        <?php
            // Si identifiant (email) et mdp du visiteur renseignés
            if (isset($_POST["identifiant"], $_POST["mdp"])) {
                include('support/connexion_bdd.php');

                // Réaliser requête client
                $requete = $conn->prepare("SELECT id_Client, adresse_Mail_Client, mdp_Client FROM client WHERE adresse_Mail_Client = '".$_POST["identifiant"]."'");
                $requete->execute();
                $resultat = $requete->get_result();
                $client = $resultat->fetch_assoc();

                // Vérifier si mdp correct
                if ($client['mdp_Client']==sha1($_POST['mdp'])) {
                    $_SESSION['id'] = $client['id_Client'];
                    header("Location: espace_Client.php");

                //Si mdp incorrect
                } else { ?>
                    <h1>Connexion à votre espace client</h1>
                    <p>Merci de renseigner vos identifiants de connexion.</p>
                    <p style="color:red">Nom d'utilisateur ou mot de passe érroné, veuillez réessayer.</p>
                    <hr>
                    <form class="formulaire" method="post" action="connexion.php" style="border:1px solid #ccc">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>   
                                <td><label for="identifiant">Identifiant</label> :</td>
                                <td><input type="text" name="identifiant" id="identifiant" size="20" minlength="2" maxlength="25" placeholder="Entrez votre identifiant" autofocus /></td>   
                            </tr>
                            <tr>
                                <td><label for="mdp">Mot de passe</label> :</td>
                                <td><input type="password" name="mdp" id="mdp" size="20" minlength="2" maxlength="25" placeholder="Entrez votre mot de passe" autofocus /></td>
                            </tr>
                        </table>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Valider">Valider</button>
                            <button type="button" class="bouton_Annuler">Annuler</button>
                        </div>
                    </form>
                <?php }
            // Si pas d'identifiant (email) et de mdp
            } else { ?>
                <h1>Connexion à votre espace client</h1>
                <p>Merci de renseigner vos identifiants de connexion.</p>
                <hr>
                <form class="formulaire" method="post" action="connexion.php" style="border:1px solid #ccc">          
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>   
                            <td><label for="identifiant">Identifiant</label> :</td>
                            <td><input type="text" name="identifiant" id="identifiant" size="20" minlength="2" maxlength="25" placeholder="Entrez votre identifiant" autofocus /></td>   
                        </tr>
                        <tr>
                            <td><label for="mdp">Mot de passe</label> :</td>
                            <td><input type="password" name="mdp" id="mdp" size="20" minlength="2" maxlength="25" placeholder="Entrez votre mot de passe" /></td>
                        </tr>
                    </table>
                    <div class="bouton_Form">
                        <button type="button" class="bouton_Annuler">Annuler</button>
                        <button type="submit" class="bouton_Valider">Se connecter</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </body>
</html>