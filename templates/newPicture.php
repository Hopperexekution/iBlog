<!--
Über dieses Template kann der eingeloggte Benutzer sein Profilbild ändern oder löschen.
-->﻿
<link rel="stylesheet" href="assets/stylesheets/newPicture.css">

<div class="sideHeaderNewPicDiv">
  <label class="sideHeaderNewPic">Profilfoto hochladen</label>
</div>
<!--
Fehlermeldung, falls der Upload des Bildes fehlgeschlagen ist.
-->﻿
<?php if(Session::uploadfailed()) : ?>
  <div class="infoDiv">
    <span onclick="this.parentElement.style.display='none';">&times;</span>
    <textarea class="failImg" rows="1"><?php echo Session::uploadfailedMsg() ?></textarea>
  </div>
<?php endif ?>
<!--
Anzeige des aktuellen Profilbildes
-->﻿
<img src="<?php echo Session::getpicext(Session::getuserid())?>" class="newPicImg">

<a href="index.php?deletepic"><button class="buttonDelete">Profilbild löschen</button></a>

<!--
Nutzen des Input-Types "File" und somit Einbindung eines Standard-File-Choosers.
-->﻿
<form action="index.php?uploadPic" class="formUpload"method="post" enctype="multipart/form-data">
  <input name="datei" type="file"/>
  <input type="submit" name="submit" value="Hochladen" class="buttonUpload"/>
</form>
