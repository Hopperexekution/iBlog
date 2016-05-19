<?php
class Comment {
  public static function saveComment($text){
    if(empty($text)){
      $_SESSION['comment_empty']=true;
    }else{
      global $dbh;

      $stmt = $dbh->prepare("INSERT INTO comment (user_id, article_id, text) VALUES (:user_id, :article_id, :text)");

      $stmt->execute(array(
          'user_id' => Session::getuserid(),
          'article_id' => $_SESSION['article_id'],
          'text' => $text
        ));
      }
    }
  public static function getAllComments(){
    global $dbh;
    $article_id = $_SESSION['article_id'];

    $stmt = $dbh->prepare("SELECT * FROM comment WHERE article_id=:id");
    $stmt->execute(array(
      'id'=>$article_id
    ));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
