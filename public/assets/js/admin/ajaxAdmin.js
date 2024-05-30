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
      console.log(response);
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
  const filmHTML = generateFilmHTML(response);
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
      <div class='row container-details'>${generateGenresHTML(response.genresCommuns)}</div>
      <div class='row container-details'>${generatePaysHTML(response.paysCommuns)}</div>
      <div class='row container-details'>${generateProductionsHTML(response.productionsCommuns)}</div>
      <div class='row container-details'>
        <div class='row details'>${response.release_date}</div>
      </div>
      <div class='row container-details'>
        <div class='row row-nb-acteur-real'>
          <p>Acteurs ${response.acteursCommunsDetails.length}/${response.acteurs.length}</p>
          <p>Réal(s) ${response.realisateursCommunsDetails.length}/${response.realisateurs.length}</p>
        </div>
        <div class="row container-personne-row">
        <div class='row scrollable-row acteur-row'>${generateActeursHTML(response.acteursCommunsDetails)}</div>
        <div class='row scrollable-row real-row' id='find-real-row'>${generateRealisateursHTML(response.realisateursCommunsDetails)}</div>
      </div>
      </div>
    </div>`;
  return html;
}

// Génère le HTML pour les genres
function generateGenresHTML(genres) {
  return genres.map(genre => `<div class='details'>${genre}</div>`).join("");
}

// Génère le HTML pour les pays
function generatePaysHTML(pays) {
  return pays.map(pays => `<div class='details'>${pays}</div>`).join("");
}

// Génère le HTML pour les productions
function generateProductionsHTML(productions) {
  return productions.map(production => {
    const img = production.logo ? `<img src='https://image.tmdb.org/t/p/w92/${production.logo}' alt='logo de ${production.nom}'>` : '';
    return `<div class='details'>${img}${production.nom}</div>`;
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

// Met à jour le récapitulatif des informations
function updateRecap(response) {
  const dateFilm = getDateDetails(response);
  $("#date-recap").html(dateFilm);

  updateGenresRecap(response.genresCommuns);
  updatePaysRecap(response.paysCommuns);

  updateProductionsRecap(response.productionsCommuns);

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
function updateGenresRecap(genres) {
  const genresHTML = generateGenresHTML(genres);
  $("#genres-recap").html(genresHTML);
}

// Met à jour le récapitulatif des pays
function updatePaysRecap(pays) {
  const paysHTML = generatePaysHTML(pays);
  $("#pays-recap").html(paysHTML);
}

// Met à jour le récapitulatif des productions
function updateProductionsRecap(productions) {
  const productionsHTML = generateProductionsHTML(productions);
  $("#productions-recap").html(productionsHTML);
}

// Met à jour le récapitulatif des acteurs
function updateActeursRecap(response) {
  const listActeursFind = getListActeursFind(response);
  const nbActeursFind = listActeursFind.filter(acteur => acteur !== undefined).length;
  $("#nbActeursFind").html(nbActeursFind);

  let htmlActeurs = listActeursFind.map(acteur => {
    if (acteur !== undefined) {
      return `<div class='acteur-find' idActeur='${acteur}' rang='${acteur.rang}'>
                ${$(".acteur[idActeur='" + acteur + "']").first().html()}
              </div>`;
    }
    return "<div class='acteur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='acteur-nom'>&nbsp;</p></div>";
  }).join("");

  $("#find-acteur-row").html(htmlActeurs);
}

// Met à jour le récapitulatif des réalisateurs
function updateRealisateursRecap(response) {
  const listRealFind = getListRealFind(response);
  const nbRealsFind = listRealFind.length;
  $("#nbRealsFind").html(nbRealsFind);

  let htmlReals = listRealFind.map(real => {
    if (real !== undefined) {
      return `<div class='realisateur real-find' idReal='${real}'>
                ${$(".realisateur[idReal='" + real + "']").first().html()}
              </div>`;
    }
    return "<div class='realisateur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='realisateur-nom'>&nbsp;</p></div>";
  }).join("");

  $("#find-real-row").html(htmlReals);
}

// Crée la div de récapitulatif pour la première fois
function createRecapDiv(response, dateFilm) {
  let htmlRecap = `<div class='card essai' id='filmToFind'>
    <h4 id='titre-recap'>Film à trouver</h4>
    <div id='genres-recap' class='row container-details'>${generateGenresHTML(response.genresCommuns)}</div>
    <div id='pays-recap' class='row container-details'>${generatePaysHTML(response.paysCommuns)}</div>
    <div id='productions-recap' class='row container-details'>${generateProductionsHTML(response.productionsCommuns)}</div>
    <div class='row container-details'>
      <div class='details' id='date-recap'>${dateFilm}</div>
    </div>
    <div class='row row-nb-acteur-real'>
      <div id='row-nbActeurs' class='row'>Acteurs <div id='nbActeursFind'>${response.acteursCommunsDetails.length}</div>/<div id='nbActeursToFind'>${response.acteurs.length}</div></div>
      <div id='row-nbReals' class='row'>Réal(s) <div id='nbRealsFind'>${response.realisateursCommunsDetails.length}</div>/<div id='nbRealsToFind'>${response.realisateurs.length}</div></div>
    </div>
    <div class="row container-personne-row">
      <div id='find-acteur-row' class='row acteur-row scrollable-row'>
        ${generateActeursHTML(response.acteursCommunsDetails)}
      </div>
      <div class='row scrollable-row real-row' id='find-real-row'>
        ${generateRealisateursHTML(response.realisateursCommunsDetails)}
      </div>
    </div>
  </div>`;

  $("#container-filmToFind").html(htmlRecap);
  $("#filmToFind").css("background-image", "linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74, 0.7)), url('/public/assets/img/fond-login.webp')");
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

  const productionsHTML = generateProductionsHTML(response.productionsCommuns);
  $("#productions-recap").html(productionsHTML);
}

// Génère le HTML pour les acteurs dans le récapitulatif
function generateActeursRecapHTML(response) {
  const listActeursFind = getListActeursFind(response);
  const nbActeursNotFind = response.acteurs.length - listActeursFind.filter(acteur => acteur !== undefined).length;

  let htmlActeurs = listActeursFind.map(acteur => {
    if (acteur !== undefined) {
      return `<div class='acteur-find' idActeur='${acteur}' rang='${acteur.rang}'>
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
  const nbRealsNotFind = response.realisateurs.length - listRealFind.length;

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
  response.realisateursCommunsDetails.forEach(real => {
    if (!$(`.real-find[id='${real.id}']`).length) {
      listRealFind.push(parseInt(real.id));
    }
  });

  return listRealFind;
}

