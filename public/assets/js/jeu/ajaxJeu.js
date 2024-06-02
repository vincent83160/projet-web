function ajaxGetFilmByTitre(query) {
  const url = "../../ajax/getFilmByTitre/query=" + query;
  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (reponse) {
      $("#list-suggestions").html("");

      let html = "";

      $.each(reponse, function (index, film) {
        if (film.release_date != null) {
          html += "<div class='suggestion row' id='" + film.id + "'>";
          html += "<div class='col-3'>";
          html += "<img src='https://image.tmdb.org/t/p/w92" + film.poster_path + "' class='img-fluid'>";
          html += "</div>";
          html += "<div class='col-9'>";
          html += "<h6>" + film.original_title + "</h6>";
          html += "<p>" + film.release_date.split("-")[0] + "</p>";
          html += "</div>";
          html += "</div>";
        }
      });

      html += "</div>";
      $("#list-suggestions").show();
      if (reponse.length === 0) {
        $("#list-suggestions").hide();
      }
      $("#list-suggestions").html(html);

      $(".suggestion").off();
      $(".suggestion").click(function () {
        const id = $(this).attr("id");
        ajaxCheckIfFilmCorrect(id);
      });
    },
    error: function (reponse, statut, erreur) {
      console.log(reponse);
      console.log(erreur);
    },
  });
}

// Fonction principale pour vérifier si le film est correct
function ajaxCheckIfFilmCorrect(id) {
  $("#input-film").val("");
  nbEssais++;
  const url = `../../ajax/checkIfFilmCorrect/idFilm=${id}`;
  toggleSpinner("show");
  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (response) {
      handleResponse(response);
      toggleSpinner("hide");
    },
    error: function (response, status, error) {
      console.error(response);
      console.error(error);
    }
  });
}

// Gère la réponse de la requête AJAX
function handleResponse(response) {
  $("#list-suggestions").html("").hide();
  updateNbEssais();

  if (response.isCorrect) {
    handleCorrectFilm(response);
  } else {
    handleIncorrectFilm(response);
  }
}

// Met à jour le nombre d'essais
function updateNbEssais() {
  const text = nbEssais === 1 ? `${nbEssais} réponse` : `${nbEssais} réponses`;
  $("#nbEssais").html(text);
}

// Gère le cas où le film est correct
function handleCorrectFilm(response) {
  const filmHTML = generateFilmHTML(response.filmChecked);
  $("#container-filmToFind").html(filmHTML);
  applyFilmBackground(response.poster_path, nbEssais);
  showCongratulationMessage(response.original_title);
  updateRecap(response);
}

// Gère le cas où le film est incorrect
function handleIncorrectFilm(response) {
  const filmHTML = generateIncorrectFilmHTML(response);
  $("#container-essais").prepend(filmHTML);
  applyFilmBackground(response.filmChecked.poster_path, nbEssais);

  updateRecap(response);

}

// Génère le HTML pour le film correct
function generateFilmHTML(response) {
  let html = `
    <div class='card essai' id='essai-${nbEssais}'>
      <h4>${response.original_title}</h4>
      <div class='row container-details'>${generateGenresHTML(response.genres)}</div>
      <div class='row container-details'>${generatePaysHTML(response.pays)}</div>
      <div class='row container-details'>${generateProductionsHTML(response.productionsDetails)}</div>
      <div class='row container-details'>
        <div class='row details'>${response.release_date}</div>
      </div>
      <div class='row container-details'>
        <div class='row row-nb-acteur-real'>
          <p>Acteurs ${response.acteurs.length}/${response.acteurs.length}</p>
          <p>Réal(s) ${response.realisateurs.length}/${response.realisateurs.length}</p>
        </div>
        <div class="row container-personne-row">
        <div class='row scrollable-row acteur-row'>${generateActeursHTML(response.acteurs)}</div>
        <div class='row scrollable-row real-row' id='find-real-row'>${generateRealisateursHTML(response.realisateurs)}</div>
      </div>
      </div>
    </div>`;
  return html;
}

// Génère le HTML pour les genres
function generateGenresHTML(genres) {
  return genres.map(genre => `<div class='details' title="Genre">${genre}</div>`).join("");
}

// Génère le HTML pour les pays
function generatePaysHTML(pays) {
  return pays.map(pays => `<div class='details' title="Pays">${pays}</div>`).join("");
}

// Génère le HTML pour les productions
function generateProductionsHTML(productions) {
  return productions.map(production => {
    let img = production.logo ? `<img src='https://image.tmdb.org/t/p/w92/${production.logo}' alt='logo de ${production.nom}'>` : '';
    return `<div class='details' title="Production">${img}${production.nom}</div>`;
  }).join("");
}

// Génère le HTML pour les acteurs
function generateActeursHTML(acteurs) {
  return acteurs.map(acteur => `
    <div class='acteur' idActeur='${acteur.id}' rang='${acteur.rang}'>
      <img class='img-acteur' src='https://image.tmdb.org/t/p/w92/${acteur.image}'>
      <p class='acteur-nom'>${acteur.name}</p>
    </div>`).join("");
}

// Génère le HTML pour les réalisateurs
function generateRealisateursHTML(realisateurs) {
  return realisateurs.map(real => `
    <div class='realisateur real-find' idReal='${real.id}'>
      <img class='img-realisateur' src='${real.image ? `https://image.tmdb.org/t/p/w92/${real.image}` : '/public/assets/img/anonyme.png'}'>
      <p class='realisateur-nom'>${real.name}</p>
    </div>`).join("");
}

// Applique le fond d'écran au film
function applyFilmBackground(posterPath, nbEssais) {
  const cssProperties = {
    "background-image": `linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74) 98%), url('https://image.tmdb.org/t/p/w500${posterPath}')`,
    "background-size": "cover",
    "background-position": "center"
  };
  $(`#essai-${nbEssais}`).css(cssProperties);
}

// Affiche un message de félicitations
function showCongratulationMessage(originalTitle) {
  $("#input-film").remove();
  $("#form").html(`<h4>Félicitations vous avez trouvé le film du jour!!</h4>${$("#form").html()}`);
  $("#titre-recap").html(originalTitle);
}

// Génère le HTML pour le film incorrect
function generateIncorrectFilmHTML(response) {
  let html = `
    <div class='card essai' id='essai-${nbEssais}'>
      <h4>${response.filmChecked.original_title}</h4>
      <div class='row container-details'>${generateEssaiGenresHTML(response)}</div>
      <div class='row container-details'>${generateEssaiPaysHTML(response)}</div>
      <div class='row container-details'>${generateEssaiProductionsHTML(response)}</div>
      <div class='row container-details'>
        <div class='row details'>${response.filmChecked.release_date}</div>
      </div>
      <div class='row row-essai'>
        <p>Acteurs</p>
        <div class="row container-personne-row">
        <div class='row scrollable-row acteur-row'>${generateIncorrectActeursHTML(response)}</div>
        <div class='row scrollable-row real-row'>${generateIncorrectRealisateursHTML(response)}</div>
      </div>
      </div>
    </div>`;
  return html;
}

function generateCheckedProductionsHTML(productions) {
  return productions.map(production => {
    const img = production.logo ? `<img src='https://image.tmdb.org/t/p/w92/${production.logo}' alt='logo de ${production.nom}'>` : '';
    return `<div class='details'>${img}${production.nom}</div>`;
  }).join("");
}

// Génère le HTML pour les pays dans les essais
function generateEssaiPaysHTML(response) {
  const paysCommuns = response.filmChecked.pays.map(pays => `<div class='details'>${pays}</div>`).join("");
  return paysCommuns;
}

// Génère le HTML pour les genres dans les essais
function generateEssaiGenresHTML(response) {
  const genresCommuns = response.filmChecked.genres.map(genre => `<div class='details'>${genre}</div>`).join("");
  return genresCommuns;
}
// Génère le HTML pour les productions dans les essais
function generateEssaiProductionsHTML(response) {
  const productionsCommuns = response.productionsFilmChecked.map(production => {
    let img = production.logo ? `<img src='https://image.tmdb.org/t/p/w92/${production.logo}' alt='logo de ${production.nom}'>` : '';
    return `<div class='details'>${img}${production.nom}</div>`;
  }).join("");
  return productionsCommuns;
}

// Obtient les détails de la date
function getDateDetails(response) {
  // Récupérer les dates de sortie des deux films et les convertir en entiers
  const checkedDate = parseInt(response.filmChecked.release_date, 10);
  const toFindDate = parseInt(response.filmToFind.release_date, 10);

  if ($("#dateLow").val() == 0 && $("#dateUp").val() == 10000) {
    if (checkedDate > toFindDate) {
      $("#dateUp").val(checkedDate);
      return `Avant ${checkedDate}`;
    } else if (checkedDate < toFindDate) {
      $("#dateLow").val(checkedDate);
      return `Après ${checkedDate}`;
    }
  }
  if (checkedDate == toFindDate || checkedDate == $("#date-recap").html()) {
    return toFindDate.toString();
  } else if (checkedDate < $("#dateUp").val() || checkedDate > $("#dateLow").val()) {

    if (toFindDate >checkedDate ) {
      // $("#dateUp").val(checkedDate);

      result = "Après " + checkedDate;
      if (checkedDate > $("#dateLow").val()) {
        $("#dateLow").val(checkedDate);
      }
    } else {
      result = "Avant " + checkedDate;
      if (checkedDate < $("#dateUp").val()) {
        $("#dateUp").val(checkedDate);
      }

    }
    let dateLow = $("#dateLow").val();
    let dateUp = $("#dateUp").val();
    if (dateUp != 10000 && dateLow != 0) {
      result = "Entre " + dateLow + " et " + dateUp;
    } else if ($("#dateUp").val() != 10000) {
      result = "Avant " + dateUp;
    } else if ($("#dateLow").val() != 0) {
      result = "Après " + dateLow;
    }
  }


  return result;
}




// Génère le HTML pour les acteurs incorrects
function generateIncorrectActeursHTML(response) {
  const acteursCommuns = response.acteursCommunsDetails.map(acteur => `
    <div class='acteur' idActeur='${acteur.id}' rang='${acteur.rang}'>
      <img class='img-acteur' src='https://image.tmdb.org/t/p/w92/${acteur.image}'>
      <p class='acteur-nom'>${acteur.name}</p>
    </div>`).join("");
  const acteursNonCommuns = response.acteursNonCommunsDetails.map(acteur => `
    <div class='acteur acteur-not-find' idActeur='${acteur.id}' rang='${acteur.rang}'>
      <img class='img-acteur' src='${acteur.image ? `https://image.tmdb.org/t/p/w92/${acteur.image}` : '/public/assets/img/anonymous.png'}'>
      <p class='acteur-nom'>${acteur.name}</p>
    </div>`).join("");
  return acteursCommuns + acteursNonCommuns;
}

// Génère le HTML pour les réals incorrects
function generateIncorrectRealisateursHTML(response) {
  const realisateursCommuns = response.realisateursCommunsDetails.map(real => `
    <div class='realisateur real-find' idReal='${real.id}'>
      <img class='img-realisateur' src='https://image.tmdb.org/t/p/w92/${real.image}'>
      <p class='realisateur-nom'>${real.name}</p>
    </div>`).join("");

  const realisateursNonCommuns = response.realisateursNonCommunsDetails.map(real => `
    <div class='realisateur real-not-find' idReal='${real.id}' >
      <img class='img-realisateur' src='${real.image ? `https://image.tmdb.org/t/p/w92/${real.image}` : '/public/assets/img/anonymous.png'}'>
      <p class='realisateur-nom'>${real.name}</p>
    </div>`).join("");

  return realisateursCommuns + realisateursNonCommuns;
}


// Met à jour le récapitulatif des informations
function updateRecap(response) {
  const dateFilm = getDateDetails(response);
  $("#date-recap").html(dateFilm);
  // Gère le cas où le film est incorrect

  if (response.genresCommuns.length > 0) {
    updateGenresRecap(response);
  }
  if (response.paysCommuns.length > 0) {
    updatePaysRecap(response);
  }

  if (response.productionsCommuns.length > 0) {
    updateProductionsRecap(response);
  }


  // Met à jour le nombre d'acteurs trouvés et leur affichage
  updateActeursRecap(response);

  // Met à jour le nombre de réalisateurs trouvés et leur affichage
  updateRealisateursRecap(response);

  // Si c'est le premier essai, créer la div de récapitulatif
  if ($(".essai").length == 1) {
    createRecapDiv(response, dateFilm);
  } else {
    updateRecapDiv(response);
  }
}
// Met à jour le récapitulatif des genres
function updateGenresRecap(response) {

  const listGenresFind = getListGenresFind(response);

  const nbGenresTotal = response.filmToFind.genres.length;


  const genresHTML = listGenresFind.map(genre => `<div class='details'>${genre}</div>`).join("");
  const placeholdersHTML = generatePlaceholderGenres(nbGenresTotal - listGenresFind.length);

  $("#genres-recap").html(genresHTML + placeholdersHTML);
}




// Génère le HTML pour les genres non trouvés
function generatePlaceholderGenres(count) {
  return Array.from({ length: count }).map(() => `<div class='details-barre'>...</div>`).join("");
}


// Met à jour le récapitulatif des pays
function updatePaysRecap(response) {
  const listPaysFind = getListPaysFind(response);
  const nbPaysTotal = response.filmToFind.pays.length;

  const paysHTML = listPaysFind.map(pays => `<div class='details'>${pays}</div>`).join("");
  const placeholdersHTML = generatePlaceholderPays(nbPaysTotal - listPaysFind.length);

  $("#pays-recap").html(paysHTML + placeholdersHTML);
}

// Génère le HTML pour les pays non trouvés
function generatePlaceholderPays(count) {
  return Array.from({ length: count }).map(() => `<div class='details-barre'>...</div>`).join("");
}


// Met à jour le récapitulatif des productions
function updateProductionsRecap(response) {
  const listProductionsFind = getListProductionsFind(response);
  const nbProductionsTotal = response.filmToFind.productions.length;

  const productionsHTML = listProductionsFind.map(production => {
    let existingElement = $(`#productions-recap .details:contains(${production})`);
    let img = '';
    if (existingElement.length > 0) {
      img = existingElement.find('img').prop('outerHTML');
    } else {
      const productionData = response.productionsCommuns.find(p => p.nom === production);
      img = productionData && productionData.logo ? `<img src='https://image.tmdb.org/t/p/w92/${productionData.logo}' alt='logo de ${productionData.nom}'>` : '';
    }
    return `<div class='details'>${img}${production}</div>`;
  }).join("");

  const placeholdersHTML = generatePlaceholderProductions(nbProductionsTotal - listProductionsFind.length);

  $("#productions-recap").html(productionsHTML + placeholdersHTML);
}





// Génère le HTML pour les productions non trouvées
function generatePlaceholderProductions(count) {
  return Array.from({ length: count }).map(() => `<div class='details-barre'>...</div>`).join("");
}



// Met à jour le récapitulatif des acteurs
function updateActeursRecap(response) {
  const listActeursFind = getListActeursFind(response);
  const nbActeursFind = listActeursFind.filter(acteur => acteur !== undefined).length;
  $("#nbActeursFind").html(nbActeursFind);

  let htmlActeurs = listActeursFind.map(acteur => {
    if (acteur !== undefined) {
      const acteurHTML = $(".acteur[idActeur='" + acteur + "']").first().html();
      return `<div class='acteur-find' idActeur='${acteur}' rang='${$(".acteur[idActeur='" + acteur + "']").attr("rang")}'>
                ${acteurHTML}
              </div>`;
    }
    return "<div class='acteur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='acteur-nom'>&nbsp;</p></div>";
  }).join("");

  const nbActeursNotFind = response.filmToFind.acteurs.length - nbActeursFind;
  for (let i = 0; i < nbActeursNotFind; i++) {
    htmlActeurs += "<div class='acteur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='acteur-nom'>&nbsp;</p></div>";
  }

  $("#find-acteur-row").html(htmlActeurs);
}

// Met à jour le récapitulatif des réalisateurs
function updateRealisateursRecap(response) {
  const listRealFind = getListRealFind(response);
  const nbRealsFind = listRealFind.length;
  $("#nbRealsFind").html(nbRealsFind);

  let htmlReals = listRealFind.map(real => {
    if (real !== undefined) {
      const realHTML = $(".realisateur[idReal='" + real + "']").first().html();
      return `<div class='realisateur real-find' idReal='${real}'>
                ${realHTML}
              </div>`;
    }
    return "<div class='realisateur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='realisateur-nom'>&nbsp;</p></div>";
  }).join("");

  const nbRealsNotFind = response.filmToFind.realisateurs.length - nbRealsFind;
  for (let i = 0; i < nbRealsNotFind; i++) {
    htmlReals += "<div class='realisateur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='realisateur-nom'>&nbsp;</p></div>";
  }

  $("#find-real-row").html(htmlReals);
}


// Crée la div de récapitulatif pour la première fois
function createRecapDiv(response, dateFilm) {
  const titre = response.isCorrect ? response.filmToFind.original_title : "Film à trouver";
  const nbGenres = response.filmToFind.genres.length;

  let htmlRecap = `<div class='card essai' id='filmToFind'>
    <h4 id='titre-recap'>${titre}</h4>
    <div id='genres-recap' class='row container-details'>
      ${generateRecapGenresHTML(response)}
    </div>
    <div id='pays-recap' class='row container-details'>
      ${generateRecapPaysHTML(response)}
    </div>
    <div id='productions-recap' class='row container-details'>
      ${generateRecapProductionsHTML(response)}
    </div>
    <div class='row container-details'>
      <div class='details' id='date-recap'>${dateFilm}</div>
    </div>
    <div class='row row-nb-acteur-real'>
      <div id='row-nbActeurs' class='row'>Acteurs <div id='nbActeursFind'>${response.acteursCommunsDetails.length}</div>/<div id='nbActeursToFind'>${response.filmToFind.acteurs.length}</div></div>
      <div id='row-nbReals' class='row'>Réal(s) <div id='nbRealsFind'>${response.realisateursCommunsDetails.length}</div>/<div id='nbRealsToFind'>${response.filmToFind.realisateurs.length}</div></div>
    </div>
    <div class="row container-personne-row">
      <div id='find-acteur-row' class='row acteur-row scrollable-row'>
        ${generateActeursRecapHTML(response)}
      </div>
      <div class='row scrollable-row real-row' id='find-real-row'>
        ${generateRealisateursRecapHTML(response)}
      </div>
    </div>
  </div>`;

  $("#container-filmToFind").html(htmlRecap);
  $("#filmToFind").css("background-image", "linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74, 0.7)), url(/public/assets/img/fond-login.webp)");
}


// Génère le HTML pour les pays dans le récapitulatif
function generateRecapPaysHTML(response) {
  const paysCommuns = response.paysCommuns.map(pays => `<div class='details'>${pays}</div>`).join("");
  const nbPaysNonCommuns = response.filmToFind.pays.length - response.paysCommuns.length;
  const paysNonCommuns = Array.from({ length: nbPaysNonCommuns }).map(() => `<div class='details-barre'>...</div>`).join("");
  return paysCommuns + paysNonCommuns;
}

// Génère le HTML pour les genres dans le récapitulatif
function generateRecapGenresHTML(response) {
  const genresCommuns = response.genresCommuns.map(genre => `<div class='details'>${genre}</div>`).join("");
  const nbGenresNonCommuns = response.filmToFind.genres.length - response.genresCommuns.length;
  const genresNonCommuns = Array.from({ length: nbGenresNonCommuns }).map(() => `<div class='details-barre'>...</div>`).join("");
  return genresCommuns + genresNonCommuns;
}
// Génère le HTML pour les productions dans le récapitulatif
function generateRecapProductionsHTML(response) {
  const productionsCommuns = response.productionsCommuns.map(production => {
    let img = production.logo ? `<img src='https://image.tmdb.org/t/p/w92/${production.logo}' alt='logo de ${production.nom}'>` : '';
    return `<div class='details'>${img}${production.nom}</div>`;
  }).join("");
  const nbProductionsNonCommuns = response.filmToFind.productions.length - response.productionsCommuns.length;
  const productionsNonCommuns = Array.from({ length: nbProductionsNonCommuns }).map(() => `<div class='details-barre'>...</div>`).join("");
  return productionsCommuns + productionsNonCommuns;
}



// Met à jour la div de récapitulatif après le premier essai
function updateRecapDiv(response) {
  const dateFilm = getDateDetails(response);
  $("#date-recap").html(dateFilm);

  const listActeursFind = getListActeursFind(response);
  const nbActeursFind = listActeursFind.filter(acteur => acteur !== undefined).length;
  $("#nbActeursFind").html(nbActeursFind);

  const htmlActeurs = generateActeursRecapHTML(response);
  $("#find-acteur-row").html(htmlActeurs);

  const listRealFind = getListRealFind(response);
  const nbRealsFind = listRealFind.length;
  $("#nbRealsFind").html(nbRealsFind);

  const htmlReals = generateRealisateursRecapHTML(response);
  $("#find-real-row").html(htmlReals);
}

// Génère le HTML pour les acteurs dans le récapitulatif
function generateActeursRecapHTML(response) {
  const listActeursFind = getListActeursFind(response);
  const nbActeursNotFind = response.filmToFind.acteurs.length - listActeursFind.filter(acteur => acteur !== undefined).length;

  let htmlActeurs = listActeursFind.map(acteur => {
    if (acteur !== undefined) {
      return `<div class='acteur-find' idActeur='${acteur}' rang='${$(".acteur[idActeur='" + acteur + "']").first().attr("rang")}'>
                ${$(".acteur[idActeur='" + acteur + "']").first().html()}
              </div>`;
    }
    return "<div class='acteur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='acteur-nom'>&nbsp;</p></div>";
  }).join("");

  for (let i = 0; i < nbActeursNotFind; i++) {
    htmlActeurs += "<div class='acteur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='acteur-nom'>&nbsp;</p></div>";
  }

  return htmlActeurs;
}

// Génère le HTML pour les réalisateurs dans le récapitulatif
function generateRealisateursRecapHTML(response) {
  const listRealFind = getListRealFind(response);
  const nbRealsNotFind = response.filmToFind.realisateurs.length - listRealFind.length;

  let htmlReals = listRealFind.map(real => {
    if (real !== undefined) {
      return `<div class='realisateur real-find' idReal='${real}'>
                ${$(".realisateur[idReal='" + real + "']").first().html()}
              </div>`;
    }
    return "<div class='realisateur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='realisateur-nom'>&nbsp;</p></div>";
  }).join("");

  for (let i = 0; i < nbRealsNotFind; i++) {
    htmlReals += "<div class='realisateur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='realisateur-nom'>&nbsp;</p></div>";
  }

  return htmlReals;
}
// Obtient la liste des acteurs trouvés
function getListActeursFind(response) {
  let listActeursFind = [];
  $(".acteur-find").each(function () {
    listActeursFind[$(this).attr("rang")] = parseInt($(this).attr("idActeur"));
  });

  response.acteursCommunsDetails.forEach(acteur => {
    if (!listActeursFind.includes(acteur.rang)) {
      listActeursFind[acteur.rang] = parseInt(acteur.id);
    }
  });

  return listActeursFind;
}


// Obtient la liste des réalisateurs trouvés
function getListRealFind(response) {
  let listRealFind = [];
  $(".realisateur.real-find").each(function () {
    const realId = parseInt($(this).attr("idReal"));
    if (!listRealFind.includes(realId)) {
      listRealFind.push(realId);
    }
  });

  response.realisateursCommunsDetails.forEach(real => {
    const realId = parseInt(real.id);
    if (!listRealFind.includes(realId)) {
      listRealFind.push(realId);
    }
  });

  return listRealFind;
}



// Obtient la liste des genres trouvés
function getListGenresFind(response) {
  let listGenresFind = [];
  $("#genres-recap .details").each(function () {
    listGenresFind.push($(this).text());
  });

  response.genresCommuns.forEach(genre => {
    if (!listGenresFind.includes(genre)) {
      listGenresFind.push(genre);
    }
  });

  return listGenresFind;
}
// Obtient la liste des pays trouvés
function getListPaysFind(response) {
  let listPaysFind = [];
  $("#pays-recap .details").each(function () {
    listPaysFind.push($(this).text());
  });

  response.paysCommuns.forEach(pays => {
    if (!listPaysFind.includes(pays)) {
      listPaysFind.push(pays);
    }
  });

  return listPaysFind;
}
// Obtient la liste des productions trouvées
function getListProductionsFind(response) {
  let listProductionsFind = [];
  $("#productions-recap .details").each(function () {
    const productionNom = $(this).text().trim().replace(/\s*\.\.\.\s*$/, '');
    listProductionsFind.push(productionNom);
  });

  response.productionsCommuns.forEach(production => {
    if (!listProductionsFind.includes(production.nom)) {
      listProductionsFind.push(production.nom);
    }
  });

  return listProductionsFind;
}
