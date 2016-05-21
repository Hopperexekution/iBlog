<?php
/*
In der Klasse Comment befinden sich Methoden zum Speichern und Auslesen der Kommentare
*/
class Comment {
/*
Über die Methode saveComment() kann ein Kommentar gespeichert werden
*/
  public static function saveComment($text){
    //Prüfen, ob der Kommentar leer ist
    if(empty($text)){
      $_SESSION['comment_empty']=true;

    }else{
      global $dbh;
      //Speichern des Kommentares in der Datenbank
      $stmt = $dbh->prepare("INSERT INTO comment (user_id, article_id, text) VALUES (:user_id, :article_id, :text)");

      $stmt->execute(array(
          'user_id' => Session::getuserid(),
          'article_id' => Session::getArticleId(),
          'text' => $text
        ));
      }
    }
/*
In der Methode getAllComments() werden alle Kommentare zu dem aktuell aufgerufenen Artikel angezeigt
*/
  public static function getAllComments(){
    global $dbh;

    $stmt = $dbh->prepare("SELECT * FROM comment WHERE article_id=:id");

    $stmt->execute(array(
      'id'=>Session::getArticleId()
    ));

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
