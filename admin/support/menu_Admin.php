<?php
    // Démarrage de la session
    session_start();
    
    // Récupération de l'adresse d'origine
    if (isset($_SERVER["HTTP_REFERER"])) {
        $origine = $_SERVER["HTTP_REFERER"];
    }
    else {
        $origine = "";
    }
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    </head>

    <header>
        <!-- Menu de navigation -->
        <nav>
            <div id="blank"></div>
            <div><a href="index.php" title="Accueil"><img id="logo_BankUP" src="images/logo2.png" onclick="location.href='espace_Admin.php'"alt="Accueil" /></a></div>
            <div id="item_Menu"></div>
            <div id="item_Menu"></div>
            <?php // Si l'administrateur est connecté, affichage boutons déconnexion et espace admin
            if (isset($_SESSION['admin_Id'])) { ?>
                <div id="item_Menu"><button type="button" onclick="location.href='support/deconnexion_Admin.php'" title="Déconnexion" class="bouton_Connexion">DECONNEXION</button></div>
                <div id="item_Menu"><button type="button" onclick="location.href='espace_Admin.php'" title="Espace Admin" class="bouton_Inscription">ESPACE ADMIN</button></div>
            <?php // Si le visiteur n'est pas connecté, affichage bouton connexion
            } else {?>
                <div id="blank"></div>
                <div id="item_Menu"><button type="button" onclick="location.href='connexion_Admin.php'" title="Connexion" class="bouton_Connexion">CONNEXION</button></div>
           <?php } ?>
                <div id="blank"></div>
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




