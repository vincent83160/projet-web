<form action="/submit_movie" method="POST">
    <p>
      <label for="id">ID:</label>
      <input type="text" id="id" name="id" required>
      <button type="button" onclick="clearInput('id')">Select</button>
    </p>

    <p>
      <label for="nom">Title:</label>
      <input type="text" id="nom" name="nom" required>
      <button type="button" onclick="clearInput('nom')">Modifier</button>
    </p>

    <p>
      <label for="date_sortie">Release Date:</label>
      <input type="date" id="date_sortie" name="date_sortie" required>
      <button type="button" onclick="clearInput('date_sortie')">Modifier</button>
    </p>

    <p>
      <label for="affiche">Poster URL:</label>
      <input type="url" id="affiche" name="affiche" required>
      <button type="button" onclick="clearInput('affiche')">Modifier</button>
    </p>

    <p>
      <label for="duree">Duration (minutes):</label>
      <input type="number" id="duree" name="duree" required>
      <button type="button" onclick="clearInput('duree')">Modifier</button>
    </p>

    <p>
      <label for="classification">Classification:</label>
      <select id="classification" name="classification" required>
        <option value="">Select Classification</option>
        <option value="G">General Audience (G)</option>
        <option value="PG">Parental Guidance Suggested (PG)</option>
        <option value="PG-13">Parents Strongly Cautioned (PG-13)</option>
        <option value="R">Restricted (R)</option>
        <option value="NC-17">Adults Only (NC-17)</option>
      </select>
      <button type="button" onclick="clearInput('classification')">Modifier</button>
    </p>

    <p>
      <label for="synopsis">Synopsis:</label>
      <textarea id="synopsis" name="synopsis" rows="4" required></textarea>
      <button type="button" onclick="clearInput('synopsis')">Modifier</button>
    </p>

    <input type="submit" value="Submit">
  </form>