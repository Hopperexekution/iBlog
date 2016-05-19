<link rel="stylesheet" href="assets/stylesheets/editOldArticle.css">

<div class="sideHeaderOldArticleDiv">
    <label class="sideHeaderOldArticle"><?php echo $article['title'] ?></label>
</div>
<?php if(Session::inputfalse()) : ?>
    <div class="infoDiv">
        <span onclick="this.parentElement.style.display='none';">&times;</span>
        <textarea class="failRegistration" rows="1"><?php echo $_SESSION['error_input'] ?></textarea>
    </div>
<?php endif ?>

<form action="index.php?updateArticle" method="post" class="editOldArticle">
    <div class="singleArticle">
        <textarea id="widgEditor" name="widgEditor" class="widgEditor"><?php echo $article['text']?></textarea>
        <button>Speichern</button>
    </div>

</form>
