<!--
In diesem Template wird der Login-Bereich bereitgestellt, sowie die Verlinkungen zu dem Templates newUser und lostPassword
-->﻿

<link rel="stylesheet" href="assets/stylesheets/login.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Login</label>
</div>

<form action="index.php?login" method="post" class="login">

    <!--
      Stimmt die Kombination aus Passwort und Mail-Adresse nicht überein, kann der User sich nicht anmelden
    -->﻿
    <?php if(Session::passwordfalse()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1"> Email oder Passwort ist falsch. </textarea>
        </div>
    <?php endif ?>
    <!--
      Bestätigung das ein neues Kennwort generiert und zugesandt wurde, sobald die Funktion Kennwort vergessen durchgeführt wurde
    -->﻿
    <?php if(Session::mailsend()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="successRegistration" rows="1"> Das neue Passwort wurde Ihnen zugesandt. </textarea>
        </div>
    <?php endif ?>

    <div class="loginDiv">
       <input id="username" type="text" name="username" placeholder="Email-Adresse" value=<?php echo $_REQUEST['username']?>>
       <input id="password" type="password" name="password" placeholder="Passwort">
    </div>

    <button>Login</button>
    
    <!--
    Verlinkung der beiden anderen Templates
    -->﻿
    <div class="linkDiv">
        <a href="index.php?lostPassword">Passwort vergessen?</a>
        <br>
        <a href="index.php?newUser">Neues Konto erstellen</a>
    </div>

</form>
