<!--
In diesem Template kann der Benutzer sich ein neues Passwort generieren lassen und an seine Mail
zusenden.
-->﻿
<link rel="stylesheet" href="assets/stylesheets/lostPassword.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Passwort vergessen</label>
</div>

<form action="index.php?newPassword" method="post" class="lostPassword">
  <!--
  Der Nutzer wird darüber informiert, falls die Mail fehlgeschlagen ist
  -->﻿
    <?php if(Session::mailfailed()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1"> Die Mail konnte nicht zugesandt werden. </textarea>
        </div>
    <?php endif ?>

    <!--
    Ist die Mail nicht korrekt, bekommt der Benutzer die Fehlermeldung zurück, dass diese nicht zugestellt werden konnte
    -->﻿
    <?php if(Session::mailfalse()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1"> Die Mailadresse ist inkorrekt. </textarea>
        </div>
    <?php endif ?>

    <div class="lostPasswordDiv">
        <input id="email" type="text" name="email" placeholder="Email-Adresse">
        <button>Kennwort anfragen</button>
    </div>
</form>
