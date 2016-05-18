<link rel="stylesheet" href="assets/stylesheets/newUser.css">
<meta charset="utf-8">
<div class="sideHeaderDiv">
    <label class="sideHeader">Neues Konto erstellen</label>
</div>

<form action="index.php?register" method="post" class="newUser">

    <?php if(Session::passwordfailed()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1"> Passwörter stimmen nicht überein! </textarea>
        </div>
    <?php endif ?>
    <?php if(Session::userexists()) : ?>
      <div class="infoDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <textarea class="failRegistration" rows="1"> Der User existiert bereits. </textarea>
        </div>
    <?php endif ?>
    <?php if(Session::inputfalse()) : ?>
      <div class="infoDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <textarea class="failRegistration" rows= "1"><?php echo $_SESSION['error_input'] ?></textarea>
        </div>
    <?php endif ?>

    <?php if(Session::mailfailed()===true) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="2"> Die Mail konnte nicht zugestellt werden, bitte registrieren Sie sich neu. </textarea>
        </div>

    <?php endif ?>

    <div class="newUserDiv">
        <input id="firstname" type="text" name="firstname" placeholder="Vorname" value=<?php echo $_REQUEST['firstname']?>>
        <input id="lastname" type="text" name="lastname" placeholder="Nachname" value=<?php echo $_REQUEST['lastname']?>>
        <input id="username" type="text" name="username" placeholder="Email-Adresse" value=<?php echo $_REQUEST['username']?>>
        <input id="password" type="password" name="password" placeholder="Passwort">
        <input id="password2" type="password" name="password2" placeholder="Passwort wiederholen">

    </div>
    <button>Registrieren</button>

</form>
