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

        if (password_verify($password, $hash)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $mail;

            // create new session_id
            session_regenerate_id(true);

            return true;
        }

        return false;
    }

    public static function authenticated()
    {
        return ($_SESSION['logged_in'] === true);
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

    public function create_user($firsname, $lastname, $mail, $password, $password2)
    {
        global $dbh;

        $stmt = $dbh->prepare("SELECT COUNT(*) FROM user
            WHERE mail = :mail");

        $stmt->execute(array(
            'mail'     => $mail
        ));

        if ($stmt->fetchColumn() == 0) {         // user does not yet exists, create it
            if($password == $password2) {
            $stmt2 = $dbh->prepare("INSERT INTO user (lastname, firstname, mail, password)
                VALUES (:lastname, :firstname, :mail, :password)");

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt2->execute(array(
                'lastname' => $lastname,
                'firstname'=> $firsname,
                'mail'     => $mail,
                'password' => $hash
            ));

            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $mail;

            // create new session_id
            session_regenerate_id(true);
            } else {
                throw new Exception('Überprüfen Sie bitte ihr Passwort!');
            }
        } else {
            throw new Exception('user already exists!');
        }
    }
}
