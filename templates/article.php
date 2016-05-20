
<link rel="stylesheet" href="assets/stylesheets/article.css">

  <div class="sideHeaderDiv">
    <label class="sideHeader"><?php echo $article['title']?></label>
      <img class="userArticle" src="assets/images/user.png">
      <label class="owner"><?php echo Session::getuserbyid($article['user_id'])?></label>

    <?php if (Session::authenticated() && (Session::getuserid()==$article['user_id'])): ?>
        <a href="index.php?editOldArticle"><img src="assets/images/edit.jpg" class="userArticleEdit"></a>
        <a href="index.php?deleteArticle" onclick="return confirm('Wollen Sie diesen Beitrag wirklich unwideruflich löschen?');"><img src="assets/images/bin.png" class="userArticleBin"></a>
    <?php endif ?>
  </div>

  <div class="singleArticle">
      <div class="textareaRead">
          <textbox><?php echo htmlspecialchars_decode($article['text']) ?></textbox>
      </div>
      <label class="dateLabel"><?php echo date("d.m.Y - H:i", strtotime($article['date']))?></label>
      <div class="likeDiv">
          <?php if(Article::likeable(Session::getArticleId(), Session::getuserid())):?>
            <a href="index.php?like"><img src="assets/images/like.jpg" class="likeImg"></a>
          <?php else :?>
            <img src="assets/images/like.jpg" class="noLikeImg">
          <?php endif ?>
          <label class="likeNumber"><?php echo Article::getLikes($article['id'])?></label>
      </div>

      <form action="index.php?saveComment" method="post" class="article">
        <div class="commments">
            <?php if (!empty($comments) || Session::authenticated()) : ?>
                <label class="titleComment">Kommentare</label>
                <?php if(Session::commentempty()) : ?>
                    <div class="infoDiv">
                       <span onclick="this.parentElement.style.display='none';">&times;</span>
                       <textarea class="failRegistration" rows="1">Bitte den Kommentar mit Text füllen.</textarea>
                    </div>
                <?php endif ?>

                <?php foreach ($comments as $comment) :?>
                    <div class="commentsarea">
                        <img src="<?php echo Session::getpicext($comment['user_id'])?>" class="user-articleImg">
                        <label class="nameUserArticle"><?php echo Session::getuserbyid($comment['user_id'])?></label>
                      <label class="dateLabel"><?php echo date("d.m.Y - H:i", strtotime($comment['date']))?></label>
                      <textarea readonly class="textareaReadComment" rows="3"><?php echo $comment[nl2br('text')] ?></textarea>
                    </div>
                <? endforeach ?>
            <?php endif ?>
        </div>

        <?php if(Session::authenticated()) :?>
            <div class="commentsarea">
                <img src="<?php echo Session::getpicext(Session::getuserid())?>" class="user-articleImg">
                <label class="nameUserArticle"><?php echo Session::getuserbyid(Session::getuserid()) ?></label>
              <textarea id="textareaComment" name="textareaComment" class="textareaReadComment" placeholder="Füge hier ein Kommentar hinzu..." rows="3"></textarea>
            </div>
            <button>Kommentar speichern</button>
        <?php endif ?>
      </form>
  </div>
