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
        <div class="slideshow-container" style="margin-left:5px; margin-right:5px;">
            <div class="mySlides fade">
                <img src="images/img1.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
                <img src="images/img2.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
                <img src="images/img3.jpg" style="width:100%">
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div><br>
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span> 
            <span class="dot" onclick="currentSlide(3)"></span> 
        </div>
        <div class="row">
            <div class="columnfabien">
                <div class="card">
                    <img src="images/fabien.jpg" alt="Fabien" style="width:100%">
                    <div class="container">
                        <h2>Fabien Lesage</h2>
                        <p><button class="button">Contact</button></p>
                    </div>
                </div>
            </div>
            <div class="columnlisa">
                <div class="card">
                    <img src="images/Lisa.jpg" alt="Lisa" style="width:100%">
                    <div class="container">
                        <h2>Lisa Mossion</h2>
                        <p><button class="button">Contact</button></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    var slideIndex = 0;
    showSlides();
    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none"; 
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1} 
        slides[slideIndex-1].style.display = "block"; 
        setTimeout(showSlides, 3001); // Change image every 3 seconds
    }
</script>

