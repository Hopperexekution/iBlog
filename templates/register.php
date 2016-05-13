<link rel="stylesheet" href="assets/stylesheets/register.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Email-Adresse bestätigen</label>
</div>

<form action="index.php?confirm" method = "post" class="register">

  <?php if(!Session::codecorrect() && Session::confirmationtried()) : ?>
      <div class="failDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <label class="failRegistration"> Der eingegebene Bestätigungscode ist falsch </label>
      </div>
  <?php endif ?>
  <?php if(Session::mailsend()) : ?>
      <div class="mailSendDiv">
          <span onclick="this.parentElement.style.display='none';">&times;</span>
          <label class="successRegistration"> Die Mail wurde versandt </label>
      </div>
  <?php endif ?>
    <div class="registerDiv">
        <input id="code" type="code" name="code" placeholder="Bestätigungscode">
    </div>

        <p class="infoCode">Die Mail wird an die folgende Mail-Adresse gesendet: <?php echo Session::getuser() ?></p>
        <button>Anmeldung abschließen</button>
      </form>

        <a href="index.php?sendCodeAgain"> <button>Code erneut senden</button> </a>
