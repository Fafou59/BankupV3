<div id="informations" class="item">
    <h1 style="font-variant: small-caps;">vos informations</h1>
    <p style="font-size: 15px">Vous pouvez modifier vos informations. N'oubliez pas de valider.</p>
    <hr>
    <!-- Affichage de toutes les informations du client,
    possibilité de modifier adresse mail et téléphone -->
    <form method="post" action="modif_Infos.php" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><label>civilité</label> :</td>
                <td class="info_Fixe" style="font-size:15px; font-weight:normal; "><?php if ($client['civilite_Client']=='F') {echo ("Mme.");} else {echo ("M.");} ?></td> 
            </tr>
            <tr>   
                <td><label>nom</label> :</td>
                <td class="info_Fixe"><?php echo ($client['nom_Client']) ?></td>   
            </tr>
            <tr>
                <td><label>prénom</label> :</td>
                <td class="info_Fixe"><?php echo ($client['prenom_Client']) ?></td>
            </tr>
            <tr>
                <td><label>date de naissance</label> :</td>
                <td class="info_Fixe"><?php echo ($client['date_Naissance_Client']) ?></td>
            </tr>
            <tr>
                <td><label>nationalité :</label></td>
                <td class="info_Fixe"><?php echo($client['pays_Client']) ?></td>
            </tr>
            <tr>
                <td><label>adresse postale</label> :</td>
                <td>
                    <label>n° de voie</label> :
                    <div class="info_Fixe"><?php echo ($client['num_Voie_Client'])?></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <label>voie</label> :
                    <div class="info_Fixe"><?php echo ($client['voie_Client']) ?></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td> 
                    <label>code postal</label> :
                    <div class="info_Fixe"><?php echo ($client['code_Postal_Client'])?></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <label>ville</label> :
                    <div class="info_Fixe"><?php echo ($client['ville_Client'])?></div>
                </td>
            </tr>

            </tr>
            <tr>
                <td><label for="email">adresse mail</label> :</td>
                <td><input class="info_Modifiable" type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" value="<?php echo ($client['adresse_Mail_Client']) ?>" required /></td>
            </tr>
            <tr>
                <td><label for="telephone">téléphone</label> :</td>
                <td><input class="info_Modifiable" type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" value="<?php echo ($client['telephone_Client']) ?>" required /></td>
            </tr>
        </table><br>
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