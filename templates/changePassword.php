<!--
  Über dieses Template erhält der Benutzer die Möglichkeit, sein Passwort zu ändern
-->
<link rel="stylesheet" href="assets/stylesheets/changePassword.css">

<div class="sideHeaderPasswordDiv">
    <label class="sideHeader">Passwort ändern</label>
</div>

<form action="index.php?alterPassword" method="post" class="changePassword">

  <!--
    Anzeigen einer Fehlermeldung, wenn das alte Passwort falsch eingegeben wurde
  -->
    <?php if(Session::passwordfalse()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1">Sie haben ein falsches Kennwort eingegeben.</textarea>
        </div>
    <?php endif ?>
    <!--
      Anzeigen einer Fehlermeldung, wenn das neue Passwort nicht korrekt bestätigt wurde
    -->
    <?php if(!(Session::passwordchanged()) && Session::passwordchangetried()&&!(Session::passwordtoshort())) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="2">Bitte überprüfen Sie die Eingaben Ihres neuen Passworts.</textarea>
        </div>
    <?php endif ?>
    <!--
      Anzeigen einer Fehlermeldung, wenn das neue Passwort weniger als 8 Zeichen hat
    -->
    <?php if(Session::passwordtoshort()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1">Das Passwort muss mind. 8 Zeichen lang sein.</textarea>
        </div>
    <?php endif ?>

    <div class="changePasswordDiv">
        <input id="oldpassword" type="password" name="oldpassword" placeholder="Passwort">
        <input id="password" type="password" name="password" placeholder="Neues Passwort (mind. 8 Zeichen)">
        <input id="password2" type="password" name="password2" placeholder="Neues Passwort wiederholen">
    </div>

    <button>Passwort ändern</button>

</form>
