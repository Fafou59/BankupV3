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
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Ouverture compte</title>
    </head>

    <body>
        <div class="item_EC" style="display: block">
            <?php
                // Si données indisponibles, formulaire de création de compte
                if ((!isset($_POST['type_Compte'])) OR (!isset($_POST["libelle_Compte"]))) { ?>
                    <h1>Création du compte</h1>
                    <p>Merci de compléter les informations ci-dessous.</p>
                    <hr>
                    <form method="post" action="ouvrir_Compte_Admin.php">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="type_Compte">Type de compte</label> :</td>
                                <td id="type_Compte">
                                    <input type="radio" name="type_Compte" value="epargne" id="epargne"  />
                                    <label for="epargne">Compte Epargne</label>
                                    <input type="radio" name="type_Compte" value="courant" id="courant"  />
                                    <label for="courant">Compte Courant</label>
                                </td> 
                            </tr>
                            <tr>   
                                <td><label for="libelle_Compte">Libellé du compte</label> :</td>
                                <td><input type="text" name="libelle_Compte" id="libelle_Compte" size="20" minlength="2" maxlength="25" placeholder="Entrez le libellé du compte" /></td>   
                            </tr>
                        </table>
                        <div class="bouton_Form">
                            <button type="button" onclick="location.href='mirroring_Admin.php'" class="bouton_Annuler" >Retour</button>
                            <button type="submit" class="bouton_Valider">Valider</button>
                        </div>
                    </form>
                    <?php
                // Si données fournies
                } else {
                    $type_Compte = $_POST['type_Compte'];
                    $libelle_Compte = $_POST['libelle_Compte'];
                    $pays = $_POST['libelle_Compte'];
                    // Adaptation de la donnée date
                    $date = date('Y/m/d');
                    // Génération aléatoire de l'IBAN (27 caractères, dont 25 chiffres)
                    $iban = "FR".trim(rand(100000000,999999999)).trim(rand(10000000,99999999)).trim(rand(10000000,99999999));
                    // Octroie de l'offre de bienvenue pour les comptes courants
                    if ($type_Compte == "courant") {
                        $solde_Compte = 1000;
                    } else {
                        $solde_Compte = 0;
                    }
                    $bic = "BKUPFRPP";
                    $autorisation_Decouvert = 0;

                    // COnnexion à bdd
                    include('support/connexion_bdd.php');

                    // Requête ajout du compte
                    $sql = "INSERT INTO compte (date_Ouverture_Compte, type_Compte, solde_Compte, libelle_Compte, iban_Compte, bic_Compte, autorisation_Decouvert_Compte, id_Detenteur_Compte)
                    VALUES ('".$date."', '".$type_Compte."', '".$solde_Compte."', '".$libelle_Compte."', '".$iban."', '".$bic."', '".$autorisation_Decouvert."', '".$_SESSION["id_Client_Admin"]."')";

                    // Si ajout réalisé
                    if ($conn->query($sql) === TRUE) { ?>
                        <!-- Redirection après 3 secondes -->
                        <meta http-equiv="Refresh" content="3;URL=mirroring_Admin.php">
                        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le compte a bien été créé.</h1></td>	
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
                $conn->close();
                }
            ?>
        </div>
    </body>
</html>