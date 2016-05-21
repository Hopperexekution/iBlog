<?php
/*
In der index.php wird je nach Benutzeraktion, der Inhalt der HTML-Seite gewechselt
*/
require_once '../config.php';
header("Content-Type: text/html; charset=utf-8");

// initialize variables
$template_data = array();
//Speichern des Working-Directorys
$_SESSION['workingdirectory']= getcwd();

// handle login
if (isset($_REQUEST['login']) && isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    //Anmeldedaten sind nicht korrekt
    if (!Session::check_credentials(htmlspecialchars($_REQUEST['username']), htmlspecialchars($_REQUEST['password']))) {
        $template_data['message'] = 'Login failed!';
        Template::render('login', $template_data);
        session_destroy();
    }
    //Anmeldedaten sind korrekt aber der User ist nicht freigeschaltet
    if(!Session::passwordfalse() && !Session::userunlocked(htmlspecialchars($_REQUEST['username']))){
        $template_data['title'] = 'Anmeldung bestätigen';
        Template::render('register', $template_data);
        unset($_SESSION['confirmation_tried']);

    }else{
      //der User ist freigeschaltet
      $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Hauptseite';
        Template::render('start', $template_data);
    }
}
//Wechsel auf die Login-Seite
elseif (isset($_REQUEST['login'])) {
    session_destroy();
    $template_data['title'] = 'Login-Seite';
    Template::render('login', $template_data);
}
//Logout
elseif (isset($_REQUEST['logout'])) {
    Session::logout();
    //Wechsel auf Startseite
    $template_data['articles'] = Article::getAll();
    $template_data['title'] = 'Hauptseite';
    Template::render('start', $template_data);
}

//Wechsel auf die Seite "Passwort vergessen"
elseif(isset($_REQUEST['lostPassword'])){
    $template_data['title'] = 'Passwort vergessen';
    Template::render('lostPassword', $template_data);
}

//Neues Passwort anfordern
elseif(isset($_REQUEST['newPassword'])&& isset($_REQUEST['email'])){
  //Überprüfen der Mailadresse
    if(Session::checkmail(htmlspecialchars($_REQUEST['email']))){
      //Mail versenden
        Mail::sendpassword(htmlspecialchars($_REQUEST['email']));
        //Mail konnte nicht versandt werden
        if(Session::mailfailed()){
            $template_data['title'] = 'Passwort ändern';
            Template::render('lostPassword', $template_data);
            //Mail wurde versandt
        }else{
            $template_data['title'] = 'Login-Seite';
            Template::render('login', $template_data);
            unset($_SESSION['mail_send']);
        }
    }else{
      //Mailadresse ist nicht in Datenbank abgespeichert
        $template_data['title'] = 'Passwort ändern';
        Template::render('lostPassword', $template_data);
    }
}

//Wechsel auf die Seite "Neues Konto erstellen"
elseif(isset($_REQUEST['newUser'])){
    $template_data['title'] = 'Neues Konto erstellen';
    Template::render('newUser', $template_data);
}
//Registrieren als neuer Benutzer
elseif (isset($_REQUEST['register'])) {
  //Hinzufügen des Benutzers in die Datenbank
    Session::create_user(htmlspecialchars($_REQUEST['firstname']),htmlspecialchars($_REQUEST['lastname']),htmlspecialchars($_REQUEST['username']),htmlspecialchars($_REQUEST['password']), htmlspecialchars($_REQUEST['password2']));
    //Die Passwörter stimmen nicht überein, der User existiert bereits oder die Angaben enthalten Fehler
    if (Session::passwordfailed()||Session::userexists()||Session::inputfalse()) {
        $template_data['title'] = 'Neues Konto erstellen';
        Template::render('newUser', $template_data);
        session_destroy();
    }else{
      //Versenden der Bestätigungsmail
        Mail::send(htmlspecialchars($_REQUEST['username']));
        //Die Mail konnte  zugestellt werden
        if(Session::mailfailed()===false){
            $template_data['title'] = 'Anmeldung bestätigen';
            Template::render('register', $template_data);
        }else{
          //Die Mail konnte nicht zugestellt werden
            $_SESSION['logged_in'] = false;
            Session::removeuser(htmlspecialchars($_REQUEST['username']));
            $template_data['title'] = 'Neues Konto erstellen';
            Template::render('newUser', $template_data);
            session_destroy();
        }
    }
}
//Bestätigen der Benutzerdaten
elseif (isset($_REQUEST['confirm'])){
    if(Mail::checkcode($_REQUEST['code'])){
      //Code korrekt und Anmeldung abgeschlossen
        $_SESSION['logged_in'] = true;
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Hauptseite';
        Template::render('start', $template_data);
        //Aktivieren des Benutzers
        Session::activateuser();
    }else{
      //Der Code war nicht korrekt
        $template_data['title'] = 'Anmeldung bestätigen';
        Template::render('register', $template_data);

    }
    unset($_SESSION['confirmation_tried']);
}

//Erneutes versenden des Bestätigungscodes
elseif (isset($_REQUEST['sendCodeAgain'])){
        Mail::send(Session::getuser());
        $template_data['title'] = 'Anmeldung bestätigen';
        Template::render('register', $template_data);
        unset($_SESSION['mail_send']);

}
//Suchen in den Artikeln
elseif(isset($_REQUEST['search'])){
  //Setzen des Titels
  $_SESSION['search']="Suche nach \"".htmlspecialchars($_REQUEST['inputSearch']). "\" in ".$_REQUEST['selectionBox'];
  //Suchen in den Titeln
  if($_REQUEST['selectionBox']=='Titel'){
    $template_data['articles'] = Article::searchTitle(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
    //Suchen in den Benutzernamen
  }elseif($_REQUEST['selectionBox']=='Benutzer'){
    $template_data['articles'] = Article::searchUser(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
    //Suchen in den Themen
  }elseif($_REQUEST['selectionBox']=='Thema'){
    $template_data['articles'] = Article::searchTheme(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
    //Suchen in allen drei Kategorien
  }else{
    $template_data['articles'] = Article::searchAll(htmlspecialchars($_REQUEST['inputSearch']));
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
  }
  $_SESSION['search']="Aktuelle Beiträge";

}

//Anzeige eines Artikels
elseif (isset($_REQUEST['article'])) {
  $_SESSION['article_id'] = $_REQUEST['article'];
  //Lesen des Artikels
  $template_data['article']= Article::getArticle(Session::getArticleId());
  //Lesen der Kommentare
  $template_data['comments']=Comment::getAllComments();
  $template_data['title'] = 'Artikel-Seite';
  Template::render('article', $template_data);
}

//Liken eines Artikels
elseif(isset($_REQUEST['like'])){
  Article::like(Session::getuserid(), Session::getArticleId());
  $template_data['article']= Article::getArticle(Session::getArticleId());
  $template_data['comments']=Comment::getAllComments();
  $template_data['title'] = 'Artikel-Seite';
  Template::render('article', $template_data);
}

//Speichern eines Kommentares
elseif (isset($_REQUEST['saveComment'])) {
    Comment::saveComment(htmlspecialchars($_REQUEST['textareaComment']));
    $template_data['article']= Article::getArticle(Session::getArticleId());
    $template_data['comments']=Comment::getAllComments();
    $template_data['title'] = 'Artikel-Seite';
    Template::render('article', $template_data);
    unset($_SESSION['comment_empty']);
}

//Wechsel zu der "Artikel Bearbeiten"-Seite
elseif (isset($_REQUEST['editOldArticle'])) {
  $template_data['article']= Article::getArticle(Session::getArticleId());
  $template_data['title'] = 'Bearbeiten-Artikel-Seite';
  Template::render('editOldArticle', $template_data);
}

//Speichern eines bearbeiteten Atikels
elseif (isset($_REQUEST['updateArticle'])) {
    Article::updateArticle(Session::getArticleId(), htmlspecialchars($_REQUEST['widgEditor']));
    //Text ist leer
    if (Session::inputfalse()) {
        $template_data['article']= Article::getArticle(Session::getArticleId());
        $template_data['title'] = 'Bearbeiten-Artikel-Seite';
        Template::render('editOldArticle', $template_data);
        unset($_SESSION['error_input']);
    } else{
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Startseite';
        Template::render('start', $template_data);
    }
}

//Wechsel auf Profilseite
elseif(isset($_REQUEST['profil'])){
    $template_data['title'] = 'Profil';
    Template::render('profil', $template_data);
}

//Wechsel auf "Eigene-Beiträge"-Seite
elseif (isset($_REQUEST['files'])) {
    $template_data['myarticles'] = Article::getmyArticles(Session::getuserid());
    $template_data['title'] = 'Übersicht Eigene-Beiträge';
    Template::render('files', $template_data);
}

//Wechsel auf "neuer Beitrag"-Seite
elseif (isset($_REQUEST['newArticle'])) {
    $template_data['title'] = 'Neuer Beitrag';
    Template::render('newArticle', $template_data);
}

//Speichern eines neuen Beitrags
elseif (isset($_REQUEST['saveArticle'])) {
    Article::saveArticle(htmlspecialchars($_REQUEST['title']), htmlspecialchars($_REQUEST['theme']), htmlspecialchars($_REQUEST['widgEditor']));
    //Eingaben werden nicht akzeptiert
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

//Wechsel auf "Neues Foto"-Seite
elseif (isset($_REQUEST['newPic'])){
    $template_data['title'] = 'Neues Foto';
    Template::render('newPicture', $template_data);

}
//Speichern des Fotos
elseif(isset($_REQUEST['uploadPic'])){
    Session::savePic();
    //Upload hat nicht funktioniert
    if(Session::uploadfailed()){
        $template_data['title'] = 'Neues Foto';
        Template::render('newPicture', $template_data);
    }else{
      $template_data['title'] = 'Profil';
      Template::render('profil', $template_data);
      //Neu laden der Seite (zur direkten Anzeige des Fotos)
        header("Refresh:0; url=index.php?profil");
    }
    unset($_SESSION['uploadfailed']);

}//Löschen des Profilfotos
elseif(isset($_REQUEST['deletepic'])){
  Session::deletePic();
  $template_data['title'] = 'Profil';
  Template::render('profil', $template_data);

}//Löschen eines Artikels
elseif(isset($_REQUEST['deleteArticle'])){
  Article::deleteArticle($_SESSION['article_id']);
  //Das Löschen war erfolgreich
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

//Löschen des Users
}elseif(isset($_REQUEST['deleteUser'])){
    Session::deleteUser();

    //Löschen war erfolgreich
  if(Session::deleteusersuccess()){
    //Ausloggen
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
//Löschen des Users mit allen Beiträgen, Likes und Kommentaren
elseif(isset($_REQUEST['deleteUserArticle'])){
    Session::deleteUserArticle();
    //Loschen war erfolgreich
    if(Session::deleteusersuccess()){
      //Ausloggen
        Session::logout();
        $template_data['articles'] = Article::getAll();
        $template_data['title'] = 'Startseite';
        Template::render('start', $template_data);
        unset($_SESSION['deleteuser_success']);
    }else{
        $template_data['title'] = 'Profil';
        Template::render('profil', $template_data);
    }

//Wechsel auf die "Passwort ändern"-Seite
}
elseif(isset($_REQUEST['changePassword'])){
    $template_data['title'] = 'Passwort ändern';
    Template::render('changePassword', $template_data);
}
//Ändern des Passworts
elseif(isset($_REQUEST['alterPassword'])){
    //Angabe zu dem alten Passwort stimmt
    if(Session::check_credentials(Session::getuser(), htmlspecialchars($_REQUEST['oldpassword']))){

        //Passwort erfolgreich geändert
        if(Session::changePassword(htmlspecialchars($_REQUEST['password']), htmlspecialchars($_REQUEST['password2']))){
            $template_data['title'] = 'Profil';
            Template::render('profil', $template_data);

        }else{
            $template_data['title'] = 'Passwort ändern';
            Template::render('changePassword', $template_data);
            unset($_SESSION['password_to_short']);

        }
    }else{
        $template_data['title'] = 'Passwort ändern';
        Template::render('changePassword', $template_data);

    }
    unset($_SESSION['password_change_tried']);
}

//Wechsel zur Start-Seite
else {
  $template_data['articles'] = Article::getAll();
  $template_data['title'] = 'Hauptseite';
  Template::render('start', $template_data);
}
