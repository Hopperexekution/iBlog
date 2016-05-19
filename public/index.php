<?php

require_once '../config.php';

// initialize variables
$template_data = array();
$_SESSION['workingdirectory']= getcwd();

// handle login
if (isset($_REQUEST['login']) && isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    //Freischaltung überprüfen
    if (!Session::check_credentials(htmlspecialchars($_REQUEST['username']), htmlspecialchars($_REQUEST['password']))) {
        $template_data['message'] = 'Login failed!';
        Template::render('login', $template_data);
        session_destroy();
    }
    if(!Session::passwordfalse() && !Session::userunlocked(htmlspecialchars($_REQUEST['username']))){
        $template_data['title'] = 'Anmeldung bestätigen';
        Template::render('register', $template_data);
        unset($_SESSION['confirmation_tried']);
    }else{
      $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Hauptseite';
        Template::render('start', $template_data);
    }
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
    if(Session::check_credentials(Session::getuser(), htmlspecialchars($_REQUEST['oldpassword']))){

        if(Session::changePassword(htmlspecialchars($_REQUEST['password']), htmlspecialchars($_REQUEST['password2']))){
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
    Session::create_user(htmlspecialchars($_REQUEST['firstname']),htmlspecialchars($_REQUEST['lastname']),htmlspecialchars($_REQUEST['username']),htmlspecialchars($_REQUEST['password']), htmlspecialchars($_REQUEST['password2']));
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
        Mail::send(htmlspecialchars($_REQUEST['username']));
        if(Session::mailfailed()===false){
            $template_data['title'] = 'Anmeldung bestätigen';
            Template::render('register', $template_data);
        }else{
            $_SESSION['logged_in'] = false;
            Session::removeuser(htmlspecialchars($_REQUEST['username']));
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
    Article::updateArticle($_SESSION['article_id'], htmlspecialchars($_REQUEST['widgEditor']));
    if (Session::inputfalse()) {
        $template_data['article']= Article::getArticle($_SESSION['article_id']);
        $template_data['title'] = 'Bearbeiten-Artikel-Seite';
        Template::render('editOldArticle', $template_data);
        unset($_SESSION['error_input']);
    } else{
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Startseite';
        Template::render('start', $template_data);
    }
}
elseif (isset($_REQUEST['confirm'])){
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
    if(Session::checkmail(htmlspecialchars($_REQUEST['email']))){
        Mail::sendpassword(htmlspecialchars($_REQUEST['email']));
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
    Article::saveArticle(htmlspecialchars($_REQUEST['title']), htmlspecialchars($_REQUEST['theme']), htmlspecialchars($_REQUEST['widgEditor']));
    if(Session::inputfalse()) {
        $template_data['title'] = 'Neuer Beitrag';
        Template::render('newArticle', $template_data);
        unset($_SESSION['error_input']);
    } else {
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Startseite';
        Template::render('start', $template_data);
    }
}
elseif (isset($_REQUEST['saveComment'])) {
    Comment::saveComment(htmlspecialchars($_REQUEST['textareaComment']));
    $template_data['article']= Article::getArticle($_SESSION['article_id']);
    $template_data['comments']=Comment::getAllComments();
    $template_data['title'] = 'Artikel-Seite';
    Template::render('article', $template_data);
    unset($_SESSION['comment_empty']);

}elseif(isset($_REQUEST['search'])){
  $_SESSION['search']="Suche nach \"".htmlspecialchars($_REQUEST['inputSearch']). "\" in ".$_REQUEST['selectionBox'];
  if($_REQUEST['selectionBox']=='Titel'){
    $template_data['articles'] = Article::searchTitle(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);

  }elseif($_REQUEST['selectionBox']=='Benutzer'){
    $template_data['articles'] = Article::searchUser(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);

  }elseif($_REQUEST['selectionBox']=='Thema'){
    $template_data['articles'] = Article::searchTheme(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);

  }else{
    $template_data['articles'] = Article::searchAll(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
  }
  $_SESSION['search']="Aktuelle Beiträge";
}elseif(isset($_REQUEST['like'])){
  Article::like(Session::getuserid(), $_SESSION['article_id']);
  $template_data['article']= Article::getArticle($_SESSION['article_id']);
  $template_data['comments']=Comment::getAllComments();
  $template_data['title'] = 'Artikel-Seite';
  Template::render('article', $template_data);

}
elseif (isset($_REQUEST['newPic'])){
    $template_data['title'] = 'Neues Foto';
    Template::render('newPicture', $template_data);
}elseif(isset($_REQUEST['uploadPic'])){
    Session::savePic();
    if(Session::uploadfailed()){
        $template_data['title'] = 'Neues Foto';
        Template::render('newPicture', $template_data);
    }else{
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Startseite';
        Template::render('start', $template_data);
        header("Refresh:0; url=index.php?home=1");
    }
    unset($_SESSION['uploadfailed']);

}elseif(isset($_REQUEST['deleteArticle'])){
  Article::deleteArticle($_SESSION['article_id']);
  if(Session::deleteSuccess()){
    $template_data['articles'] = Article::getAll();
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
    unset($_SESSION['delete_success']);
  }else{
    $template_data['article']= Article::getArticle($_SESSION['article_id']);
    $template_data['comments']=Comment::getAllComments();
    $template_data['title'] = 'Artikel-Seite';
    Template::render('article', $template_data);
  }
}elseif(isset($_REQUEST['deleteUser'])){
    Session::deleteUser();

  if(Session::deleteusersuccess()){
    Session::logout();
    $template_data['articles'] = Article::getAll();
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
    unset($_SESSION['deleteuser_success']);
  }else{
    $template_data['title'] = 'Profil';
    Template::render('profil', $template_data);
  }
}
elseif(isset($_REQUEST['deleteUserArticle'])){
    Session::deleteUserArticle();

    if(Session::deleteusersuccess()){
        Session::logout();
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Startseite';
        Template::render('start', $template_data);
        unset($_SESSION['deleteuser_success']);
    }else{
        $template_data['title'] = 'Profil';
        Template::render('profil', $template_data);
    }
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
