<form action="/submit_movie" method="POST">
    <p>
      <label for="id">ID:</label>
      <input type="text" id="id" name="id" required>
      <button type="button" onclick="clearInput('id')">Select</button>
    </p>

    <p>
      <label for="original_title">Title:</label>
      <input type="text" id="original_title" name="original_title" required>
      <button type="button" onclick="clearInput('original_title')">Modifier</button>
    </p>

    <p>
      <label for="poster_path">Release Date:</label>
      <input type="date" id="poster_path" name="poster_path" required>
      <button type="button" onclick="clearInput('poster_path')">Modifier</button>
    </p>

    <p>
      <label for="poster_path">Poster URL:</label>
      <input type="url" id="poster_path" name="poster_path" required>
      <button type="button" onclick="clearInput('poster_path')">Modifier</button>
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