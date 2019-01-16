<div id="informations" class="item_EC">
    <div class="container">
        <h1 style="font-variant: small-caps;">vos informations</h1>
        <p style="font-size: 15px">Vous pouvez modifier vos informations. N'oubliez pas de valider.</p>
        <hr>
        <!-- Affichage de toutes les informations du client,
        possibilité de modifier adresse mail et téléphone -->
        <form method="post" action="modif_Infos.php" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><label>civilité</label> :</td>
                    <td id="infos"><?php if ($client['civilite_Client']=='F') {echo ("Mme.");} else {echo ("M.");} ?></td> 
                </tr>
                <tr>   
                    <td><label>nom</label> :</td>
                    <td id="infos"><?php echo ($client['nom_Client']) ?></td>   
                </tr>
                <tr>
                    <td><label>prénom</label> :</td>
                    <td id="infos"><?php echo ($client['prenom_Client']) ?></td>
                </tr>
                <tr>
                    <td><label>date de naissance</label> :</td>
                    <td id="infos"><?php echo ($client['date_Naissance_Client']) ?></td>
                </tr>
                <tr>
                    <td><label>nationalité :</label></td>
                    <td id="infos"><?php echo($client['pays_Client']) ?></td>
                </tr>
                <tr>
                    <td><label>adresse postale</label> :</td>
                    <td>
                        <label>n° de voie</label> :
                        <div id="infos"><?php echo ($client['num_Voie_Client'])?></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <label>voie</label> :
                        <div id="infos"><?php echo ($client['voie_Client']) ?></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td> 
                        <label>code postal</label> :
                        <div id="infos"><?php echo ($client['code_Postal_Client'])?></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <label>ville</label> :
                        <div id="infos"><?php echo ($client['ville_Client'])?></div>
                    </td>
                </tr>

                </tr>
                <tr>
                    <td><label for="email">adresse mail</label> :</td>
                    <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" value="<?php echo ($client['adresse_Mail_Client']) ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="telephone">téléphone</label> :</td>
                    <td><input type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" value="<?php echo ($client['telephone_Client']) ?>" required /></td>
                </tr>
            </table><br>
        <button type="submit" class="bouton_Valider"><img src="images/pencil.png" style="width:25px; margin-right:20px;">Valider les modifications</button>
    <br>    
    </form>
        <br><br><hr>
        <!-- Affichage de l'agence du client -->
        <h1 style="font-variant: small-caps; margin-bottom: 0px;">votre agence</h1>
        <p>Vous trouverez ci-dessous les informations sur votre agence de rattachement.</p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>   
                <td><label>nom de l'agence</label> :</td>
                <td id="infos"><?php echo ("BankUP ".$client['ville_Agence']) ?></td>   
            </tr>
            <tr>
                <td><label>adresse postale de l'agence</label> :</td>
                <td>
                    <div id="infos"><?php echo ($client['num_Voie_Agence']." ".$client['voie_Agence'])?></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div id="infos"><?php echo ($client['code_Postal_Agence']." ".$client['ville_Agence']) ?></div>
                </td>
            </tr>
        </table>
    </div>
</div>