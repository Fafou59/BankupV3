<div id="informations" class="item_EC">
    <div class="container">
        <h1>vos informations</h1>
        <p style="font-size: 15px">Vous pouvez modifier vos informations. N'oubliez pas de valider.</p>
        <hr>
        <form method="post" action="modif_Infos.php" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><label for="civilite">Civilité*</label> :</td>
                    <td id="civilite">
                        <input type="radio" name="civilite" value="madame" id="madame" required <?php if ($client['civilite_Client']=='F') {echo "checked='checked'";}  ?> />
                        <label for="madame">Mme</label>
                        <input type="radio" name="civilite" value="monsieur" id="monsieur" required  <?php if ($client['civilite_Client']=='H') {echo "checked='checked'";} ?> />
                        <label for="monsieur">M.</label>
                    </td> 
                </tr>
                <tr>   
                    <td><label for="nom">Nom</label> :</td>
                    <td><input type="text" name="nom" id="nom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre nom" required value="<?php echo ($client['nom_Client']) ?>" /></td>   
                </tr>
                <tr>
                    <td><label for="prenom">Prénom</label> :</td>
                    <td><input type="text" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre prénom" required value="<?php echo ($client['prenom_Client']) ?>" /></td>
                </tr>
                <tr>
                    <td><label for="date_Naissance">Date de naissance</label> :</td>
                    <td><input type="date" name="date_Naissance" id="date_Naissance" required value="<?php echo ($client['date_Naissance_Client']) ?>" /></td>
                </tr>
                <tr>
                    <td><label for="pays">Natonalité :</label></td>
                    <td><select name="pays" id="pays" required>
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
                    <td><label>Adresse postale</label> :</td>
                    <td>
                        <label for="numero_Voie">N° de voie</label> :
                        <input type="number" name="numero_Voie" id="numero_Voie" min="0" max="99999" placeholder="Entrez votre n° voie" value="<?php echo ($client['num_Voie_Client']) ?>" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <label for="voie">Voie</label> :
                        <input type="text" name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" required value="<?php echo ($client['voie_Client']) ?>" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>    
                        <label for="code_Postal">Code postal</label> :
                        <input type="number" name="code_Postal" id="code_Postal" size="5" min="0" max="99999" placeholder="Entrez votre code postal" required value="<?php echo ($client['code_Postal_Client']) ?>" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <label for="ville">Ville</label> :
                        <input type="text" name="ville" id="ville" size="10" minlength="0" maxlength="25" placeholder="Entrez votre ville" required value="<?php echo ($client['ville_Client']) ?>" />
                    </td>
                </tr>
                </tr>
                <tr>
                    <td><label for="email">Adresse mail</label> :</td>
                    <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" required value="<?php echo ($client['adresse_Mail_Client']) ?>" /></td>
                </tr>
                <tr>
                    <td><label for="telephone">Téléphone</label> :</td>
                    <td><input type="tel" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" required value="<?php echo ($client['telephone_Client']) ?>" /></td>
                </tr>
            </table>
            <button type="submit" class="bouton_Valider"><img src="images/pencil.png" style="width:25px; margin-right:20px;">Valider les modifications</button>
        <br>   
        </form>
        <br><br><hr>
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
