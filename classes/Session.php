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
      if($password == $password2){
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
      return $user;
    }
}
