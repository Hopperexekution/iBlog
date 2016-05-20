<!--
  In diesem Template werden alle Artikel, nach ihrem Veröffentlichungs-Datum sortiert, angezeigt.
  Zusätzlich besitzt der Benutzer die Möglichkeit, die Artikel in den folgenden Kategorien zu durchsuchen:
   - Titel
   - Thema
   - Autor
   - Suche in allen Kategorien
-->﻿
<link rel="stylesheet" href="assets/stylesheets/home.css">
<!--
Formular der Suche: enthält eine SelectionBox, um zwischen verschiedenen Suchkategorien zu wählen, und ein Input-Feld für das Suchkriterium
-->﻿
<form action="index.php?search" method="post" class="start" name="search">
    <div class="sideHeaderDiv">
        <label class="sideHeader" id="sideHeader" name ="sideHeader"><?php echo Session::searched()?></label>
        <div class="searchBar">
            <div class="searchDiv">
                <select class="selectionBox" name="selectionBox">
                    <option value="allen Kategorien" selected="kategorie">Suchkategorie wählen...</option>
                    <option value="Titel">Titel</option>
                    <option value="Benutzer">Benutzer</option>
                    <option value="Thema">Thema</option>
                </select>
                <input class="inputSearch" type="search" name="inputSearch" placeholder="Suchbergriff">
            </div>

            <button>Suchen</button>
        </div>
    </div>
</form>

<div class="start">
  <!--
  Bestätigung, dass der eingegebene Bestätigungscode korrekt war und die Registrierung des Benutzers erfolgreich abgeschlossen wurde.
  -->﻿
    <?php if(Session::codecorrect() && Session::confirmationtried()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="successRegistration" rows="1"> Die Anmeldung wurde erfolgreich abgeschlossen. </textarea>
        </div>
    <?php endif ?>
    <!--
    Infomeldung, dass der Artikel gelöscht wurde
    -->﻿
    <?php if(Session::deletesuccess()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="successRegistration" rows="1"> Der Artikel wurde gelöscht. </textarea>
        </div>
    <?php endif ?>

    <!--
    Iterierung über alle Artikel.
    Es wird das Bild des Users, sein Name, der Titel, das Erstellungsdatum und die Anzahl der Likes des jeweiligen Artikels ausgegeben
    -->﻿
    <?php if (!empty($articles)) foreach ($articles as $article) :?>
        <div class="titleDiv">
            <a href="index.php?article=<?php echo $article['id'] ?>" class="linkArticle">
                <div class="titleLabelDiv">
                    <div class="imgUserName">
                        <img src="<?php echo Session::getpicext($article['user_id'])?>" class="user-articleImg">
                        <label id = "<?php echo $article['id'] ?>" class="nameUserArticle"><?php echo Session::getuserbyid($article['user_id']) ?></label>
                    </div>
                    <label class="titleLabel"><?php echo $article['title'] ?></label>

                    <div class="likeDiv">
                        <img src="assets/images/like.jpg" class="likeImg">
                        <label class="likeNumber"><?php echo Article::getLikes($article['id'])?></label>
                    </div>
                    <label class="dateLabel"><?php echo date("d.m.Y - H:i", strtotime($article['date']))?><br>Thema: <?php echo $article['description'] ?></label>

                </div>
            </a>
        </div>
    <? endforeach ?>
</div>
