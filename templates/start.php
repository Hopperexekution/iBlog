<link rel="stylesheet" href="assets/stylesheets/home.css">

<form action="index.php" method="post" class="start">

    <div class="sideHeaderDiv">
        <label class="sideHeader">Aktuelle Beiträge</label>

        <div class="searchBar">
            <div class="searchDiv">
                <select class="selectionBox" name="">
                    <option value="kategorie" selected="kategorie">Suchkategorie wählen...</option>
                    <option value="titel">Titel</option>
                    <option value="benutzer">Benutzer</option>
                    <option value="thema">Thema</option>
                </select>
                <input class="inputSearch" type="search" name="name" placeholder="Suchbergriff">
            </div>
            <button>Suchen</button>
        </div>
    </div>

    <?php if(Session::codecorrect() && Session::confirmationtried()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="successRegistration" rows="1"> Die Anmeldung wurde erfolgreich abgeschlossen. </textarea>
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


        </div>
        </a>
        <? endforeach ?>

    </div>
</form>
