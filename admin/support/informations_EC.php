<div id="informations" class="item">
    <h1 style="font-variant: small-caps;text-transform: lowercase;">informations de <?php echo($client['prenom_Client'].' '.$client['nom_Client']); ?></h1>
    <p style="font-size: 15px">Vous pouvez modifier les informations du client. N'oubliez pas de valider.</p>
    <hr>
    <!-- Affichage de toutes les informations du client,
    possibilité de modifier toutes les informations -->
    <form method="post" action="modif_Infos.php" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><label for="civilite">civilité*</label> :</td>
                <td id="civilite" class="info_Modifiable" style="border:none; box-shadow:unset;">
                    <input type="radio" name="civilite" value="madame" id="madame" required <?php if ($client['civilite_Client']=='F') {echo "checked='checked'";}  ?> />
                    <label for="madame" style="font-weight:normal; font-size:15px;">mme</label>
                    <input type="radio" name="civilite" value="monsieur" id="monsieur" required  <?php if ($client['civilite_Client']=='H') {echo "checked='checked'";} ?> />
                    <label for="monsieur" style="font-weight:normal; font-size:15px;">m.</label>
                </td> 
            </tr>
            <tr>   
                <td><label for="nom">nom</label> :</td>
                <td><input type="text" class="info_Modifiable" name="nom" id="nom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre nom" required value="<?php echo ($client['nom_Client']) ?>" /></td>   
            </tr>
            <tr>
                <td><label for="prenom">prénom</label> :</td>
                <td><input type="text" class="info_Modifiable" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre prénom" required value="<?php echo ($client['prenom_Client']) ?>" /></td>
            </tr>
            <tr>
                <td><label for="date_Naissance">date de naissance</label> :</td>
                <td><input type="date"  class="info_Modifiable" name="date_Naissance" id="date_Naissance" required value="<?php echo ($client['date_Naissance_Client']) ?>" /></td>
            </tr>
            <tr>
                <td><label for="pays">natonalité :</label></td>
                <td><select class="info_Modifiable" name="pays" id="pays" required>
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
                    <input type="number" class="info_Modifiable"  name="numero_Voie" id="numero_Voie" min="0" max="99999" placeholder="Entrez votre n° voie" value="<?php echo ($client['num_Voie_Client']) ?>" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <label for="voie">voie</label> :
                    <input type="text" class="info_Modifiable"  name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" required value="<?php echo ($client['voie_Client']) ?>" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>    
                    <label for="code_Postal">code postal</label> :
                    <input type="number" class="info_Modifiable" name="code_Postal" id="code_Postal" size="5" min="0" max="99999" placeholder="Entrez votre code postal" required value="<?php echo ($client['code_Postal_Client']) ?>" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <label for="ville">ville</label> :
                    <input type="text" class="info_Modifiable" name="ville" id="ville" size="10" minlength="0" maxlength="25" placeholder="Entrez votre ville" required value="<?php echo ($client['ville_Client']) ?>" />
                </td>
            </tr>
            </tr>
            <tr>
                <td><label for="email">adresse mail</label> :</td>
                <td><input type="email" class="info_Modifiable" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" required value="<?php echo ($client['adresse_Mail_Client']) ?>" /></td>
            </tr>
            <tr>
                <td><label for="telephone">téléphone</label> :</td>
                <td><input type="tel" class="info_Modifiable" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" required value="<?php echo ($client['telephone_Client']) ?>" /></td>
            </tr>
        </table>
        <button type="submit" class="bouton_Ouvrir"><img src="images/pencil.png" style="width:25px; margin-right:20px;">Valider les modifications</button>
    <br>   
    </form>
    <br><br><hr>
    <!-- Affichage de l'agence du client -->
    <h1 style="font-variant: small-caps; margin-bottom: 0px;">votre agence</h1>
    <p>Vous trouverez ci-dessous les informations sur votre agence de rattachement.</p>
    <table width="60%" border="0" cellspacing="0" cellpadding="0"> 
            <tr><label>nom et adresse postale de l'agence</label> :</tr>
            <tr>
                <div class="info_Fixe">
                    <?php echo ("BankUP ".$client['ville_Agence']) ?><br>
                    <?php echo ($client['num_Voie_Agence']." ".$client['voie_Agence'])?><br>
                    <?php echo ($client['code_Postal_Agence']." ".$client['ville_Agence']) ?></div>
                </div>
            </tr>
    </table>
</div>
