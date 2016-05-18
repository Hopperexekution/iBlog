<div class="sideHeaderDiv">
    <label class="sideHeader">Eigene Beiträge</label>
</div>

<form action="index.php" method="post" class="files">

  <?php if (!empty($myarticles)) foreach ($myarticles as $article) :?>

  <div class="titleDiv">
      <a href="index.php?article=<?php echo $article['id'] ?>" class="linkArticle">
      <div class="titleLabelDiv">
          <div class="imgUserName">
              <img src="assets/images/user-article.png" class="user-articleImg">
              <label id = "<?php echo $article['id'] ?>" class="nameUserArticle"><?php echo Session::getuserbyid($article['user_id']) ?></label>
          </div>
          <label class="titleLabel"><?php echo $article['title'] ?></label>
          <div>
              <img src="assets/images/like.jpg" class="likeImg">
              <label><?php echo Article::getLikes($article['id'])?></label>
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



</form>
