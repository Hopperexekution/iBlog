
<?php
/*
In der Session befinden sich alle Methoden, die sich auf die Session beziehen und Schnittpunkte zum User besitzen
*/
class Session {

  /*
  In der Methode check_credentials() wird überprüft, ob die Anmeldedaten korrekt sind
  */
    public static function check_credentials($mail, $password)
    {
        global $dbh;

        //Passwort zu der angegebenen Mail-Adresse auslesen
        $stmt = $dbh->prepare("SELECT password FROM user
            WHERE mail = :user");

        $stmt->execute(array(
            'user'     => $mail,
        ));

        $hash = $stmt->fetchColumn();

        //Prüfen des angegebenen Passworts, und ob der Benutzer freigeschaltet ist
        if (password_verify($password, $hash) && Session::userunlocked($mail)) {
          //Session-Variablen setzen (Indikatoren dafür, dass der Benutzer vollständig eingeloggt ist)
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $mail;
            $_SESSION['password_false'] = false;
            // create new session_id
            session_regenerate_id(true);

            return true;
            //Anmeldedaten sind korrekt, aber der Benutzer ist nicht freigeschaltet
        }elseif(password_verify($password, $hash)){
            $_SESSION['password_false'] = false;
            $_SESSION['user'] = $mail;

            return true;
          //Die Anmeldedaten sind nicht korrekt
        }else{
        $_SESSION['password_false'] = true;

        return false;
      }
    }
/*
In dieser Methode wird der Benutzer ausgeloggt
*/
    public static function logout()
    {
        // destroy old session
        session_destroy();

        // immediately start a new one
        session_start();

        // create new session_id
        session_regenerate_id(true);

        //Timeout, währenddessen die Bilder geladen werden können
        ?><script language="JavaScript" type="text/javascript">
        setTimeout("location.href='index.php?home=1'", 1); //1 Millisekunde
        </script> <?
    }

/*
Methode zum Hinzufügen eines Users
*/
    public function create_user($firstname, $lastname, $mail, $password, $password2){
        unset($_SESSION['error_input']);

        //Überprüfen der Eingabedaten
      if(empty($firstname)){
        $_SESSION['error_input'] .= "Bitte einen Vornamen angeben.\n";
      }
      if(empty($lastname)){
        $_SESSION['error_input'] .= "Bitte einen Nachnamen angeben.\n";
      }
      if(empty($mail)){
        $_SESSION['error_input'] .= "Bitte eine gültige Mailadresse angeben.\n";
      }
      if(empty($password)){
        $_SESSION['error_input'] .= "Bitte ein Passwort angeben.\n";
      }
      if(strlen($password)<8){
        $_SESSION['error_input'] .= "Das Passwort muss mind. 8 Zeichen lang sein.\n";
      }
      //Prüfen, ob die Daten korrekt waren
      if(!isset($_SESSION['error_input'])){
        // user does not yet exists, create it
        if (!Session::checkmail($mail)) {
            $_SESSION['user_exists'] = false;
            //Prüfen, ob das Passwort korrekt bestätigt wurde
            if($password == $password2) {
              global $dbh;
            $_SESSION['password_fail'] = false;
            //Hinzufügen des Users in die Tabelle user
            $stmt2 = $dbh->prepare("INSERT INTO user (lastname, firstname, mail, password)
                VALUES (:lastname, :firstname, :mail, :password)");

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt2->execute(array(
                'lastname' => $lastname,
                'firstname'=> $firstname,
                'mail'     => $mail,
                'password' => $hash
            ));

            $_SESSION['user'] = $mail;
            // create new session_id
            session_regenerate_id(true);

            } else {
                $_SESSION['password_fail'] = true;
                $_SESSION['logged_in'] = false;
            }
        } else {
            $_SESSION['user_exists'] = true;
            $_SESSION['logged_in'] = false;
        }
      }

    }

/*
Über diese Methode lässt sich ein soeben hinzugefügter User wieder aus der Tabelle user entfernen.
Die Methode wird aufgerufen, wenn die Bestätigungsmail nicht zugesandt werden konnte
*/
    public function removeuser($mail){
      global $dbh;

      $stmt = $dbh->prepare("DELETE FROM user
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => $mail
      ));
    }

/*
Die Methode getuserid() liefert die ID des gerade angemeldeten Benutzers zurück
*/
    public static function getuserid(){
      global $dbh;

      $stmt = $dbh->prepare("SELECT id FROM user
          WHERE mail = :user");

      $stmt->execute(array(
          'user'     => Session::getuser(),
      ));

      $id = $stmt->fetchColumn();
      return $id;
    }

    /*
    Die Methode getuserbyid() liefert den Benutzernamen mit der übergebenen id zurück
    */
    public static function getuserbyid($id){
      global $dbh;

      $stmt = $dbh->prepare("SELECT CONCAT(CONCAT(firstname, ' '), lastname) FROM user
          WHERE id = :id");

      $stmt->execute(array(
          'id'     => $id,
      ));

      $user = $stmt->fetchColumn();

      if($user == NULL){
            return "User unbekannt";
      }
      return $user;
    }

    /*
    Die Methode userunlocked() prüft, ob der Benutzer mit der übergebenen Mail-Adresse freigeschaltet ist
    */
    public static function userunlocked($mail){

      global $dbh;

      $stmt = $dbh->prepare("SELECT COUNT(*) FROM user
          WHERE mail = :mail AND unlocked=true");

      $stmt->execute(array(
          'mail'     => $mail
      ));

      if ($stmt->fetchColumn() == 1){
        $_SESSION['unlocked'] = true;
        return true;
      }else{
        $_SESSION['unlocked'] = false;
        return false;
      }
    }

/*
Die Methode activateuser() schaltet den angemeldeten Benutzer über ein UPDATE auf die Spalte unlocked der Tabelle user frei.
*/
    public function activateuser(){
      global $dbh;

      $stmt = $dbh->prepare("UPDATE user SET unlocked=true
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => Session::getuser()
      ));

    }

    /*
    Die Methode checkmail() prüft, ob bereits ein Benutzer mit der übergebenen Mail-Adresse registriert ist
    */
    public function checkmail($mail){
      global $dbh;
      $stmt = $dbh->prepare("SELECT COUNT(*) FROM user
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => $mail
      ));

      if ($stmt->fetchColumn() == 1){
        $_SESSION['mail_false']=false;
        return true;
      }else{
        $_SESSION['mail_false']=true;
        return false;
      }
    }

    /*
    Die Methode changePassword() ermöglicht das Ändern des Passwortes
    */
    public function changePassword($password, $password2){
      $_SESSION['password_change_tried']=true;
      //Prüfen, ob die Angaben zum neuen Passwort korrekt sind
      if($password == $password2&&!empty($password)){
        if(strlen($password)>7){
          global $dbh;
          $hash = password_hash($password, PASSWORD_DEFAULT);
          //Speichern des neuen Passwortes
          $stmt = $dbh->prepare("UPDATE user SET password=:password
              WHERE mail = :mail");

              $stmt->execute(array(
                'password'     => $hash,
                'mail'     => Session::getuser()
              ));
          $_SESSION['password_changed']=true;
          return true;
        }else{
          $_SESSION['password_to_short']=true;
          return false;
        }
      }else{
        $_SESSION['password_changed']=false;
        return false;
      }
    }
/*
Über diese Funktion lösst sich ein Account löschen
*/
    public static function deleteUser(){
      //Löschen des Profilbildes
        if (Session::getpicext(Session::getuserid())!="images/profilepics/user.png"){
            unlink($_SESSION['workingdirectory']."/".Session::getpicext(Session::getuserid()));
        }

        global $dbh;

        //Löschen des Users
      $stmt = $dbh->prepare("DELETE FROM user
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => Session::getuser()
      ));
      $_SESSION['deleteuser_success']=true;
    }

    /*
    Über diese Funktion lösst sich ein Account mitsamt seiner Likes, Kommentare und Artikel löschen
    */
    public static function deleteUserArticle(){
      //Löschen des Profilbildes
      $picpath = Session::getpicext(Session::getuserid());
        if ($picpath!="images/profilepics/user.png"){
            unlink($_SESSION['workingdirectory']."/".$picpath);
        }

        $id=Session::getuserid();

      global $dbh;

      //Löschen aller Kommentare des Benutzers
      $stmt = $dbh->prepare("DELETE FROM comment
          WHERE user_id = :id");

      $stmt->execute(array(
          'id'     => $id
      ));

      //Löschen aller Likes des Benutzers
      $stmt = $dbh->prepare("DELETE FROM user_likes_article
          WHERE user_id = :id");

      $stmt->execute(array(
          'id'     => $id
      ));

      //Löschen aller Artikel des Benutzers
      $stmt = $dbh->prepare("DELETE FROM article
          WHERE user_id = :id");

      $stmt->execute(array(
          'id'     => $id
      ));

      //Löschen des Benutzers
      $stmt = $dbh->prepare("DELETE FROM user
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => Session::getuser()
      ));

      $_SESSION['deleteuser_success']=true;
    }
    /*
    Über diese Funktion lösst sich das ausgewählte Bild speichern
    */
    public static function savePic(){
      if(array_key_exists('datei', $_FILES)) {
        //Auslesen der Datei-Informationen
      $filepath = $_SESSION['workingdirectory']."/images/profilepics/";
      $filename = pathinfo($_FILES['datei']['name'], PATHINFO_FILENAME);
      $extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));

      $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
      //Prüfen der Dateiendung
      if(!in_array($extension, $allowed_extensions)) {
         $_SESSION['uploadfailed']="Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt.";

       }else{
         $max_size = 10*1024*1024; //10 MB

         //Prüfen der Dateigröße
         if($_FILES['datei']['size'] > $max_size) {
            $_SESSION['uploadfailed']="Bitte keine Dateien größer 10MB hochladen.";

          }else{
            $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detected_type = exif_imagetype($_FILES['datei']['tmp_name']);

            //Prüfen des Dateityps
            if(!in_array($detected_type, $allowed_types)) {
              $_SESSION['uploadfailed']="Nur der Upload von Bilddateien ist gestattet.";

             }else{
               $new_path = $filepath.Session::getuserid().'.'.$extension;
               //Prüfen, ob der Benutzer bereits ein Profilbild besitzt
               if (Session::getpicext(Session::getuserid())!="images/profilepics/user.png"){
                 //Löschen des alten Profilbildes
                 unlink($_SESSION['workingdirectory']."/".Session::getpicext(Session::getuserid()));
               }
               //Speichern des Bildes
               move_uploaded_file($_FILES['datei']['tmp_name'],$new_path);
             }
           }
         }
      }
    }

    /*
    Die Methode getpicext() gibt den Pfad des Profilbides des Benutzers mit der übergebenen ID zurück
    */
    public static function getpicext($user_id){
      //Prüfen der Dateiendung
      if(file_exists($_SESSION['workingdirectory']."/images/profilepics/".$user_id.".png"))
      {
        return "images/profilepics/".$user_id.".png";
      }
      elseif (file_exists($_SESSION['workingdirectory']."/images/profilepics/".$user_id.".jpeg")) {
        return "images/profilepics/".$user_id.".jpeg";
      }
      elseif (file_exists($_SESSION['workingdirectory']."/images/profilepics/".$user_id.".gif")) {
        return "images/profilepics/".$user_id.".gif";
      }
      elseif (file_exists($_SESSION['workingdirectory']."/images/profilepics/".$user_id.".jpg")) {
        return "images/profilepics/".$user_id.".jpg";
      }
      else{
        //Es existiert bisher kein Profilbildes
        //Rückgabe des Standardbildes
        return "images/profilepics/user.png";
      }
    }
    /*
    Über diese Funktion lösst sich das Profilbild des angemeldeten Benutzers löschen
    */
    public static function deletePic(){
      if (Session::getpicext(Session::getuserid())!="images/profilepics/user.png"){
        unlink($_SESSION['workingdirectory']."/".Session::getpicext(Session::getuserid()));
      }
    }

    /*
    Die folgenden Methoden geben den Inhalt der genutzten Session-Variablen zurück
    */
    public static function mailfailed() {
        return ($_SESSION['mail_failed'] === true);
    }

    public static function authenticated()
    {
        return ($_SESSION['logged_in'] === true);
    }

    public static function codecorrect() {
        return ($_SESSION['code_correct'] === true);
    }

    public static function passwordfailed() {
        return ($_SESSION['password_fail'] === true);
    }

    public static function passwordfalse() {
        return ($_SESSION['password_false'] === true);
    }

    public static function userexists() {
        return ($_SESSION['user_exists'] === true);
    }
    public static function getuser(){
      return $_SESSION['user'];
    }
    public static function mailfalse(){
      return ($_SESSION['mail_false']===true);
    }
    public static function passwordchanged(){
      return ($_SESSION['password_changed']===true);
    }
    public static function passwordchangetried(){
      return ($_SESSION['password_change_tried']===true);
    }
    public static function passwordtoshort(){
      return ($_SESSION['password_to_short']===true);
    }
    public static function confirmationtried(){
      return($_SESSION['confirmation_tried']===true);
    }
    public static function mailsend(){
      return($_SESSION['mail_send']===true);
    }
    public static function inputfalse(){
      return(isset($_SESSION['error_input']));
    }
    public static function uploadfailed(){
      return(isset($_SESSION['uploadfailed']));
    }
    public static function uploadfailedMsg(){
      return ($_SESSION['uploadfailed']);
    }
    public static function searched(){
      return($_SESSION['search']);
    }
    public static function getArticleId(){
      return($_SESSION['article_id']);
    }
    public static function commentempty(){
      return($_SESSION['comment_empty']===true);
    }
    public static function deletesuccess(){
      return($_SESSION['delete_success']===true);
    }
    public static function deleteusersuccess(){
      return($_SESSION['deleteuser_success']===true);
    }
    public static function getunlocked(){
      return ($_SESSION['unlocked']===true);
    }


}
