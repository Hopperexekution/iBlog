
<?php

class Session {
    public static function check_credentials($mail, $password)
    {
        global $dbh;

        $stmt = $dbh->prepare("SELECT password FROM user
            WHERE mail = :user");

        $stmt->execute(array(
            'user'     => $mail,
        ));

        $hash = $stmt->fetchColumn();

        if (password_verify($password, $hash) && Session::userunlocked($mail)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $mail;
            $_SESSION['password_false'] = false;
            // create new session_id
            session_regenerate_id(true);

            return true;
        }elseif(password_verify($password, $hash)){
          $_SESSION['password_false'] = false;
            $_SESSION['user'] = $mail;
          return true;
        }else{
        $_SESSION['password_false'] = true;
        return false;
      }
    }

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

    public static function logout()
    {
        // destroy old session
        session_destroy();

        // immediately start a new one
        session_start();

        // create new session_id
        session_regenerate_id(true);
    }
    public function removeuser($mail){
      global $dbh;

      $stmt = $dbh->prepare("DELETE FROM user
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => $mail
      ));
    }
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
    public static function getunlocked(){
      return ($_SESSION['unlocked']===true);
    }
    public function activateuser(){
      global $dbh;

      $stmt = $dbh->prepare("UPDATE user SET unlocked=true
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => Session::getuser()
      ));

    }
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
    public function changePassword($password, $password2){
      $_SESSION['password_change_tried']=true;
      if($password == $password2&&!empty($password)){
        global $dbh;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $dbh->prepare("UPDATE user SET password=:password
            WHERE mail = :mail");

        $stmt->execute(array(
            'password'     => $hash,
            'mail'     => Session::getuser()
          ));
        $_SESSION['password_changed']=true;
        return true;
      }else{
        $_SESSION['password_changed']=false;
        return false;
      }
    }


    public function create_user($firstname, $lastname, $mail, $password, $password2)
    {
        unset($_SESSION['error_input']);
      if(empty($firstname)){
        $_SESSION['error_input'] .= "Bitte einen Vornamen angeben.\n";
      }
      if(empty($lastname)){
        $_SESSION['error_input'] .= "Bitte einen Nachnamen angeben.\n";
      }
      if(empty($mail)){
        $_SESSION['error_input'] .= "Bitte eine gültige Mailadresse angeben.\n";
      }
      if(empty($mail)){
        $_SESSION['error_input'] .= "Bitte ein Passwort angeben.\n";
      }
      if(!isset($_SESSION['error_input'])){
        if (!Session::checkmail($mail)) {  // user does not yet exists, create it
            $_SESSION['user_exists'] = false;
            if($password == $password2) {
              global $dbh;
            $_SESSION['password_fail'] = false;
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
    public static function getuserimg($id){

      global $dbh;
      $stmt = $dbh->prepare("SELECT imgdata, imgtype FROM image WHERE user_id=:id");
      $stmt -> execute(array(
        'id'=>$id
      ));

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


       return $result['imgdata'];
    }
    public static function deleteUser(){
        if (Session::getpicext(Session::getuserid())!="assets/images/user.png"){
            unlink($_SESSION['workingdirectory']."/".Session::getpicext(Session::getuserid()));
        }

        global $dbh;

      $stmt = $dbh->prepare("DELETE FROM user
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => Session::getuser()
      ));
      $_SESSION['deleteuser_success']=true;
    }

    public static function deleteUserArticle(){
        if (Session::getpicext(Session::getuserid())!="assets/images/user.png"){
            unlink($_SESSION['workingdirectory']."/".Session::getpicext(Session::getuserid()));
        }

        $id=Session::getuserid();

      global $dbh;

      $stmt = $dbh->prepare("DELETE FROM comment
          WHERE user_id = :id");

      $stmt->execute(array(
          'id'     => $id
      ));

      $stmt = $dbh->prepare("DELETE FROM user_likes_article
          WHERE user_id = :id");

      $stmt->execute(array(
          'id'     => $id
      ));

      $stmt = $dbh->prepare("DELETE FROM article
          WHERE user_id = :id");

      $stmt->execute(array(
          'id'     => $id
      ));


      $stmt = $dbh->prepare("DELETE FROM user
          WHERE mail = :mail");

      $stmt->execute(array(
          'mail'     => Session::getuser()
      ));

      $_SESSION['deleteuser_success']=true;
    }
    public static function savePic(){
      if(array_key_exists('datei', $_FILES)) {
      $filepath = $_SESSION['workingdirectory']."/images/profilepics/";
      $filename = pathinfo($_FILES['datei']['name'], PATHINFO_FILENAME);
      $extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));

      $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
      if(!in_array($extension, $allowed_extensions)) {
         $_SESSION['uploadfailed']="Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt";
       }else{
         $max_size = 10*1024*1024; //10 MB
         if($_FILES['datei']['size'] > $max_size) {
            $_SESSION['uploadfailed']="Bitte keine Dateien größer 10MB hochladen";
          }else{
            $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detected_type = exif_imagetype($_FILES['datei']['tmp_name']);
            if(!in_array($detected_type, $allowed_types)) {
              $_SESSION['uploadfailed']="Nur der Upload von Bilddateien ist gestattet";
             }else{
               $new_path = $filepath.Session::getuserid().'.'.$extension;
               if (Session::getpicext(Session::getuserid())!="assets/images/user.png"){
                 unlink($_SESSION['workingdirectory']."/".Session::getpicext(Session::getuserid()));
               }
               move_uploaded_file($_FILES['datei']['tmp_name'],$new_path);
             }
           }
         }
      }
    }
    public static function getpicext($user_id){
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
        return "images/profilepics/user.png";
      }
    }



}
