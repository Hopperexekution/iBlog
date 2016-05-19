<link rel="stylesheet" href="assets/stylesheets/profil.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Dein Profil</label>
</div>

<?php if(Session::passwordchanged() && Session::passwordchangetried()) : ?>
    <div class="passwortChangeDiv">
        <span onclick="this.parentElement.style.display='none';">&times;</span>
        <textarea class="successRegistration" rows="1"> Sie haben Ihr Passwort erfolgreich geändert. </textarea>
    </div>
<?php endif ?>

<div class="profilAction">
    <div class="profilActionDiv">
        <a class="profilActionImg" href="index.php?files"><img src="assets/images/files.gif"></a>
        <br>
        <label class="labelAction">Übersicht</label>
    </div>

    <div class="profilActionDiv">
        <a class="profilActionImg" href="index.php?newArticle"><img src="assets/images/newArticle.png"></a>
        <br>
        <label class="labelAction">Neuer Beitrag</label>
    </div>

    <div class="profilActionDiv">
        <a class="profilActionImg" href="index.php?newPic"><img src="assets/images/camera.png"></a>
        <br>
        <label class="labelAction">Neues Profilfoto</label>
    </div>

    <div class="profilActionDiv">
        <a class="profilActionImg" href="index.php?deleteUser" onclick="return confirm('Wollen Sie Ihren Account wirklich löschen?\nIhre Beiträge bleiben bestehen.');"><img src="assets/images/deleteUser.png"></a>
        <br>
        <label class="labelAction">User löschen</label>
    </div>

    <div class="profilActionDiv">
        <a class="profilActionImg" href="index.php?deleteUserArticle" onclick="return confirm('Wollen Sie Ihren Account wirklich löschen?\nIhre Beiträge werden ebenfalls entfernt.');"><img src="assets/images/deleteUserArticle.png"></a>
        <br>
        <label class="labelAction">User und Beiträge löschen</label>
    </div>
    
</div>
