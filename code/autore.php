<!DOCTYPE HTML>
<html>
<head>
  <title>MUSEO START</title>
  <link rel="stylesheet" href="./css/cssStyle.css">
  <script type="text/javascript" src="./js/jquery-2.0.0.js"></script>
  <script type="text/javascript" src="./js/jsAutore.js"></script>
</head>

<body>

  <?php
  include 'nav.html';
  include 'footer.html';
  ?>

  <div id="filtri">
    <form name="myform" method="POST">
      <input id="codice" name="codice" type="text" placeholder="codice"/>
      <input id="nome" name="nome" type="text" placeholder="Nome"/>
      <input id="cognome" name="cognome" type="text" placeholder="Cognome"/>
      <input id="nazione" name="nazione" type="text" placeholder="Nazione"/>
      <input id="dataNascita" name="dataNascita" type="text" placeholder="data Nascita"/>
      <input id="dataMorte" name="dataMorte" type="text" placeholder="data Morte"/>
      <input id="numeroOpere" name="numeroOpere" type="text" placeholder="Numero Opere"/>

      <input type="submit" value="Search"/>
      <input type="submit" value="RESET"/>
    </form>

    <form name="myform2" method="post">
      <input id="opera" name="nomeopera" type="text" placeholder="Titolo dell'opera">
      <input type="submit" value="Cerca per opera">
    </form>

    <form name="myformCRUD" method="post">
      <input id="CRUD" name="CRUD" type="submit" value="CRUD">
      <label for="CRUD">CRUD</label>
    </form>

    <form name="myformBack" method="post">
      <input id="backButton" name="back" type="submit" value="Back" onclick="hideCreateButton()">
      <label for="backButton">Back</label>
    </form>

    <div id="options" style="display:none;">
      <button id="createButton" onclick="showCreateForm()">Creare</button>
    </div>

    <div id="result">
      <?php
      $codice = "";
      $nome = "";
      $cognome  = "";
      $nazione = "";
      $dataNascita  = "";
      $dataMorte = "";
      $tipo = "";
      $numeroOpere  = "";
      $nomeopera="";
      $mostra = false;

      if (isset($_POST['CRUD']) && $_POST['CRUD'] === 'CRUD') {
        $mostra = true;
      }

      if(count($_POST) > 0) {
        $codice = $_POST["codice"];
        $nome = $_POST["nome"];
        $cognome  = $_POST["cognome"];
        $nazione = $_POST["nazione"];
        $dataNascita  = $_POST["dataNascita"];
        $dataMorte = $_POST["dataMorte"];
        $tipo = $_POST["tipo"];
        $numeroOpere  = $_POST["numeroOpere"];
        $nomeopera  = $_POST["nomeopera"];
      } else if(count($_GET) > 0) {
        $codice = $_GET["codice"];
        $nome = $_GET["nome"];
        $cognome  = $_GET["cognome"];
        $nazione = $_GET["nazione"];
        $dataNascita  = $_GET["dataNascita"];
        $dataMorte = $_GET["dataMorte"];
        $tipo = $_GET["tipo"];
        $numeroOpere  = $_GET["numeroOpere"];
        $nomeopera  = $_GET["nomeopera"];
      }

      include 'autoreManager.php';
      $error = false;

      require_once 'connDb.php';
      $query = getAutoreQry($codice, $nome, $cognome, $nazione, $dataNascita, $dataMorte, $tipo, $numeroOpere, $nomeopera);

      try {
          $result = $conn->query($query);
      } catch(PDOException $e) {
          echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
          $error = true;
      }

      if(!$mostra && !$error && $result->rowCount() > 0) {

        if($nomeopera==""){
          ?>
          <table class="table">
              <tr class="header">
                  <th>Codice</th>
                  <th>Nome</th>
                  <th>Cognome</th>
                  <th>Nazione</th>
                  <th>Data Nascita</th>
                  <th>Data Morte</th>
                  <th>Tipo</th>
                  <th>Numero Opere</th>
              </tr>
              <?php
              foreach($result as $riga) {
                  $codice = $riga["codice"];
                  $nome = $riga["nome"];
                  $cognome  = $riga["cognome"];
                  $nazione = $riga["nazione"];
                  $dataNascita  = $riga["dataNascita"];
                  $dataMorte = $riga["dataMorte"];
                  $tipo = $riga["tipo"];
                  $numeroOpere  = $riga["numeroOpere"];

                  ?>
                  <tr>
                      <td><?php echo $codice; ?></td>
                      <td><?php echo $nome; ?></td>
                      <td><?php echo $cognome; ?></td>
                      <td><?php echo $nazione; ?></td>
                      <td><?php echo $dataNascita; ?></td>
                      <td><?php echo $dataMorte; ?></td>
                      <td><?php echo $tipo; ?></td>

                      <td>
            <a href="opera.php?autore=<?php echo urlencode($codice); ?>">
              <?php echo $numeroOpere; ?>
            </a>
          </td>
                  </tr>
              <?php } ?>
          </table>
      <?php }
      elseif ($nomeopera!="") {
        ?>
        <table class="table">
            <tr class="header">
                <th>Codice</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Nazione</th>
                <th>Data Nascita</th>
                <th>Data Morte</th>
                <th>Tipo</th>
                <th>Numero Opere</th>
                <th>Titolo Opera</th>
            </tr>
            <?php
            foreach($result as $riga) {
                $codice = $riga["codice"];
                $nome = $riga["nome"];
                $cognome  = $riga["cognome"];
                $nazione = $riga["nazione"];
                $dataNascita  = $riga["dataNascita"];
                $dataMorte = $riga["dataMorte"];
                $tipo = $riga["tipo"];
                $numeroOpere  = $riga["numeroOpere"];
                $nomeopera  = $riga["nomeopera"];
                ?>
                <tr>
                    <td><?php echo $codice; ?></td>
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $cognome; ?></td>
                    <td><?php echo $nazione; ?></td>
                    <td><?php echo $dataNascita; ?></td>
                    <td><?php echo $dataMorte; ?></td>
                    <td><?php echo $tipo; ?></td>
                    <td><?php echo $numeroOpere; ?></td>
                    <td><a href="opera.php?titolo=<?php echo urlencode($nomeopera); ?>"><?php echo $nomeopera; ?></a></td>

                    <td><?php echo $nomeopera; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php
      }
    } else if($mostra && !$error && $result->rowCount() > 0) { ?>
          <div>
            <button id="createButton" onclick="showCreateForm()">Creare</button>
          </div>

          <div id="createForm" style="display:none;">
            <h2>Inserimento nuovo autore</h2>
            <form id="createAuthorForm" method="post" action="insertAuthor.php" onsubmit="return validateForm()">
              <input id="codicecreate" name="codicecreate" type="text" placeholder="Codice">
              <input id="nomecreate" name="nomecreate" type="text" placeholder="Nome">
              <input id="cognomecreate" name="cognomecreate" type="text" placeholder="Cognome">
              <input id="nazionecreate" name="nazionecreate" type="text" placeholder="Nazione">
              <input id="dataNascitacreate" name="dataNascitacreate" type="text" placeholder="Data Nascita">
              <input id="dataMortecreate" name="dataMortecreate" type="text" placeholder="Data Morte">
              <input id="tipo_vivo" name="tipo" type="radio" value="vivo">
              <label for="tipo_vivo">Vivo</label>
              <input id="tipo_morto" name="tipo" type="radio" value="morto">
              <label for="tipo_morto">Morto</label>
              <input type="submit" name="insert" value="Inserisci">
            </form>
          </div>

          <table class="table">
              <tr class="header">
                  <th>Codice</th>
                  <th>Nome</th>
                  <th>Cognome</th>
                  <th>Nazione</th>
                  <th>Data Nascita</th>
                  <th>Data Morte</th>
                  <th>Tipo</th>
                  <th>Numero Opere</th>

                  <th>Modifica</th>
                  <th>Cancella</th>
              </tr>
              <?php
              foreach($result as $riga) {
                  $codice = $riga["codice"];
                  $nome = $riga["nome"];
                  $cognome  = $riga["cognome"];
                  $nazione = $riga["nazione"];
                  $dataNascita  = $riga["dataNascita"];
                  $dataMorte = $riga["dataMorte"];
                  $tipo = $riga["tipo"];
                  $numeroOpere  = $riga["numeroOpere"];

                  ?>
                  <tr>
                      <td><?php echo $codice; ?></td>
                      <td><?php echo $nome; ?></td>
                      <td><?php echo $cognome; ?></td>
                      <td><?php echo $nazione; ?></td>
                      <td><?php echo $dataNascita; ?></td>
                      <td><?php echo $dataMorte; ?></td>
                      <td><?php echo $tipo; ?></td>
                      <td><a href="opera.php?autore=<?php echo urlencode($codice); ?>"><?php echo $numeroOpere; ?></a></td>

                      <td><?php echo $numeroOpere; ?></td>


                      <td><button class="modifica-button" data-id="<?php echo $codice; ?>" onclick="showEditForm(<?php echo $codice; ?>)">Modifica</button></td>
                      <td><button class="cancella-button" data-id="<?php echo $codice; ?>" onclick="cancellaAutore(<?php echo $codice; ?>)">Cancella</button></td>
                  </tr>
                  <tr id="editFormRow<?php echo $codice; ?>" style="display: none;">
                      <td colspan="11">
                          <form id="editForm<?php echo $codice; ?>" method="post" action="editAuthor.php" onsubmit="return validateForm()">
                            <input type="hidden" name="codice" value="<?php echo $codice; ?>"> <!-- Campo nascosto per il codice -->
                        <input id="nomecreate" name="nomecreate" type="text" placeholder="Nome">
                        <input id="cognomecreate" name="cognomecreate" type="text" placeholder="Cognome">
                        <input id="nazionecreate" name="nazionecreate" type="text" placeholder="Nazione">
                        <input id="dataNascitacreate" name="dataNascitacreate" type="text" placeholder="Data Nascita">
                        <input id="dataMortecreate" name="dataMortecreate" type="text" placeholder="Data Morte"><input type="submit" name="edit" value="Modifica">
                          </form>
                      </td>
                  </tr>
              <?php } ?>
          </table>
      <?php } else {
          echo "<p>Nessun risultato trovato.</p>";
      } ?>
    </div>
  </div>



</body>
</html>
