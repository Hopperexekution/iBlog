<?php
/*
In der Klasse Mail befinden sich Funktionen zum Versenden des neu generierten Passworts sowie eines generierten Bestätigungscodes
*/
class Mail{

/*
Über die Methode send() wird eine Mail mit einem generierten Bestätigungscode versandt
*/
  public static function send($mail){
    //Setzen aller Variablen mit den Mailinformationen
    $to = $mail;
    $subject = 'Freischaltung Ihres iBlog-Accounts';
    //generieren des Codes
    $code = Mail::generatecode($mail);
    $message = "Sie haben sich erfolgreich bei iBlog angemeldet.
                \nGeben Sie bitte den folgenden Bestätigungscode ein, um Ihre Anmeldung abzuschließen.
                \n " .Mail::generatecode($mail)."
                \nMit freundlichen Grüßen\nIhr iBlog-Team";

    //Informationen für die korrekte Darstellung
    $headers   = array();
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/plain; charset=utf-8";
    $headers[] = "From: php.iBlog@gmail.com";
    $headers[] = "Reply-To: php.iBlog@gmail.com";
    $headers[] = "X-Mailer: PHP/".phpversion();

    //Senden der Mail
    $success =  mail ( $to ,  $subject ,  $message, implode("\r\n",$headers) );
    //Speichern des Erfolgs des Mailvorgangs in Session-Variablen
    $_SESSION['mail_failed'] = !$success;
    $_SESSION['mail_send'] = $success;
  }

  /*
  Über die Methode generatecode() wird per Zufall ein Bestätigungscode generiert
  */
  public static function generatecode($mail){
    $code = mt_rand(10000000, 99999999);
    //Speichern des Codes in der Datenbank
    global $dbh;
    //Speichern des kodierten Codes in der Tabelle user
    $hash = password_hash($code, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare("UPDATE user SET code=:code WHERE mail = :mail");

    $stmt->execute(array(
        'mail'     => $mail,
        'code'     => $hash,
    ));

    return $code;
  }

  /*
  In dieser Methode wird überprüft, ober der eingegebene Bestätigungscode korrekt ist.
  */
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

  /*
  Über die Methode sendpassword() wird eine Mail mit einem generierten Password versandt
  */
  public static function sendpassword($mail){
    //Speichern der Mailinformationen in Variablen
    $to = $mail;
    $subject = 'Ihre neuen Anmeldedaten';
    $code = Mail::generatecode($mail);
    $message = "Mit dem folgenden zufällig generierten Passwort können Sie sich nun anmelden.
                \nWir empfehlen, das Passwort zeitnah zu ändern.
                \n " .Mail::generatepassword($mail)."
                \nMit freundlichen Grüßen\nIhr iBlog-Team";

    //Informationen zur korrekten Darstellung der Mail
    $headers   = array();
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/plain; charset=utf-8";
    $headers[] = "From: php.iBlog@gmail.com";
    $headers[] = "Reply-To: php.iBlog@gmail.com";
    $headers[] = "X-Mailer: PHP/".phpversion();

    //Senden der Mail
    $success =  mail ( $to ,  $subject ,  $message, implode("\r\n",$headers) );
    $_SESSION['mail_failed'] = !$success;
    $_SESSION['mail_send'] = $success;
  }
/*
In der Methode generatepassword() wird ein Passwort generiert und in der Tabelle user gespeichert
*/
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



}

?>
