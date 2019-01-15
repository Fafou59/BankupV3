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
        <div class="item_EC_Connexion_Inscription" style="display: block" >
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
                    <h1>connexion à votre espace client</h1>
                    <p>Merci de renseigner vos identifiants de connexion.</p>
                    <p style="color:red">Nom d'utilisateur ou mot de passe érroné, veuillez réessayer.</p>
                    <br>
                    <br>  
                    <form class="formulaire_Connexion_Inscription" method="post" action="connexion.php">
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
                            <button type="submit" class="bouton_Valider_Connexion_Insciption">Se connecter</button>
                         </div>
                    </form>
                <?php }
            // Si pas d'identifiant (email) et de mdp
            } else { ?>
                <h1>connexion à votre espace client</h1>
                <p>Merci de renseigner vos identifiants de connexion.</p>
                <br>
                <br>  
                <form class="formulaire_Connexion_Inscription" method="post" action="connexion.php">          
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
                    <button type="submit" class="bouton_Valider_Connexion_Inscription">Se connecter</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </body>
</html>