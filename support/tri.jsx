function trier_Table(n) {
  var table, rows, inverser, i, x, y, inversement, dir, nombre_Inversement = 0;
  table = document.getElementById("liste_Operations");
  inverser = true;
  // Direction de l'inversement en ascendant
  dir = "asc";
  // Boucle pour inverser jusqu'à ce qu'il n'y ait plus d'inversement
  while (inverser) {
    // pas d'inversement
    inverser = false;
    rows = table.rows;
    // Boucle sur toutes les lignes sauf la première (th)
    for (i = 1; i < (rows.length - 1); i++) {
      // De base, pas d'inversement
      inversement = false;
      // Comparer les éléments d'une même colonne pour deux lignes
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      // Regarder si les élements devraient s'inverser
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // Si oui, marquer l'inversement et casser la boucle
          inversement = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // Si oui, marquer l'inversement et casser la boucle
          inversement = true;
          break;
        }
      }
    }
    if (inversement) {
      // Réalisation de l'inversement marqué
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      inverser = true;
      // Mise à jour du compte d'inversements
      nombre_Inversement ++;
    } else {
      // Si pas d'inversement, changement du sens d'inversement et redémarrage de la boucle
      if (nombre_Inversement == 0 && dir == "asc") {
        dir = "desc";
        inverser = true;
      }
    }
  }
}

