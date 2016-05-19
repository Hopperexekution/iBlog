<link rel="stylesheet" href="assets/stylesheets/lostPassword.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Passwort vergessen</label>
</div>

<form action="index.php?newPassword" method="post" class="lostPassword">

    <?php if(Session::mailfailed()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1"> Die Mail konnte nicht zugesandt werden. </textarea>
        </div>
    <?php endif ?>

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
