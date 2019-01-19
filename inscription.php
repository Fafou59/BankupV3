<?php
    // Vérifier si client connecté, si oui renvoie vers espace client
    if (isset($_SESSION['id'])) {
        header("Location: espace_Client.php");
    }

    // Ajout du menu
    include('support/menu.php');

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Recherche d'un client avec la même adresse mail
    if (isset($_POST['email'])) {
        // Réaliser requête client & agence rattaché à l'id client
        $requete = $conn->prepare("SELECT client.adresse_Mail_Client FROM client WHERE client.adresse_Mail_Client = '".$_POST['email']."'");
        $requete->execute();
        $resultat = $requete->get_result();
        $client = $resultat->fetch_assoc();
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Inscription</title>
    </head>

    <body>
        <?php
            // Si les données ne sont pas entrées
            if (isset($client) OR !isset($_POST['civilite'], $_POST["mdp"], $_POST['telephone'], $_POST['email'], $_POST['ville'], $_POST['code_Postal'], $_POST['voie'], $_POST['numero_Voie'], $_POST['nom'], $_POST['prenom'], $_POST['date_Naissance'], $_POST['pays'])) { ?>
                <div class="item_Connexion_Inscription" style="display:block">
                    <form class="formulaire_Connexion_Inscription" style="border:none;" method="post" action="inscription.php">
                        <h1>création de votre profil</h1>
                        <p>Merci de compléter les informations ci-dessous.</p>
                        <?php 
                            if (isset($client)) { ?>
                                <p style="color:red">Un profil avec la même adresse mail existe déjà. Cliquez sur le bouton pour vous connecter :</p>
                                <button type="button" onclick="location.href='connexion.php'" class="bouton_Annuler" >Connexion</button>
                                <br><br><br>
                            <?php }
                        ?>
                        <br>
                        <hr>
                        <br>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="civilite">civilité</label> :</td>
                                <td id="civilite" class="info_Requise">
                                    <input type="radio" name="civilite" value="madame" id="madame" required />
                                    <label for="madame" style="font-size:15px; font-weight:normal; ">Mme</label>
                                    <input type="radio" name="civilite" value="monsieur" id="monsieur" required />
                                    <label for="monsieur" style="font-size:15px; font-weight:normal; ">M.</label>
                                </td> 
                            </tr>
                            <tr>   
                                <td><label for="nom">nom</label> :</td>
                                <td><input type="text" class="info_Requise" name="nom" id="nom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre nom" required /></td>   
                            </tr>
                            <tr>
                                <td><label for="prenom">prénom</label> :</td>
                                <td><input type="text" class="info_Requise" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre prénom" required /></td>
                            </tr>
                            <tr>
                                <td><label for="date_Naissance">date de naissance</label> :</td>
                                <td><input type="date" class="info_Requise" name="date_Naissance" id="date_Naissance" required /></td>
                            </tr>
                            <tr>
                                <td><label for="pays">natonalité :</label></td>
                                <td><select class="info_Requise" name="pays" id="pays" required>
                                    <?php // Rechercher la liste des pays dans le fichier correspondant pour alimenter la liste
                                        $id_fichier= fopen("support/liste_pays.txt","r");
                                        while($ligne=fgets($id_fichier,1024))
                                        {
                                            $ligne=explode(chr(9),$ligne);
                                            if ($ligne[1]=='France') // France est sélectionné par défaut
                                            print '<option value='.$ligne[0].' selected="selected">'.$ligne[1].'</option>';
                                            else
                                            print '<option value='.$ligne[0].'>'.$ligne[1].'</option>';
                                        }
                                    ?>
                                </select></td>
                            </tr>
                            <tr>
                                <td><label>adresse postale</label> :</td>
                                <td>
                                    <label for="numero_Voie">n° de voie</label> :
                                    <input type="number" class="info_Requise" name="numero_Voie" id="numero_Voie" min="0" max="99999" placeholder="Entrez votre n° voie" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="voie">voie</label> :
                                    <input type="text" class="info_Requise" name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" required />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>    
                                    <label for="code_Postal">code postal</label> :
                                    <input type="number" class="info_Requise" name="code_Postal" id="code_Postal" size="5" min="0" max="99999" placeholder="Entrez votre code postal" required />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="ville">ville</label> :
                                    <input type="text" class="info_Requise" name="ville" id="ville" size="10" minlength="0" maxlength="25" placeholder="Entrez votre ville" required />
                                </td>
                            </tr>
                            </tr>
                            <tr>
                                <td><label for="email">adresse mail</label> :</td>
                                <td><input type="email" class="info_Requise" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" required /></td>
                            </tr>
                            <tr>
                                <td><label for="telephone">téléphone</label> :</td>
                                <td><input type="tel" class="info_Requise" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" required /></td>
                            </tr>
                            <tr>
                                <td><label for="mdp">mot de passe</label> :</td>
                                <td><input type="password" class="info_Requise" name="mdp" id="mdp" size="30" minlength="" maxlength="30" placeholder="Entrez votre mot de passe" required /></td>
                            </tr>
                        </table>
                        <p>En créant votre profil, vous acceptez nos <a href="#" style="color:dodgerblue">Conditions Générales d'utilisation</a>.</p>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Ouvrir_Connexion_Inscription">Valider</button>
                        </div>
                    </form>
                </div><?php
            // Si les données sont disponibles
            } else {
                // Adaptation de la donnée civilité
                if ($_POST['civilite'] == "monsieur") {
                    $civilite = "H";
                }
                else {
                    $civilite = "F";
                }
                $nom = $_POST['nom'];
                $date_Naissance = $_POST['date_Naissance'];
                $prenom = $_POST['prenom'];
                $pays = $_POST['pays'];
                $numero_Voie = $_POST['numero_Voie'];
                $voie = $_POST['voie'];
                $code_Postal = $_POST['code_Postal'];
                $ville = $_POST['ville'];
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                $mdp = sha1($_POST['mdp']);
                // Répartition de l'agence entre parisiens/provinciaux
                if (substr($code_Postal,0,2)==75) {
                    $agence = 1;
                } else {
                    $agence = 2;
                }

                // Exécution de la requête pour ajouter le client
                $sql = "INSERT INTO client (civilite_Client, nom_Client, prenom_Client, date_Naissance_Client, adresse_Mail_Client, telephone_Client, num_Voie_Client, voie_Client, code_Postal_Client, ville_Client, mdp_Client, agence_Client, pays_Client)
                VALUES ('".$civilite."', '".$nom."', '".$prenom."', '".$date_Naissance."', '".$email."', '".$telephone."', '".$numero_Voie."', '".$voie."', '".$code_Postal."', '".$ville."', '".$mdp."','".$agence."','".$pays."')";

                // Si la requête s'effectue correctement
                if ($conn->query($sql) === TRUE) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=connexion.php">
                    <div class="item" style="display: block">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Votre profil a bien été créé.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'écran de connexion.</p>
                    </div><?php
                // Si requête KO
                } else { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=inscription.php">
                    <div class="item" style="display: block">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Une erreur s'est produite !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'inscription.</p> 
                    </div><?php
                }
            $conn->close();
            }
        ?>   
    </body>
</html>
