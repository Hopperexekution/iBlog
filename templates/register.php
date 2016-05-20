<!--
Template zur Aktivierung des Accounts über einen per Mail zugesandten Bestätigungscode.
-->﻿
<link rel="stylesheet" href="assets/stylesheets/register.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Email-Adresse bestätigen</label>
</div>

<form action="index.php?confirm" method = "post" class="register">

  <!--
  Fehlermeldung, falls der eingegebene Code nicht korrekt war
  -->﻿
  <?php if(!Session::codecorrect() && Session::confirmationtried()) : ?>
      <div class="infoDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <textarea class="failRegistration" rows="1"> Der eingegebene Bestätigungscode ist falsch. </textarea>
      </div>
  <?php endif ?>
  <!--
  Infomeldung, dass ein neuer Code an die dem Account hinterlegte Mail-Adresse zugesandt wurde
  -->﻿
  <?php if(Session::mailsend()) : ?>
      <div class="infoDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <textarea class="successRegistration" rows="1"> Die Mail wurde versandt. </textarea>
      </div>
  <?php endif ?>

  <div class="registerDiv">
    <input id="code" type="password" name="code" placeholder="Bestätigungscode">
  </div>

  <p class="infoCode">Die Mail wird an die folgende Mail-Adresse gesendet: <?php echo Session::getuser() ?></p>
  <button>Anmeldung abschließen</button>
</form>

<!--
Button zum erneuten Senden des Bestätigungscodes
-->﻿
<a href="index.php?sendCodeAgain"> <button class="codeAgain">Code erneut senden</button> </a>
