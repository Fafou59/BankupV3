<div id="comptes" class="item_EC">
    <h1>vos comptes</h1>
    <p style="font-size: 15px; margin-top: 15px;margin-bottom: 15px;">Vous pouvez consulter ci-dessous vos comptes. Vous pouvez également ouvrir un compte en cliquant sur le bouton situé en bas de la page.</p>
    <hr>
    <button type="submit" class="bouton_Ouvrir" onclick="location.href='ouvrir_Compte_Admin.php'"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">Ouvrir un compte</button><br><br><br>
    <hr>
    <?php 
        $i = 1;
        while($compte = $resultat->fetch_row())  { ?>
            <table class="onglet_compte" style="background-color: #E80969; width:100%; margin-bottom:50px;">
                <tr>
                    <td style="color: white; padding-left:5px; padding-right:5px; width: 8%;"><h3>compte</h3></td>
                    <td style="color: white; width:30%"><h3><?php echo $compte[4]?></h3></td>
                    <td style="color: white; padding-right:5px; width: 39%;text-align:right;font-weight: normal; font-variant: small-caps;">solde</td>
                    <td style="color: white;text-align:left;font-weight: normal; font-variant: small-caps; padding-left:5px"><?php echo $compte[3]?> €</td>
                    <td style="width:10%"><button type="submit" class="bouton_Compte" onclick="toggle_div(this,<?php echo $i;?>);"><img src="images/angle-arrow-down.png" style="width:25px"></button></td>
                </tr>
            </table>
            <div id=<?php echo $i;?> style="display:none;">
                <table style="margin-left:30px;">
                    <tr>
                        <td><h3>type de compte</h3></td>
                        <td style="text-transform: capitalize; padding-left:40px;"><?php echo $compte[2]?></td>
                    </tr>
                    <tr>
                        <td><h3>date ouverture</h3></td>
                        <td style="padding-left:40px;"><?php echo $compte[1]?></td>
                    </tr>
                    <tr>
                        <td><h3>iban</h3></td>
                        <td style="padding-left:40px;"><?php echo $compte[5]?></td>
                    </tr>
                    <tr>
                        <td><h3>bic</h3></td>
                        <td style="padding-left:40px;"><?php echo $compte[6]?></td>
                    </tr>
                    <tr>
                        <td><h3>autorisation découvert</h3></td>
                        <td style="padding-left:40px;"><?php echo $compte[7]?> €</td>
                    </tr>
                </table>
                <?php
                if ($compte[2]=="courant") {
                    //CB
                    $requete = $conn->prepare("SELECT cb.* FROM cb WHERE cb.id_Compte_Rattache = ".$compte[0]);
                    $requete->execute();
                    $resultat2 = $requete->get_result();
                    $cb = $resultat2->fetch_assoc();
                    $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); // random(ish) 5 digit int
                    ?>
                    <table>
                        <tr>
                            <?php
                            if ($cb['id_Compte_Rattache']==$compte[0]) { ?>
                                <table class="onglet_Paiement">
                                    <tr>
                                        <td style="color: white; padding-left:5px; padding-right:5px; width: 300px;"><h3>carte associée</h3></td>
                                        <td><button type="submit" class="bouton_Mini_Compte" style="background-color: #555;" onclick="toggle_div(this,<?php echo $random_number;?>);"><img src="images/angle-arrow-down.png" style="width:25px; float:right;"></button></td>
                                    </tr>
                                </table>
                                <div id="<?php echo $random_number;?>" style="display:none;">
                                    <table style="margin-top:0px; margin-left: 30px;">
                                        <tr>
                                            <td><h3>numéro de carte</h3></td>
                                            <td style="text-transform: capitalize; padding-left:40px;"><?php echo $cb['num_Cb']?></td>
                                        </tr>
                                        <tr>
                                            <td><h3>cryptogramme</h3></td>
                                            <td style="padding-left:40px;"><?php echo $cb['cryptogramme_Cb']?></td>
                                        </tr>
                                        <tr>
                                            <td><h3>date d'expiration</h3></td>
                                            <td style="padding-left:40px;"><?php echo $cb['date_Expiration_Cb'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <table>
                                    <tr>
                                        <p style="padding-left:30px; padding-bottom:10px;">Vous n'avez pas encore de carte.</p>
                                    </tr>
                                    <tr>
                                        <form method="post" action="creation_Cb.php">
                                            <button name="id_Compte" type="submit" class="bouton_Ouvrir" style="padding-left: 15px;margin-left: 30px; text-align:left;" value="<?php echo ($compte[0]) ?>"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">Nouvelle carte</button><br /><br />
                                        </form>
                                    </tr>
                                </table>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php
                            //Chéquier
                            $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$compte[0]." AND validite_Chequier = 1");
                            $requete->execute();
                            $resultat2 = $requete->get_result();
                            $chequier = $resultat2->fetch_assoc();
                            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); // random(ish) 5 digit int

                            if ($chequier['id_Compte_Rattache']==$compte[0]) { ?>
                                <table class="onglet_Paiement">
                                    <tr>
                                        <td style="color: white; padding-left:5px; padding-right:5px; width: 300px;"><h3>chéquier associé</h3></td>
                                        <td><button type="submit" class="bouton_Mini_Compte" onclick="toggle_div(this,<?php echo $random_number ;?>)"><img src="images/angle-arrow-down.png" style="width:25px; float:right;"></button></td>
                                    </tr>
                                </table>
                                <div id= <?php echo $random_number;?> style="display:none;">
                                    <table style="margin-top:0px; margin-bottom:5px; margin-left: 30px;">
                                        <tr>
                                            <td><h3>date d'émission</h3></td>
                                            <td style="text-transform: capitalize; padding-left:40px;"><?php echo $chequier['date_Emission_Chequier']?></td>
                                        </tr>
                                    </table>
                                    <form method="post" action="creation_Chequier.php" style="height:80px">
                                        <button name="id_Compte" type="submit" class="bouton_Ouvrir" style="padding-left: 15px; margin-left: 30px;text-align:left;" value="<?php echo ($compte[0]) ?>"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">nouveau chéquier</button><br /><br />
                                    </form>
                                </div>
                            <?php } else { ?>
                                <table style="padding-top:25px;">
                                    <tr>
                                        <p style="padding-left:30px; padding-bottom:10px;">Vous n'avez pas encore de chéquier.</p>
                                    </tr>
                                    <tr>
                                        <form method="post" action="creation_Chequier.php" style="height:80px">
                                            <button name="id_Compte" type="submit" class="bouton_Ouvrir" style="padding-left: 15px;margin-left: 30px; text-align:left;" value="<?php echo ($compte[0]) ?>"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">nouveau chéquier</button><br /><br />
                                        </form>
                                    </tr>
                                </table>
                            <?php } ?>
                        </tr>
                    </table>
                <?php } ?>
            </div>
            <?php
            $i = $i + 1;
        }
    ?> 
</div>
