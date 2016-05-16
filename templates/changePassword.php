<link rel="stylesheet" href="assets/stylesheets/changePassword.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Passwort ändern</label>
</div>

<form action="index.php?alterPassword" method="post" class="changePassword">

    <?php if(Session::passwordfalse()) : ?>
        <div class="failDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <label class="failRegistration"> Sie haben ein falsches Kennwort eingegeben </label>
        </div>
    <?php endif ?>
    <?php if(!(Session::passwordchanged()) && Session::passwordchangetried()) : ?>
        <div class="failDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <label class="failRegistration"> Bitte überprüfen Sie die Eingaben Ihres neuen Passworts </label>
        </div>
    <?php endif ?>

    <div class="changePasswordDiv">
        <input id="oldpassword" type="password" name="oldpassword" placeholder="Passwort">
        <input id="password" type="password" name="password" placeholder="Neues Passwort">
        <input id="password2" type="password" name="password2" placeholder="Neues Passwort wiederholen">
    </div>

    <button>Passwort ändern</button>

</form>