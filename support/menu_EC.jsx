  // Lorsque clic sur un lien d'onglet
  function ouvrir_onglet(nom_Onglet, onglet, couleur) {
    // Cacher tous les contenus d'onglets par défaut
    var i, contenu_Onglet, lien_Onglet;
    contenu_Onglet = document.getElementsByClassName("item");
    for (i = 0; i < contenu_Onglet.length; i++) {
      contenu_Onglet[i].style.display = "none";
    }
  
    // Retirer la couleur de fond de tous les liens d'onglet
    lien_Onglet = document.getElementsByClassName("lienEC");
    for (i = 0; i < lien_Onglet.length; i++) {
      lien_Onglet[i].style.backgroundColor = "";
    }
  
    // Montrer l'onglet sur lequel le visiteur a cliqué
    document.getElementById(nom_Onglet).style.display = "block";
  
    // Ajout couleur de fond pour le lien d'onglet sur lequel le visiteur a cliqué
    onglet.style.backgroundColor = couleur;
  }
  