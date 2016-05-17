<link rel="stylesheet" href="assets/stylesheets/profil.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Dein Profil</label>
</div>

<form action="index.php" method="post" class="profil">


    <?php if(Session::passwordchanged() && Session::passwordchangetried()) : ?>
        <div class="passwortChangeDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="successRegistration" rows="1"> Sie haben Ihr Passwort erfolgreich geändert. </textarea>
        </div>
    <?php endif ?>

    <div class="profilAction">
        <div class="allArticlesDiv">
            <a class="filesImg" href="?files=1"><img src="assets/images/files.gif"></a>
            <br>
            <label class="labelAction">Übersicht</label>
        </div>
        <div class="newArticleDiv">
            <a class="newArticleImg" href="?newArticle=1"><img src="assets/images/newArticle.png"></a>
            <br>
            <label class="labelAction">Neuer Beitrag</label>
        </div>
    </div>



</form>
