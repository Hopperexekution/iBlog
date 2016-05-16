<link rel="stylesheet" href="assets/stylesheets/login.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Login</label>
</div>

<form action="index.php?login" method="post" class="login">

    <?php if(Session::passwordfalse()) : ?>
    <div class="failDiv">
        <span onclick="this.parentElement.style.display='none';">&times;</span>
        <label class="failRegistration"> Email oder Passwort ist falsch </label>
    </div>
    <?php endif ?>
    <?php if(Session::mailsend()) : ?>
    <div class="mailPasswordDiv">
        <span onclick="this.parentElement.style.display='none';">&times;</span>
        <label class="mailPassword"> Die Mail mit dem neuen Password wurde Ihnen zugesandt </label>
    </div>
    <?php endif ?>

    <div class="loginDiv">
       <input id="username" type="text" name="username" placeholder="Email-Adresse">
       <input id="password" type="password" name="password" placeholder="Passwort">
    </div>

    <button>Login</button>

    <div class="linkDiv">
        <a href="index.php?lostPassword">Passwort vergessen?</a>
        <br>
        <a href="index.php?newUser">Neues Konto erstellen</a>
    </div>

</form>
