<?php

require_once '../config.php';

// initialize variables
$template_data = array();

// handle login
if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    //Freischaltung überprüfen
    if (!Session::check_credentials($_REQUEST['username'], $_REQUEST['password'])) {
        $template_data['message'] = 'Login failed!';
    }

    //Hier muss noch abgefangen werden, wenn beide Felder leer sind und trotzdem auf login geklickt wird
}

if(isset($_REQUEST['lostPassword'])){
    $template_data['title'] = 'Passwort vergessen';
    Template::render('lostPassword', $template_data);
}
if(isset($_REQUEST['newPassword']) && isset($_REQUEST['email'])){
//TODO: Abfrage ob Email vorhanden ist anschließend Mail verschicken und auf Login-Seite wechseln
    $template_data['title'] = 'Login';
    Template::render('login', $template_data);
}

if(isset($_REQUEST['changePassword'])){
    $template_data['title'] = 'Passwort ändern';
    Template::render('changePassword', $template_data);
}

if(isset($_REQUEST['profil'])){
    $template_data['title'] = 'Profil';
    Template::render('profil', $template_data);
}

if(isset($_REQUEST['newUser'])){
    $template_data['title'] = 'Neues Konto erstellen';
    Template::render('newUser', $template_data);
}

if (isset($_REQUEST['login'])) {
    $template_data['title'] = 'Login-Seite';
    Template::render('login', $template_data);
}

if (isset($_REQUEST['logout'])) {
    Session::logout();
}

if (isset($_REQUEST['register'])) {
    Session::create_user($_REQUEST['firstname'],$_REQUEST['lastname'],$_REQUEST['username'],$_REQUEST['password'], $_REQUEST['password2']);
    //Mail mit Bestätigungscode versenden
    $template_data['title'] = 'Anmeldung bestätigen';
    Template::render('register', $template_data);
}

if (Session::authenticated()) {
    $template_data['title'] = 'Startseite';
    Template::render('start', $template_data);
} else {
    //$template_data['title'] = 'Login';
   // Template::render('login', $template_data);
}

$template_data['title'] = 'Hauptseite';
Template::render('start', $template_data);
