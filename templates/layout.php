<!DOCTYPE HTML>
<html>
 <head>
     <title> iBlog </title>
     <meta charset="utf-8">
     <link rel="stylesheet" href="assets/stylesheets/stylesheet.css">
     <link rel="stylesheet" href="assets/stylesheets/header.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
 </head>
 <body>
     <div class="page">
         <header>
             <h1>iBlog</h1>
             <a class="home" href="?home=1"><img src="assets/images/home.png"></a>
             <?php if (Session::authenticated()) : ?>
                 <img src="assets/images/user.png" class="userImgLogin">
                 <label id="profilname" class="userLogin"></label>
                 <script type="text/javascript">
                     document.getElementById("profilname").innerHTML = "<?php echo $_SESSION['user']?>";
                 </script>
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

             <?php if (!Session::authenticated()) : ?>
                 <div class="tooltip">
                     <a class="login" href="?login=1"><img src="assets/images/white-login.png"></a>
                     <span class="tooltiptext">Login</span>
                 </div>
             <?php endif ?>


         </header>
         <main>
             <?= $content_for_layout ?>
         </main>
     </div>
 </body>
</html>
