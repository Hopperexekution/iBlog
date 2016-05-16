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


      </div>
      </a>
      <? endforeach ?>
</form>
