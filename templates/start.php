<link rel="stylesheet" href="assets/stylesheets/home.css">

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
<form action="index.php" method="post" class="start">
    <?php if(Session::codecorrect() && Session::confirmationtried()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="successRegistration" rows="1"> Die Anmeldung wurde erfolgreich abgeschlossen. </textarea>
        </div>
    <?php endif ?>



    <?php if (!empty($articles)) foreach ($articles as $article) :?>

    <div class="titleDiv">
        <a href="index.php?article=<?php echo $article['id'] ?>" class="linkArticle">
        <div class="titleLabelDiv">
            <div class="imgUserName">
                <img src="assets/images/user-article.png" class="user-articleImg">
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
        <? endforeach ?>

    </div>
</form>
