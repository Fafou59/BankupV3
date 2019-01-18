<?php
    // Ajout du menu
    include('support/menu_Admin.php');

    // Vérifier si admin connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

    // Vérifier si client en mirroring
    if (!isset($_SESSION['id_Client_Admin'])) {
        header("Location: espace_Admin.php");
    }

    // Connexion à la bdd
    include('support/connexion_bdd.php');

    // Recherche d'un client avec la même adresse mail
    if (isset($_POST['email'])) {
        // Réaliser requête client & agence rattaché à l'id client
        $requete = $conn->prepare("SELECT client.adresse_Mail_Client FROM client WHERE client.adresse_Mail_Client = '".$_POST['email']."' AND client.id_Client <> '".$_SESSION['id_Client_Admin']."'");
        $requete->execute();
        $resultat = $requete->get_result();
        $client = $resultat->fetch_assoc();
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Informations modifiées</title>
    </head>

    <body>
        <div class="item" style="display: block">
            <?php
                // Si données non renseignées, renvoie sur espace client
                if (!isset($_POST['civilite'], $_POST['telephone'], $_POST['email'], $_POST['ville'], $_POST['code_Postal'], $_POST['voie'], $_POST['numero_Voie'], $_POST['nom'], $_POST['prenom'], $_POST['date_Naissance'], $_POST['pays'])) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                    <div class="container">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Il manque des informations... Veuillez réessayer !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                    </div> <?php
                // Si données renseignées
                } else {
                    // Si un autre client a déjà cette adresse mail
                    if (isset($client)) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_KO.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Oups... Un profil avec la même adresse mail existe déjà !</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p> <?php
                    // Si l'adresse n'est pas déjà utilisée
                    } else {
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
                        if (substr($code_Postal,0,2)==75) {
                            $agence = 1;
                        } else {
                            $agence = 2;
                        }

                        // Connexion à la bdd
                        include('support/connexion_bdd.php');

                        //Requête de modification du client
                        $sql = "UPDATE client SET civilite_Client = '".$civilite."', nom_Client = '".$nom."', prenom_Client = '".$prenom."', date_Naissance_Client = '".$date_Naissance."', adresse_Mail_Client = '".$email."', telephone_Client = '".$telephone."', num_Voie_Client = '".$numero_Voie."', voie_Client = '".$voie."', code_Postal_Client = '".$code_Postal."', ville_Client = '".$ville."', agence_Client = '".$agence."', pays_Client = '".$pays."' WHERE client.id_Client = '".$_SESSION['id_Client_Admin']."'";

                        // Si requête effectuée
                        if ($conn->query($sql) === TRUE) { ?>
                            <!-- Redirection après 3 secondes -->
                            <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                            <table>
                                <tr>
                                    <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                    <td><h1 style="font-variant: small-caps;">Les informations du client ont bien été modifiées.</h1></td>	
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                            <?php
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
                            <p style="font-size: 18px; padding-left: 110px;">Vous allez être redirigé vers l'espace client.</p>
                            <?php
                        }
                    }
                $conn->close();
                }
            ?>
        </div>
    </body>
</html>





