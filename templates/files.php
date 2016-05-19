<link rel="stylesheet" href="assets/stylesheets/files.css">

<div class="sideHeaderFilesDiv">
    <label class="sideHeaderFiles">Eigene Beiträge</label>
</div>

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
              <label class="dateLabel"><?php echo date("d.m.Y - H:i", strtotime($article['date']))?><br>Thema: <?php echo $article['description'] ?></label>
          </div>
      </a>
  </div>

<?php endforeach ?>

<?php if (empty($myarticles)) :?>
    <div class="infoDiv">
        <span onclick="this.parentElement.style.display='none';">&times;</span>
        <label class="successRegistration">
            Sie haben bis jetzt noch keinen Beitrag erfasst, klicken Sie <a href="index.php?newArticle">hier</a> um einen neuen zu erstellen.
        </label>
    </div>
<?php endif ?>

