<?php

require_once '../config.php';

// initialize variables
$template_data = array();

// handle login
if (isset($_REQUEST['login']) && isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    //Freischaltung überprüfen
    if (!Session::check_credentials($_REQUEST['username'], $_REQUEST['password'])) {
        $template_data['message'] = 'Login failed!';
        Template::render('login', $template_data);
        session_destroy();
    }
    if(!Session::passwordfalse() && !Session::userunlocked($_REQUEST['username'])){
        $template_data['title'] = 'Anmeldung bestätigen';
        Template::render('register', $template_data);
        unset($_SESSION['confirmation_tried']);
    }else{
      $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Hauptseite';
        Template::render('start', $template_data);
    }
    //Hier muss noch abgefangen werden, wenn beide Felder leer sind und trotzdem auf login geklickt wird
}

elseif(isset($_REQUEST['lostPassword'])){
    $template_data['title'] = 'Passwort vergessen';
    Template::render('lostPassword', $template_data);
}

elseif(isset($_REQUEST['changePassword'])){
    $template_data['title'] = 'Passwort ändern';
    Template::render('changePassword', $template_data);
}
elseif(isset($_REQUEST['alterPassword'])){
    if(Session::check_credentials(Session::getuser(), $_REQUEST['oldpassword'])){

        if(Session::changePassword($_REQUEST['password'], $_REQUEST['password2'])){
            $template_data['title'] = 'Profil';
            Template::render('profil', $template_data);

        }else{
            $template_data['title'] = 'Passwort ändern';
            Template::render('changePassword', $template_data);

        }
    }else{
        $template_data['title'] = 'Passwort ändern';
        Template::render('changePassword', $template_data);

    }
    unset($_SESSION['password_change_tried']);
}

elseif(isset($_REQUEST['profil'])){
    $template_data['title'] = 'Profil';
    Template::render('profil', $template_data);
}

elseif(isset($_REQUEST['newUser'])){
    $template_data['title'] = 'Neues Konto erstellen';
    Template::render('newUser', $template_data);
}

elseif (isset($_REQUEST['login'])) {
    session_destroy();
    $template_data['title'] = 'Login-Seite';
    Template::render('login', $template_data);
}

elseif (isset($_REQUEST['logout'])) {
    Session::logout();
    $template_data['articles'] = Article::getAll();
    $template_data['title'] = 'Hauptseite';
    Template::render('start', $template_data);
}

elseif (isset($_REQUEST['register'])) {
    unset($_SESSION['error_input']);
    Session::create_user($_REQUEST['firstname'],$_REQUEST['lastname'],$_REQUEST['username'],$_REQUEST['password'], $_REQUEST['password2']);
    if (Session::passwordfailed()) {
        $template_data['title'] = 'Neues Konto erstellen';
        Template::render('newUser', $template_data);
        session_destroy();
    } else if (Session::userexists()) {
        $template_data['title'] = 'Neues Konto erstellen';
        Template::render('newUser', $template_data);
        session_destroy();
    } else if(Session::inputfalse()){
      $template_data['title'] = 'Neues Konto erstellen';
      Template::render('newUser', $template_data);
      session_destroy();
    }else{
        Mail::send($_REQUEST['username']);
        if(Session::mailfailed()===false){
            $template_data['title'] = 'Anmeldung bestätigen';
            Template::render('register', $template_data);
        }else{
            $_SESSION['logged_in'] = false;
            Session::removeuser($_REQUEST['username']);
            $template_data['title'] = 'Neues Konto erstellen';
            Template::render('newUser', $template_data);
            session_destroy();
        }
    }

}
elseif (isset($_REQUEST['article'])) {
  $_SESSION['article_id'] = $_REQUEST['article'];
  $template_data['article']= Article::getArticle($_SESSION['article_id']);
  $template_data['comments']=Comment::getAllComments();
  $template_data['title'] = 'Artikel-Seite';
  Template::render('article', $template_data);
}
elseif (isset($_REQUEST['editOldArticle'])) {
  $template_data['article']= Article::getArticle($_SESSION['article_id']);
  $template_data['title'] = 'Bearbeiten-Artikel-Seite';
  Template::render('editOldArticle', $template_data);
}
elseif (isset($_REQUEST['updateArticle'])) {
  Article::updateArticle($_SESSION['article_id'], $_REQUEST['textareaEdit']);
  $template_data['articles'] = Article::getAll();
  $template_data['title'] = 'Startseite';
  Template::render('start', $template_data);
}
elseif (isset($_REQUEST['confirm'])){

    //Hier andere Meldung anzeigen... viellecht grüne span box?
    if(Mail::checkcode($_REQUEST['code'])){
//Code korrekt Anmeldung abgeschlossen
        $_SESSION['logged_in'] = true;
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Hauptseite';
        Template::render('start', $template_data);
        Session::activateuser();
    }else{
        $template_data['title'] = 'Anmeldung bestätigen';
        Template::render('register', $template_data);

    }
    unset($_SESSION['confirmation_tried']);
}


elseif (isset($_REQUEST['sendCodeAgain'])){
        Mail::send(Session::getuser());
        $template_data['title'] = 'Anmeldung bestätigen';
        Template::render('register', $template_data);
        unset($_SESSION['mail_send']);


}

elseif(isset($_REQUEST['newPassword'])&& isset($_REQUEST['email'])){
    if(Session::checkmail($_REQUEST['email'])){
        Mail::sendpassword($_REQUEST['email']);
        if(Session::mailfailed()){
            $template_data['title'] = 'Passwort ändern';
            Template::render('lostPassword', $template_data);
        }else{
            $template_data['title'] = 'Login-Seite';
            Template::render('login', $template_data);
            unset($_SESSION['mail_send']);
        }
    }else{
        $template_data['title'] = 'Passwort ändern';
        Template::render('lostPassword', $template_data);
    }
}

elseif (isset($_REQUEST['files'])) {
    $template_data['myarticles'] = Article::getmyArticles(Session::getuserid());
    $template_data['title'] = 'Übersicht Eigene-Beiträge';
    Template::render('files', $template_data);
}

elseif (isset($_REQUEST['newArticle'])) {
    $template_data['title'] = 'Neuer Beitrag';
    Template::render('newArticle', $template_data);
}
elseif (isset($_REQUEST['saveArticle'])) {
    Article::saveArticle($_REQUEST['title'], $_REQUEST['theme'],$_REQUEST['textareaEdit']);
    $template_data['articles'] = Article::getAll();
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
}
elseif (isset($_REQUEST['saveComment'])) {
    Comment::saveComment($_REQUEST['textareaComment']);
    $template_data['article']= Article::getArticle($_SESSION['article_id']);
    $template_data['comments']=Comment::getAllComments();
    $template_data['title'] = 'Artikel-Seite';
    Template::render('article', $template_data);
}

elseif (Session::authenticated()) {
    $template_data['articles'] = Article::getAll();
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
} else {
  $template_data['articles'] = Article::getAll();
  $template_data['title'] = 'Hauptseite';
  Template::render('start', $template_data);
}
