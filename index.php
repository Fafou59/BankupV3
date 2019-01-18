<?php
    // Ajout du menu
    include('support/menu.php');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Accueil</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        <!-- Menu de la page d'accueil, pas d'affichage -->
        <div id="contenu" style="width:100%">
            <div class="lienEC" style="width: 11%"> </div> 
            <button class="lienEC" style="width: 13%">banque en ligne</button>
            <button class="lienEC" style="width: 13%" >epargner</button>
            <button class="lienEC" style="width: 13%">emprunter</button>
            <button class="lienEC" style="width: 13%">assurance</button>
            <button class="lienEC" style="width: 13%" >nos tarifs</button>
            <button class="lienEC" style="width: 13%" >nous rejoindre</button>
            <div class="lienEC" style="width: 11%"> </div>
        </div>

        <!-- Carrousel, points pour suivre l'affichage -->
        <div class="carrousel">
            <div class="image_Carrousel">
                <img src="images/img1.jpg" style="width:100%">
            </div>
            <div class="image_Carrousel">
                <img src="images/img2.jpg" style="width:100%">
            </div>
            <div class="image_Carrousel">
                <img src="images/img3.jpg" style="width:100%">
            </div>
        </div><br>
        <div style="text-align:center">
            <span class="point"></span> 
            <span class="point"></span> 
            <span class="point"></span> 
        </div>

    </body>
</html>

<script>

// Script JavaScript du Carrousel (enchaînement des images + activation des points)
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("image_Carrousel");
  var dots = document.getElementsByClassName("point");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 3000); // Change image every 2 seconds
}
</script>

