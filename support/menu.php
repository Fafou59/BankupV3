<?php
    //Démarrage de la session
    session_start();
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" type="image/png" href="images/logo_Mini.png" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    </head>

    <header>
        <!-- Menu de navigation -->
        <nav style="width:100%">
            <div class="blank" style="width:11%"></div>
            <div style="width:12%" ><a href="index.php" title="Accueil"><img id="logo_BankUP" src="images/logo.png" onclick="location.href='index.php'"alt="Accueil"/></a></div >
            <div class="blank" style="width:50%"></div>
            <?php // Si le visiteur est connecté, affichage boutons déconnexion et espace client
            if (isset($_SESSION['id'])) { ?>
                <div id="item_Menu" style="13%"><button type="button" onclick="location.href='support/deconnexion.php'" title="Déconnexion" class="bouton_Connexion" >DECONNEXION</button></div>
                <div id="item_Menu" style="13%"><button type="button" onclick="location.href='espace_Client.php'" title="Espace Client" class="bouton_Inscription">ESPACE CLIENT</button></div>
            <?php // Si le visiteur n'est pas connecté, affichage boutons connexion et inscription
            } else {?>
                <div id="item_Menu" style="13%"><button type="button" onclick="location.href='connexion.php'" title="Connexion" class="bouton_Connexion">CONNEXION</button></div>
                <div id="item_Menu" style="13%"><button type="button" onclick="location.href='inscription.php'" title="Inscription" class="bouton_Inscription">DEVENIR CLIENT</button></div>
           <?php } ?>
                <div class="blank" style="width:11%"></div>
        </nav>
    </header>

    <body>
        <!-- Bouton retour au haut de la page -->
        <button onclick="fonction_Retour()" id="bouton_Haut" title="Haut de la page"><i class="fas fa-angle-up"></i></button>
    </body>


    <footer>
        <div></div>
    </footer>

</html>


<script>
    // Script JavaScript du bouton de retour au haut de la page

    // Lorsque visiteur scroll (vers le haut ou le bas), appelle de la fonction scroll
    window.onscroll = function() {fonction_Scroll()};

    // Fonction d'apparition du bouton (ou de disparition)
    function fonction_Scroll() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("bouton_Haut").style.display = "block";
        } else {
            document.getElementById("bouton_Haut").style.display = "none";
        }
    }

    // Lorsque visiteur clique sur bouton_Haut, retour en haut de la page
    function fonction_Retour() {
        document.documentElement.scrollTop = 0;
    } 
</script>




