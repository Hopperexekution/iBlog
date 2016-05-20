<!DOCTYPE HTML>
<html>
<!--
In diesem Template befindet sich der Rahmen der Anwendung. Die Inhalte können in der index.php ausgetauscht werden.
-->﻿
 <head>
     <title> iBlog </title>
     <meta charset="utf-8">
     <!--
     Hier werden die benötigten Stylesheets (CSS), die für alle Templates gelten, eingebunden. Darunter befindet sich auch das Stylesheet des widgEditor.
     Anschließend wird das Script des widgEditor eingebunden.
     -->﻿
     <link rel="stylesheet" href="assets/stylesheets/stylesheet.css">
     <link rel="stylesheet" href="assets/stylesheets/header.css">
     <link rel="stylesheet" href="widgEditor/css/widgEditor.css">
     <script src="widgEditor/scripts/widgEditor.js"></script>
 </head>
 <body>
     <div class="page">
         <header>
             <h1 class="sideHeading">iBlog</h1>
             <a class="home" href="?home=1"><img src="assets/images/home.png"></a>
             <!--
             Ist der Benutzer angemeldet, werden diverse Elemente in den Rahmen eingebunden:
             - Profilbild
             - Username
             - Logout-Button
             - Einstellungs-Button
             -->﻿
             <?php if (Session::authenticated()) : ?>
                 <img src="<?php echo Session::getpicext(Session::getuserid())?>" class="userImgLogin">
                 <label id="profilname" class="userLogin"><?php echo Session::getuserbyid(Session::getuserid())?></label>

                 <div class="tooltip">
                     <a class="logout" href="?logout=1"><img src="assets/images/logout.png"></a>
                     <span class="tooltiptext">Logout</span>
                 </div>
                 <a class="setting" href="?setting=1"><img src="assets/images/setting.png">
                    <li class="settings">
                         <ul class="subMenu">
                             <li class="subMenu"><a href="index.php?profil">Profil</a></li>
                             <li class="subMenu"><a href="index.php?changePassword">Passwort ändern</a></li>
                         </ul>
                    </li>
                </a>
             <?php endif ?>
             <!--
             Ist der Benutzer nicht angemeldet, wird ein Login-Button angezeigt
             -->﻿
             <?php if (!Session::authenticated()) : ?>
                 <div class="tooltip">
                     <a class="login" href="?login=1"><img src="assets/images/white-login.png"></a>
                     <span class="tooltiptext">Login</span>
                 </div>
             <?php endif ?>
         </header>
         <!--
         An dieser Stelle kann der Inhalt gewechselt werden beziehungsweise werden die anderen Templates eingebunden.
         -->﻿
         <main>
             <?= $content_for_layout ?>
         </main>
     </div>
 </body>
</html>
