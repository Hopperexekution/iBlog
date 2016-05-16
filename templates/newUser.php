<link rel="stylesheet" href="assets/stylesheets/newUser.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Neues Konto erstellen</label>
</div>

<form action="index.php?register" method="post" class="newUser">

    <?php if(Session::passwordfailed()) : ?>
        <div class="failDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <label class="failRegistration"> Passwort falsch </label>
        </div>
    <?php endif ?>
    <?php if(Session::userexists()) : ?>
      <div class="failDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <label class="failRegistration"> Der User existiert bereits </label>
        </div>
    <?php endif ?>
    <?php if(Session::inputfalse()) : ?>
      <div class="failDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <textarea class="failRegistration"> <?php echo $_SESSION['error_input'] ?> </textarea>
        </div>
    <?php endif ?>

    <?php if(Session::mailfailed()===true) : ?>
        <div class="failDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <label class="failRegistration"> Die Mail konnte nicht zugestellt werden, bitte registrieren Sie sich neu. </label>
        </div>

    <?php endif ?>

    <div class="newUserDiv">
        <input id="firstname" type="text" name="firstname" placeholder="Vorname">
        <input id="lastname" type="text" name="lastname" placeholder="Nachname">
        <input id="username" type="text" name="username" placeholder="Email-Adresse">
        <input id="password" type="password" name="password" placeholder="Passwort">
        <input id="password2" type="password" name="password2" placeholder="Passwort wiederholen">

    </div>
    <button>Registrieren</button>

</form>
