<link rel="stylesheet" href="assets/stylesheets/lostPassword.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Passwort vergessen</label>
</div>

<form action="index.php?newPassword" method="post" class="lostPassword">

    <?php if(Session::mailfailed()) : ?>
        <div class="failDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <label class="failRegistration"> Die Mail konnte nicht zugesandt werden </label>
        </div>
    <?php endif ?>
    <?php if(Session::mailfalse()) : ?>
        <div class="failDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <label class="failRegistration"> Die Mailadresse ist inkorrekt </label>
        </div>
    <?php endif ?>

    <div class="lostPasswordDiv">
        <input id="email" type="text" name="email" placeholder="Email-Adresse">

        <button>Kennwort anfragen</button>
    </div>
</form>