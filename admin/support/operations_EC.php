<div id="operations" class="item_EC">
    <h1 style="font-variant: small-caps;">vos opérations</h1>
    <p style="font-size: 15px">Retrouvez la liste de vos opérations passées. Vous pouvez également faire un virement un cliquant sur le bouton correspondant.</p>
    <hr>
    <button type="submit" class="bouton_Ouvrir" onclick="location.href='virement_Admin.php'"><img src="images/add-plus-button.png" style="width:25px; margin-right:20px;">Faire un virement</button><br><br>
    <br>
    <hr>
    <table id='liste_Operations' width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
        <tr>
            <th style="width:25%" onclick="sortTable(0)">Date</th>
            <th style="width:15%" onclick="sortTable(1)">Type opération</th>
            <th style="width:32%" onclick="sortTable(2)">Compte</th>
            <th style="width:15%" onclick="sortTable(3)">Montant</th>
            <th style="width:13%" onclick="sortTable(4)">Statut</th>
        </tr>
        <?php while($operation = $operations_emetteur->fetch_row()) { ?>
            <tr>
                <td><?php echo($operation[1]) ?></td>
                <td><?php echo($operation[4]) ?></td>
                <td><?php echo($operation[13]) ?></td>
                <td style="font-weight:bold"><?php echo('<font color="red">-'.$operation[5].'€</font>') ?></td>
                <td><?php if ($operation[8]==1) {echo('Effectué');} else {echo('En attente de validation');}?>
            </tr>
        <?php }
        while($operation = $operations_recepteur->fetch_row()) { ?>
            <tr>
                <td><?php echo($operation[1]) ?></td>
                <td><?php echo($operation[4]) ?></td>
                <td><?php echo($operation[13]) ?></td>
                <td style="font-weight:bold"><?php echo('<font color="green">+'.$operation[5].'€</font>') ?></td>
                <td><?php if ($operation[8]==1) {echo('Effectué');} else {echo('En attente de validation');}?>
            </tr>
        <?php } ?>
    </table>
</div>