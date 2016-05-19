<?php

class Article {

  public static function saveArticle($title, $theme, $text) {
      unset($_SESSION['error_input']);
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
    global $dbh;

    $stmt = $dbh->prepare("INSERT INTO article (title, text, user_id) VALUES (:title, :text, :user_id)");

    $stmt->execute(array(
        'title'     => $title,
        'text'     => $text,
        'user_id' => Session::getuserid()
    ));

      $stmt = $dbh->prepare("SELECT id FROM theme WHERE description = :theme");
          $stmt->execute(array(
             'theme' => $theme
          ));
      if($stmt->fetchColumn() == 0) {
          $stmt = $dbh->prepare("INSERT INTO theme (description) VALUES (:theme)");
          $stmt->execute(array(
              'theme'     => $theme,
          ));
      }


    $stmt = $dbh->prepare("INSERT INTO theme_article (theme_id, article_id) VALUES (:theme_id, :article_id)");

    $stmt->execute(array(
        'theme_id'     => Article::getthemeid($theme),
        'article_id'   => Article::getarticleid($title)
    ));
  }}
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
  public static function getAll()
  {
      //Setzen des Headers Aktuelle Beiträge, bevor eine Suche ausgeführt wird
      $_SESSION['search']="Aktuelle Beiträge";
      global $dbh;

      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id ORDER BY date DESC");
      $stmt ->execute();
 return $stmt ->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function getmyArticles($id)
  {
      global $dbh;

      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id where article.user_id=:id ORDER BY date DESC");
      $stmt ->execute(array(
        'id'=> $id
      ));

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function getArticle($id)
  {
      global $dbh;

      $stmt = $dbh->prepare("SELECT * FROM article WHERE id=:id");
      $stmt->execute(array(
        'id' => $id
      ));
      return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public static function updateArticle($id, $text)
  {
      global $dbh;

      $stmt = $dbh->prepare("UPDATE article SET text=:text WHERE id=:id");
      $stmt->execute(array(
          'text'     => $text,
          'id'   => $id
      ));
  }
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
    public static function searchTitle($title){
      global $dbh;
      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id WHERE article.title LIKE :title ORDER BY date DESC");
      $stmt->execute(array(
        'title' => '%'.$title.'%'
      ));
      return $stmt ->fetchAll(PDO::FETCH_ASSOC);

  }
    public static function searchUser($user){
      global $dbh;

      $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id left join user on article.user_id=user.id WHERE user.lastname LIKE :user OR user.firstname LIKE :user ORDER BY date DESC");
      $stmt->execute(array(
        'user' => '%'.$user.'%'
      ));
      return $stmt ->fetchAll(PDO::FETCH_ASSOC);

  }
  public static function searchTheme($theme){
    global $dbh;

    $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
left join article on article.id = theme_article.article_id  WHERE theme.description LIKE :theme ORDER BY date DESC");
    $stmt->execute(array(
      'theme' => '%'.$theme.'%'
    ));
    return $stmt ->fetchAll(PDO::FETCH_ASSOC);

}
public static function searchAll($input){
  global $dbh;

  $stmt = $dbh->prepare("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
left join article on article.id = theme_article.article_id left join user on article.user_id=user.id WHERE user.lastname LIKE :input OR user.firstname LIKE :input OR theme.description LIKE :input OR article.title LIKE :input ORDER BY date DESC");
  $stmt->execute(array(
    'input' => '%'.$input.'%'
  ));
  return $stmt ->fetchAll(PDO::FETCH_ASSOC);

}
public static function like($user, $article){
  global $dbh;
  $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_likes_article WHERE user_id=:user AND article_id=:article");
  $stmt->execute(array(
    'user'=>$user,
    'article' => $article
  ));
  if($stmt->fetchColumn()==0){
    $stmt = $dbh->prepare("INSERT INTO user_likes_article (user_id, article_id) VALUES (:user, :article)");
    $stmt->execute(array(
      'user'=>$user,
      'article' => $article
    ));
  }
}
public static function getLikes($article){
  global $dbh;
  $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_likes_article WHERE article_id=:article");
  $stmt->execute(array(
    'article' => $article
  ));
  return $stmt->fetchColumn();
}
public static function likeable($article, $user){
  global $dbh;
  if(Session::authenticated()) {
      $stmt = $dbh->prepare("SELECT COUNT(*) FROM article WHERE id=:article AND user_id =:user");
      $stmt->execute(array(
          'user' => $user,
          'article' => $article
      ));
      if ($stmt->fetchColumn() == 0) {
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
public static function deleteArticle($id){
  global $dbh;
  $stmt = $dbh->prepare("DELETE FROM user_likes_article WHERE article_id=:id");
  $stmt->execute(array(
    'id'=>$id
  ));
  $stmt = $dbh->prepare("DELETE FROM theme_article WHERE article_id=:id");
  $stmt->execute(array(
    'id'=>$id
  ));
  $stmt = $dbh->prepare("DELETE FROM comment WHERE article_id=:id");
  $stmt->execute(array(
    'id'=>$id
  ));
  $stmt = $dbh->prepare("DELETE FROM article WHERE id=:id");
  $stmt->execute(array(
    'id'=>$id
  ));
  $_SESSION['delete_success']=true;
}



}
?>
