<?php
    // Ajout du menu
    include('support/menu_Admin.php');

    // Si déjà connecté, redirection vers espace admin
    if (isset($_SESSION['admin_Id'])) {
        header("Location: espace_Admin.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Connexion</title>
    </head>

    <body>
        <div id="contenu">
        <?php
            // Si identifiant (email) et mdp de l'admin renseignés
            if (isset($_POST["identifiant"], $_POST["mdp"])) {
                include('support/connexion_bdd.php');

                // Réaliser requête conseiller
                $requete = $conn->prepare("SELECT id_Conseiller, adresse_Mail_Conseiller, mdp_Conseiller, agence_Conseiller FROM conseiller WHERE adresse_Mail_Conseiller = '".$_POST["identifiant"]."'");
                $requete->execute();
                $resultat = $requete->get_result();
                $conseiller = $resultat->fetch_assoc();

                // Vérifier si mdp correct
                if ($conseiller['mdp_Conseiller']==sha1($_POST['mdp'])) {
                    $_SESSION['admin_Id'] = $conseiller['id_Conseiller'];
                    $_SESSION['admin_Agence'] = $conseiller['agence_Conseiller'];
                    header("Location: espace_Admin.php");

                //Si mdp incorrect
                } else { ?>
                    <h1>Connexion à l'espace Administrateur</h1>
                    <p>Merci de renseigner vos identifiants de connexion.</p>
                    <p style="color:red">Nom d'utilisateur ou mot de passe érroné, veuillez réessayer.</p>
                    <hr>
                    <form class="formulaire" method="post" action="connexion_Admin.php" style="border:1px solid #ccc">
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
                <h1>Connexion à l'espace Administrateur</h1>
                <p>Merci de renseigner vos identifiants de connexion.</p>
                <hr>
                <form class="formulaire" method="post" action="connexion_Admin.php" style="border:1px solid #ccc">          
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