<h2>Registrer klasse</h2>
<form method="post" action="index.php">
  <label>Klassekode (5):<br>
    <input type="text" name="klassekode" maxlength="5" required>
  </label><br><br>

  <label>Klassenavn:<br>
    <input type="text" name="klassenavn" maxlength="50" required>
  </label><br><br>

  <label>Studiumkode:<br>
    <input type="text" name="studiumkode" maxlength="50" required>
  </label><br><br>

  <button type="submit" name="lagre_klasse">Lagre</button>
</form>



<h2>Registrer student</h2>
<form method="post" action="index.php">
  <label>Brukernavn (max 7):<br>
    <input type="text" name="brukernavn" maxlength="7" required>
  </label><br><br>

  <label>Fornavn:<br>
    <input type="text" name="fornavn" maxlength="50" required>
  </label><br><br>

  <label>Etternavn:<br>
    <input type="text" name="etternavn" maxlength="50" required>
  </label><br><br>

  <label>Klassekode:<br>
    <select name="klassekode" required>
      <option value="">-- velg --</option>
      <option value="IT1">IT1</option>
      <option value="IT2">IT2</option>
      <option value="IT3">IT3</option>
    </select>
  </label><br><br>

  <button type="submit" name="lagre_student">Lagre</button>
</form>


<h2>Slett klasse</h2>
<form method="post" action="index.php" onsubmit="return confirm('Slette valgt klasse?');">
  <label>Velg klasse:<br>
    <select name="klassekode" required>
      <option value="">-- velg --</option>
      <option value="IT1">IT1 — IT og ledelse 1. år</option>
      <option value="IT2">IT2 — IT og ledelse 2. år</option>
      <option value="IT3">IT3 — IT og ledelse 3. år</option>
    </select>
  </label><br><br>

  <button type="submit" name="slett_klasse">Slett</button>
</form>
