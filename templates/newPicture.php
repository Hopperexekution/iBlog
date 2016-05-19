<link rel="stylesheet" href="assets/stylesheets/newPicture.css">

<div class="sideHeaderNewPicDiv">
  <label class="sideHeaderNewPic">Profilfoto hochladen</label>
</div>

<?php if(Session::uploadfailed()) : ?>
  <div class="infoDiv">
    <span onclick="this.parentElement.style.display='none';">&times;</span>
    <textarea class="failImg" rows="1"><?php echo Session::uploadfailedMsg() ?></textarea>
  </div>
<?php endif ?>
<img src="<?php echo Session::getpicext(Session::getuserid())?>" class="newPicImg">


<form action="index.php?uploadPic" method="post" enctype="multipart/form-data">
  <input name="datei" type="file"/>
  <input type="submit" name="submit" value="Hochladen" class="buttonUpload"/>
</form>
