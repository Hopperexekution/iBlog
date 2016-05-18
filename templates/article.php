<link rel="stylesheet" href="assets/stylesheets/article.css">



  <div class="sideHeaderDiv">
    <label class="sideHeader"><?php echo $article['title'] ?></label>

      <?php if (Session::authenticated() && Session::getuserid()==$article['user_id']): ?>
          <a href="?editOldArticle"><img src="assets/images/edit.jpg" class="userArticleEdit"></a>
      <?php endif ?>

      <img src="assets/images/user.png" class="userArticle">
      <label class="owner"><?php echo Session::getuserbyid($article['user_id'])?></label>
  </div>

<form action="index.php?saveComment" method="post" class="article">
  <div class="singleArticle">
      <div class="textareaRead">
          <textbox  ><?php echo $article['text'] ?></textbox>
      </div>
      <label class="dateLabel"><?php echo date("d.m.Y - H:i", strtotime($article['date']))?></label>


    <div class="commments">


        <?php if (!empty($comments)) : ?>
           <label class="titleComment">Kommentare</label>
          <?php foreach ($comments as $comment) :?>

        <div class="commentsarea">
          <img src="assets/images/user-article.png" class="user-articleImg">
          <label class="nameUserArticle"><?php echo Session::getuserbyid($comment['user_id'])?></label>
          <label class="dateLabel"><?php echo date("d.m.Y - H:i", strtotime($comment['date']))?></label>
          <textarea readonly class="textareaReadComment" rows="3"><?php echo $comment[nl2br('text')] ?></textarea>
        </div>

        <? endforeach ?>
        <?php endif ?>
      </div>

      <?php if(Session::authenticated()) :?>
        <div class="commentsarea">
          <img src="assets/images/user-article.png" class="user-articleImg">
          <label class="nameUserArticle"><?php echo Session::getuserbyid(Session::getuserid()) ?></label>
          <textarea id="textareaComment" name="textareaComment" class="textareaReadComment" placeholder="Füge hier ein Kommentar hinzu..." rows="3"></textarea>
        </div>

        <a href="index.php?saveComment"> <button>Kommentar speichern</button> </a>
      <?php endif ?>
    </div>


</form>
