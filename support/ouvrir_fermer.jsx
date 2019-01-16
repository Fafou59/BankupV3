function toggle_div(bouton, id) { // On déclare la fonction toggle_div qui prend en param le bouton et un id
    var div = document.getElementById(id); // On récupère le div ciblé grâce à l'id
    // Si le div est masqué, on l'affiche et on change le contenu du bouton.
    if(div.style.display=="none") { 
        div.style.display = "block";
        bouton.innerHTML = "<img src=\"images/up-arrow.png\" width=\"25px\" margin-right=\"20px\">";
    // S'il est visible, on le masque et on change le contenu du bouton
    } else {
        div.style.display = "none";
        bouton.innerHTML = "<img src=\"images/angle-arrow-down.png\" width=\"25px\" margin-right=\"20px\">";
    }
}

