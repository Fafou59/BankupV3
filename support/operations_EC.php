<div id="operations" class="item">
    <h1 style="font-variant: small-caps;">vos opérations</h1>
    <p style="font-size: 15px">Retrouvez la liste de vos opérations passées. Vous pouvez également faire un virement un cliquant sur le bouton correspondant.</p>
    <hr>
    <button type="submit" class="bouton_Ouvrir" onclick="location.href='virement.php'"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">Faire un virement</button><br><br>
    <br><br>
    <hr>
    <!-- Affichage de toutes les opérations du client -->
    <table class="liste" id="liste_Operations" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
        <tr>
            <th style="width:25%" onclick="trier_Table(0)">Date</th>
            <th style="width:15%" onclick="trier_Table(1)">Type opération</th>
            <th style="width:32%" onclick="trier_Table(2)">Compte</th>
            <th style="width:15%" onclick="trier_Table(3)">Montant</th>
            <th style="width:13%" onclick="trier_Table(4)">Statut</th>
        </tr>
        <?php
        // Récupération de toutes les opérations débitrices
        while($operation = $operations_emetteur->fetch_row()) { ?>
            <tr>
                <td><?php echo($operation[1]) ?></td>
                <td><?php echo($operation[4]) ?></td>
                <td><?php echo($operation[13]) ?></td>
                <td style="font-weight:bold"><?php echo('<font color="red">-'.$operation[5].'€</font>') ?></td>
                <td><?php if ($operation[8]==1) {echo('Effectué');} else {echo('En attente');}?>
            </tr>
        <?php }
        // Récupération de toutes les opérations créditrices
        while($operation = $operations_recepteur->fetch_row()) { ?>
            <tr>
                <td><?php echo($operation[1]) ?></td>
                <td><?php echo($operation[4]) ?></td>
                <td><?php echo($operation[13]) ?></td>
                <td style="font-weight:bold"><?php echo('<font color="green">+'.$operation[5].'€</font>') ?></td>
                <td><?php if ($operation[8]==1) {echo('Effectué');} else {echo('En attente');}?>
            </tr>
        <?php } 
        // Remarque : les opérations sont ensuite triées par date lors du chargement de la page (invisible pour utilisateur)
        ?>
    </table>
</div>