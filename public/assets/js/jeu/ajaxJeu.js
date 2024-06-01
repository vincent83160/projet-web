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
  console.log("Productions reçues dans handleCorrectFilm:", response.filmChecked.productions);
 
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
  console.log("Productions dans generateProductionsHTML:", productions);
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
  $("#form").html(`<h4>Félicitations vous avez trouvé le film du jour</h4>${$("#form").html()}`);
  $("#titre-recap").html(originalTitle);
}

// Génère le HTML pour le film incorrect
function generateIncorrectFilmHTML(response) {
  let html = `
    <div class='card essai' id='essai-${nbEssais}'>
      <h4>${response.filmChecked.original_title}</h4>
      <div class='row container-details'>${generateIncorrectGenresHTML(response)}</div>
      <div class='row container-details'>${generateIncorrectPaysHTML(response)}</div>
      <div class='row container-details'>${generateCheckedProductionsHTML(response.productionsFilmChecked)}</div>
      <div class='row container-details'>
        <div class='row details'>${getDateDetails(response)}</div>
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

// Génère le HTML pour les genres incorrects
function generateIncorrectGenresHTML(response) {
  const genresCommuns = response.genresCommuns.map(genre => `<div class='details'>${genre}</div>`).join("");
  const genresNonCommuns = response.genresNonCommuns.map(genre => `<div class='details-barre'>${genre}</div>`).join("");
  return genresCommuns + genresNonCommuns;
}

// Génère le HTML pour les pays incorrects
function generateIncorrectPaysHTML(response) {
  const paysCommuns = response.paysCommuns.map(pays => `<div class='details'>${pays}</div>`).join("");
  const paysNonCommuns = response.paysNonCommuns.map(pays => `<div class='details-barre'>${pays}</div>`).join("");
  return paysCommuns + paysNonCommuns;
}

// Génère le HTML pour les productions incorrects
function generateIncorrectProductionsHTML(response) {
  const productionsCommuns = response.productionsCommuns.map(production => {
    let img = production.logo ? `<img src='https://image.tmdb.org/t/p/w92/${production.logo}' alt='logo de ${production.nom}'>` : '';
    return `<div class='details'>${img}${production.nom}</div>`;
  }).join("");
  const nbProductionsNonCommuns = response.filmToFind.productions.length - response.productionsCommuns.length;
  const productionsNonCommuns = Array.from({ length: nbProductionsNonCommuns }).map(() => {
    return `<div class='details-barre' title="Production">...</div>`;
  }).join("");
  return productionsCommuns + productionsNonCommuns;
}


// Obtient les détails de la date
function getDateDetails(response) {
  const checkedDate = response.filmChecked.release_date;
  const toFindDate = response.filmToFind.release_date;

  if (checkedDate === toFindDate) {
    return checkedDate;
  }

  if (checkedDate < $("#dateUp").val() || checkedDate > $("#dateLow").val()) {
    if (toFindDate > checkedDate) {
      return `Après ${checkedDate}`;
    } else {
      return `Avant ${checkedDate}`;
    }
  }

  return `Entre ${$("#dateLow").val()} et ${$("#dateUp").val()}`;
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
  const realisateursCommuns = response.realisateursCommunsDetails && response.realisateursCommunsDetails.length > 0 ?
    response.realisateursCommunsDetails.map(real => `
      <div class='real' idReal='${real.id}'>
        <img class='img-realisateur' src='https://image.tmdb.org/t/p/w92/${real.image}'>
        <p class='real-nom'>${real.name}</p>
      </div>`).join("") : '';

  const realisateursNonCommuns = response.realisateursNonCommunsDetails && response.realisateursNonCommunsDetails.length > 0 ?
    response.realisateursNonCommunsDetails.map(real => `
      <div class='real real-not-find' idReal='${real.id}' >
        <img class='img-realisateur' src='${real.image ? `https://image.tmdb.org/t/p/w92/${real.image}` : '/public/assets/img/anonymous.png'}'>
        <p class='real-nom'>${real.name}</p>
      </div>`).join("") : '';

  return realisateursCommuns + realisateursNonCommuns;
}

// Met à jour le récapitulatif des informations
function updateRecap(response) {
  const dateFilm = getDateDetails(response);
  $("#date-recap").html(dateFilm);

  updateGenresRecap(response);
  updatePaysRecap(response);
  updateProductionsRecap(response);

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
  const genresHTML = generateIncorrectGenresHTML(response);
  $("#genres-recap").html(genresHTML);
}

// Met à jour le récapitulatif des pays
function updatePaysRecap(response) {
  const paysHTML = generateIncorrectPaysHTML(response);
  $("#pays-recap").html(paysHTML);
}

// Met à jour le récapitulatif des productions
function updateProductionsRecap(response) {
  console.log("updateProductionsRecap")
  const productionsHTML = generateIncorrectProductionsHTML(response);
  console.log(productionsHTML)
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
    <div id='genres-recap' class='row container-details'>${generateIncorrectGenresHTML(response)}</div>
    <div id='pays-recap' class='row container-details'>${generateIncorrectPaysHTML(response)}</div>
    <div id='productions-recap' class='row container-details'>${generateIncorrectProductionsHTML(response)}</div>
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
  $("#filmToFind").css("background-image", "linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74) 98%), url(/public/assets/img/fond-login.webp)");
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
  response.realisateursCommunsDetails.forEach(real => {
    if (!$(`.real-find[id='${real.id}']`).length) {
      listRealFind.push(parseInt(real.id));
    }
  });

  return listRealFind;
}
