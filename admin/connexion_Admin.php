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
        <div class="item" style="display: block; margin-top:60px;"> 
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
                    <h1>connexion à l'espace administrateur</h1>
                    <p>Merci de renseigner vos identifiants de connexion.</p>
                    <br>
                    <br>  
                    <p style="color:red">Nom d'utilisateur ou mot de passe érroné, veuillez réessayer.</p>
                    <form class="formulaire_Connexion_Inscription" method="post" action="connexion_Admin.php" >
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>   
                                <td><label for="identifiant">Identifiant</label> :</td>
                                <td><input type="text" class="info_Requise" name="identifiant" id="identifiant" size="20" minlength="2" maxlength="25" placeholder="Entrez votre identifiant" autofocus /></td>   
                            </tr>
                            <tr>
                                <td><label for="mdp">Mot de passe</label> :</td>
                                <td><input type="password" class="info_Requise" name="mdp" id="mdp" size="20" minlength="2" maxlength="25" placeholder="Entrez votre mot de passe" autofocus /></td>
                            </tr>
                        </table>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Ouvrir_Connexion_Inscription">Se connecter</button>
                        </div>
                    </form>
                <?php }
            // Si pas d'identifiant (email) et de mdp
            } else { ?>
                <h1>connexion à l'espace administrateur</h1>
                <p>Merci de renseigner vos identifiants de connexion.</p>
                <br>
                <br>   
                <form class="formulaire_Connexion_Inscription" method="post" action="connexion_Admin.php" >       
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>   
                            <td><label for="identifiant">Identifiant</label> :</td>
                            <td><input type="text" class="info_Requise" name="identifiant" id="identifiant" size="20" minlength="2" maxlength="25" placeholder="Entrez votre identifiant" autofocus /></td>   
                        </tr>
                        <tr>
                            <td><label for="mdp">Mot de passe</label> :</td>
                            <td><input type="password"  class="info_Requise" name="mdp" id="mdp" size="20" minlength="2" maxlength="25" placeholder="Entrez votre mot de passe" /></td>
                        </tr>
                    </table>
                    <div class="bouton_Form">
                        <button type="submit" class="bouton_Ouvrir_Connexion_Inscription">Se connecter</button>
                    </div>
                </form>
                <br>
                <br>
            <?php } ?>
        </div>
    </body>
</html>