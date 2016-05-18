<meta charset="utf-8">

<?php

class Mail{

  public static function send($mail){
    $to = $mail;
    $subject = 'Freischaltung Ihres iBlog-Accounts';
    $code = Mail::generatecode($mail);
    $message = "Sie haben sich erfolgreich bei iBlog angemeldet.
                \nGeben Sie bitte den folgenden Bestätigungscode ein, um Ihre Anmeldung abzuschließen.
                \n " .Mail::generatecode($mail)."
                \nMit freundlichen Grüßen\nIhr iBlog-Team";
    $success =  mail ( $to ,  $subject ,  $message );
    $_SESSION['mail_failed'] = !$success;
    $_SESSION['mail_send'] = $success;
  }
  public static function sendpassword($mail){
    $to = $mail;
    $subject = 'Ihre neuen Anmeldedaten';
    $code = Mail::generatecode($mail);
    $message = "Mit dem folgenden zufällig generierten Passwort können Sie sich nun anmelden.
                \nWir empfehlen, das Passwort zeitnah zu ändern.
                \n " .Mail::generatepassword($mail)."
                \nMit freundlichen Grüßen\nIhr iBlog-Team";
    $success =  mail ( $to ,  $subject ,  $message );
    $_SESSION['mail_failed'] = !$success;
    $_SESSION['mail_send'] = $success;
  }

  public static function generatecode($mail){
    $code = mt_rand(10000000, 99999999);
    //Speichern des Codes in der Datenbank
    global $dbh;
    $hash = password_hash($code, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare("UPDATE user SET code=:code WHERE mail = :mail");

    $stmt->execute(array(
        'mail'     => $mail,
        'code'     => $hash,
    ));
    return $code;
  }
  public static function generatepassword($mail){
    $password = mt_rand(10000000, 99999999);
    //Speichern des Codes in der Datenbank
    global $dbh;
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $dbh->prepare("UPDATE user SET password=:password WHERE mail = :mail");

    $stmt->execute(array(
        'mail'     => $mail,
        'password'     => $hash,
    ));
    return $password;
  }


  public static function checkcode($code){
    $mail = Session::getuser();
    $_SESSION['confirmation_tried']=true;

    global $dbh;

    $stmt = $dbh->prepare("SELECT code FROM user
            WHERE mail = :user");

    $stmt->execute(array(
        'user'     => $mail,
    ));

    $hash = $stmt->fetchColumn();

    if (password_verify($code, $hash)){
      $_SESSION['code_correct'] = true;
      return true;
    }else{
      $_SESSION['code_correct'] = false;
      return false;
    }
  }
}

?>
