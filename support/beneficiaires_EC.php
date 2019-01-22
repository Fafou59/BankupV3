<div id="beneficiaires" class="item">
    <h1 style="font-variant: small-caps;">vos bénéficiaires</h1>
    <p style="font-size: 15px">Vous trouverez ci-dessous la liste de vos bénéficiaires. Vous pouvez ajouter un bénéficiaire avec le formulaire ci-dessous, et supprimer les bénéficiaires déjà enregistrés.</p>
    <hr>
    <table>
        <tr>
            <!-- Formulaire d'ajout d'un bénéficiaire -->
            <table class="onglet_Beneficiaire_2">
                <tr>   
                    <td style="color: white; padding-left:10px; padding-right:5px;"><h3 style="font-weight: normal; font-variant: small-caps;">ajouter un beneficiaire</h3></td>     
                    <td><button type="submit" class="bouton_Beneficiaire" style="background-color: #4caf50" onclick="toggle_div(this,'ajout_beneficiaire');"><img src="images/angle-arrow-down.png" style="width:25px"></button></td>
                </tr>
            </table>
            <div id='ajout_beneficiaire' style="display:none;">
                <p style="font-size: 15px">Merci de compléter les informations ci-dessous pour ajouter un bénéficiaire.</p>
                <form class="formulaire" method="post" action="creation_Beneficiaire.php" >
                    <div class="ajout_Beneficiaire" style="padding-bottom:70px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="libelle_Beneficiaire">libellé du bénéficiaire</label> :</td>
                                <td><input class="info_Requise" type="text" name="libelle_Beneficiaire" id="libelle_Beneficiaire" size="30" minlength="2" maxlength="30" placeholder="Entrez le libellé du bénéficiaire" required /></td>
                            </tr>
                            <tr>   
                                <td><label for="iban">iban</label> :</td>
                                <td><input class="info_Requise" type="text" name="iban" id="iban" size="27" minlength="27" maxlength="27" placeholder="Entrez l'IBAN du bénéficiaire" required /></td>   
                            </tr>
                        </table>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Ouvrir" style="float:right; margin-top: 3px;"> <img src="images/add-plus-button.png" style="width:25px; margin-right:20px;"> Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </tr>
        <br><hr><br>
        <tr>
            <!-- Liste des bénéficiaires enregistrés -->
            <table class="onglet_Beneficiaire_1" style="margin-bottom:50px;">
                <tr>
                    <td style="color: white; padding-left:10px; padding-right:5px;"><h3 style="font-weight: normal; font-variant: small-caps;">vos bénéficiaires enregistrés</h3></td>
                    <td><button type="submit" class="bouton_Beneficiaire" onclick="toggle_div(this,'liste_Beneficiaire');"><img src="images/angle-arrow-down.png" style="width:25px"></button></td>
                </tr>
            </table> 
            <div id='liste_Beneficiaire' style="display:none;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php 
                    $i = 1; ?>
                    <tr>
                        <th style="width:10%">n°</th>
                        <th style="width:40%">libellé du bénéficiaire</th>
                        <th style="width:20%">statut</th>
                        <th style="width:20%"></th>
                        <th style="width:10%"></th>
                    </tr>
                    <?php
                    // Récupération de tous les bénéficiaires du client
                    while($beneficiaire = $beneficiaires->fetch_row()) { ?>
                        <tr>
                            <td><?php echo($i) ?></td>
                            <td><?php echo($beneficiaire[3]) ?></td>
                            <?php 
                                if ($beneficiaire[4]==1) { ?>
                                    <td>Actif</td>
                                    <td><form method="post" action="virement.php">
                                        <button name="id_Beneficiaire" type="submit" class="bouton_Virement" value="<?php echo ($beneficiaire[0]) ?>"><img src="images/add-plus-button.png" style="width:15px; margin-right:10px;">Virement</button><br /><br />
                                    </form style="height: 40px;"></td>
                                <?php } else { ?>
                                    <td>En attente</td>
                                    <td></td>
                                <?php } ?>
                                    <td><form method="post" action="suppression_Beneficiaire.php" style="height: 40px;">
                                        <button name="id_Beneficiaire" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>"><img src="images/bin.png" style="width:25px; margin-right:20px;"></button><br /><br />
                                    </form></td>
                            <?php $i = $i + 1; ?>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </tr>
    </table>
</div>
