<!--
  In dem Template werden alle Artikel des angemeldeten Benutzer angezeigt. Es ist ähnlich aufgebaut wie die Startseite
-->
<link rel="stylesheet" href="assets/stylesheets/files.css">

<div class="sideHeaderFilesDiv">
    <label class="sideHeader">Eigene Beiträge</label>
</div>

<!--
  Iterieren über alle Artikel des Benutzers, die nun der Reihe nach angezeigt werden
  Der Aufbau orientiert sich an der Startseite.
  Es wird das Bild des Users, sein Name, der Titel, das Erstellungsdatum und die Anzahl der Likes des jeweiligen Artikels ausgegeben
-->
<?php if (!empty($myarticles)) foreach ($myarticles as $article) :?>

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
              <label class="dateThemeLabel"><?php echo date("d.m.Y - H:i", strtotime($article['date']))?><br>Thema: <?php echo $article['description'] ?></label>
          </div>
      </a>
  </div>

<?php endforeach ?>

<!--
  Existiert zu dem angemeldeten Benutzer zunächst noch keine Artikel, wird auf der Seite eine Fehlermeldung ausgegeben
-->
<?php if (empty($myarticles)) :?>
    <div class="infoDiv">
        <span onclick="this.parentElement.style.display='none';">&times;</span>
        <label class="successRegistration">
            Sie haben bis jetzt noch keinen Beitrag erfasst, klicken Sie <a href="index.php?newArticle">hier</a> um einen neuen zu erstellen.
        </label>
    </div>
<?php endif ?>
