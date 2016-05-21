<?php
/*
In der Klasse Artikel sind alle Methoden hinterlegt, die benötigt werden um:
 - Artikel auszulesen und anzuzeigen
 - Artikel zu liken
 - Artikel zu Speichern
 - Artikel zu bearbeiten
 - nach Artikeln zu suchen
*/
class Article {

/* Über die Methode saveArticle() kann ein Artikel gespeichert werden. Die Eingaben werden hier überprüft
*/
  public static function saveArticle($title, $theme, $text) {
      unset($_SESSION['error_input']);
      //Überprüfen der Benutzereingaben und Speichern von zutreffenden Fehlermeldungen
      if(empty($title)){
          $_SESSION['error_input'] .= "Bitte einen Titel angeben.\n";
      }
      if(!Article::checkTitle($title)){
          $_SESSION['error_input'] .= "Der angegebene Titel existiert bereits.\n";
      }
      if(empty($theme)){
          $_SESSION['error_input'] .= "Bitte ein Thema angeben.\n";
      }
      if(empty($text)){
          $_SESSION['error_input'] .= "Bitte einen Beitrag verfassen.\n";
      }
      if(strlen($theme)>100){
          $_SESSION['error_input'] .= "Das Thema darf höchstens 100 Zeichen lang sein.\n";
      }
      if(strlen($title)>100){
          $_SESSION['error_input'] .= "Der Titel darf höchstens 100 Zeichen lang sein.\n";
      }

      if(!isset($_SESSION['error_input'])){
        //über den eingebunden Editor generierte <p> und </p> löschen; Erklärung: Diese nicht erwünscht und beeinflussen das Textformat negativ
          $text = str_replace("&lt;p&gt;", "", $text);
          $text = str_replace("&lt;/p&gt;", "", $text);

          global $dbh;

          //Daten in die Tabelle article einfügen
          $stmt = $dbh->prepare("INSERT INTO article (title, text, user_id) VALUES (:title, :text, :user_id)");

          $stmt->execute(array(
            'title'     => $title,
            'text'     => $text,
            'user_id' => Session::getuserid()
            ));

            //Überprüfen, ob es das Thema schon gibt
          if(Article::getthemeid($theme) == 0) {
            //Thema in die Tabelle theme einfügen
            $stmt = $dbh->prepare("INSERT INTO theme (description) VALUES (:theme)");
            $stmt->execute(array(
              'theme'     => $theme,
              ));
          }

          //Thema-Artikel-Verknüpfung in die Tabelle theme_article einfügen
          $stmt = $dbh->prepare("INSERT INTO theme_article (theme_id, article_id) VALUES (:theme_id, :article_id)");

          $stmt->execute(array(
            'theme_id'     => Article::getthemeid($theme),
            'article_id'   => Article::getarticleid($title)
            ));
      }
}

/*
In der Funktion checkTitle() wird überprüft, ob es bereits einen Artikel mit dem selben Titel gibt
*/
public static function checkTitle($title){
    global $dbh;
    $stmt = $dbh->prepare("SELECT COUNT(*) FROM article WHERE title = :title");

    $stmt->execute(array(
         'title' => $title
      ));

  if($stmt->fetchColumn() == 0) {
    return true;

  }else{
      return false;
  }
}

/*
In der Methode getthemeid() wird die ID des übergebenen Themas ausgelesen
*/
  public static function getthemeid($theme){
    global $dbh;

    $stmt = $dbh->prepare("SELECT id FROM theme
        WHERE description = :theme");

    $stmt->execute(array(
        'theme'     => $theme,
    ));

    $id = $stmt->fetchColumn();
    return $id;
  }

  /*
  In der Methode getarticleid() wird die ID des übergebenen Artikels ausgelesen
  */
  public static function getarticleid($title){
    global $dbh;

    $stmt = $dbh->prepare("SELECT id FROM article
        WHERE title = :title");

    $stmt->execute(array(
        'title'     => $title,
    ));

    $id = $stmt->fetchColumn();
    return $id;
  }

  /*
  In der Methode getAll() werden alle Artikl ausgelesen
  */
  public static function getAll(){
      //Setzen des Headers Aktuelle Beiträge, bevor eine Suche ausgeführt wird
      $_SESSION['search']="Aktuelle Beiträge";

      global $dbh;

      //Auslesen aller Artikel und ihrer Themen
      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id ORDER BY date DESC");

      $stmt ->execute();
      return $stmt ->fetchAll(PDO::FETCH_ASSOC);
  }

  /*
  In der Methode getmyArticles() werden alle Artikel des Users mit der übergebenen ID ausgelesen
  */
  public static function getmyArticles($id)
  {
      global $dbh;
      //Auslesen aller Artikel, deren user_id mit der übergebenen übereinstimmt, und ihrer Themen
      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id where article.user_id=:id ORDER BY date DESC");

      $stmt ->execute(array(
        'id'=> $id
      ));

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /*
  Auslesen des Artikels mit der übergebenen ID
  */
  public static function getArticle($id)
  {
      global $dbh;

      $stmt = $dbh->prepare("SELECT * FROM article WHERE id=:id");

      $stmt->execute(array(
        'id' => $id
      ));

      return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /*
  Update des Artikeltextes mit der übergebenen ID
  */
  public static function updateArticle($id, $text){
    //Überprüfen, ob der Text leer ist
      if ($text=="") {
          $_SESSION['error_input'] .= "Bitte keinen leeren Beitrag speichern.\n";

      } else{
        //über den eingebunden Editor generierte <p> und </p> löschen; Erklärung: Diese nicht erwünscht und beeinflussen das Textformat negativ
          $text = str_replace("&lt;p&gt;", "", $text);
          $text = str_replace("&lt;/p&gt;", "", $text);

          global $dbh;

          //Update des Artikels
          $stmt = $dbh->prepare("UPDATE article SET text=:text WHERE id=:id");

          $stmt->execute(array(
            'text' => $text,
            'id' => $id
            ));
      }
  }

  /*
  Auslesen aller Artikel, deren Titel den übergebenen String enthalten
  */
  public static function searchTitle($title){
      global $dbh;

      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id WHERE article.title LIKE :title ORDER BY date DESC");

      $stmt->execute(array(
        'title' => '%'.$title.'%'
      ));

      return $stmt ->fetchAll(PDO::FETCH_ASSOC);

  }

  /*
  Auslesen aller Artikel, deren Autorennamen den übergebenen String enthalten (Vor- der Nachname)
  */
    public static function searchUser($user){
      global $dbh;

      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id left join user on article.user_id=user.id WHERE user.lastname LIKE :user OR user.firstname LIKE :user ORDER BY date DESC");

      $stmt->execute(array(
        'user' => '%'.$user.'%'
      ));

      return $stmt ->fetchAll(PDO::FETCH_ASSOC);

  }

  /*
  Auslesen aller Artikel, deren Themen den übergebenen String enthalten
  */
  public static function searchTheme($theme){
    global $dbh;

    $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
left join article on article.id = theme_article.article_id  WHERE theme.description LIKE :theme ORDER BY date DESC");

    $stmt->execute(array(
      'theme' => '%'.$theme.'%'
    ));

    return $stmt ->fetchAll(PDO::FETCH_ASSOC);

}

/*
Auslesen aller Artikel, deren Titel, Thema oder Autorennamen den übergebenen String enthalten
*/
public static function searchAll($input){
  global $dbh;

  $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
left join article on article.id = theme_article.article_id left join user on article.user_id=user.id WHERE user.lastname LIKE :input OR user.firstname LIKE :input OR theme.description LIKE :input OR article.title LIKE :input ORDER BY date DESC");

  $stmt->execute(array(
    'input' => '%'.$input.'%'
  ));

  return $stmt ->fetchAll(PDO::FETCH_ASSOC);
}

/*
Prüfen, ob der Benutzer den Artikel liken kann/darf
*/
public static function likeable($article, $user){
  global $dbh;
  //Prüfen, ob der Benutzer angemeldet ist
  if(Session::authenticated()) {
    //Prüfen, ob der angemeldete Benutzer der Autor des Artikels ist
      $stmt = $dbh->prepare("SELECT COUNT(*) FROM article WHERE id=:article AND user_id =:user");

      $stmt->execute(array(
          'user' => $user,
          'article' => $article
      ));

      if ($stmt->fetchColumn() == 0) {
        //Prüfen, ob der angemeldete Benutzer den Artikel bereits geliked hat
          $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_likes_article WHERE user_id=:user AND article_id=:article");

          $stmt->execute(array(
              'user' => $user,
              'article' => $article
          ));

          if ($stmt->fetchColumn() == 0) {
              return true;

          } else {
              return false;

          }
      } else {
          return false;
      }

  }else{
      return false;
  }
}

/*
Liken eines Artikels, Hinzufügen eines Datensatzes in die Tabelle user_likes_article
*/
public static function like($user, $article){
  global $dbh;

    $stmt = $dbh->prepare("INSERT INTO user_likes_article (user_id, article_id) VALUES (:user, :article)");

    $stmt->execute(array(
      'user'=>$user,
      'article' => $article
    ));
}

/*
Zählen aller Likes, die der übergebenen Artikel-ID zugeordnet sind
*/
public static function getLikes($article){
  global $dbh;

  $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_likes_article WHERE article_id=:article");

  $stmt->execute(array(
    'article' => $article
  ));

  return $stmt->fetchColumn();
}

/*
Löschen des Artikels mit der übergebenen ID
*/
public static function deleteArticle($id){
  global $dbh;

  //Löschen aller Datensätze der Tabelle user_likes_article, die auf die übergebene ID referenzieren
  $stmt = $dbh->prepare("DELETE FROM user_likes_article WHERE article_id=:id");

  $stmt->execute(array(
    'id'=>$id
  ));

  //Löschen aller Datensätze der Tabelle theme_article, die auf die übergebene ID referenzieren
  $stmt = $dbh->prepare("DELETE FROM theme_article WHERE article_id=:id");

  $stmt->execute(array(
    'id'=>$id
  ));

  //Löschen aller Datensätze der Tabelle comment, die auf die übergebene ID referenzieren (alle Kommentare zu dem Artikel)
  $stmt = $dbh->prepare("DELETE FROM comment WHERE article_id=:id");

  $stmt->execute(array(
    'id'=>$id
  ));
  //Löschen des Artikels
  $stmt = $dbh->prepare("DELETE FROM article WHERE id=:id");

  $stmt->execute(array(
    'id'=>$id
  ));

  $_SESSION['delete_success']=true;
}

}
?>
