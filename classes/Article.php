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
          $_SESSION['error_input'] .= "Bitte einen Beitrag verfassen.";
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
      global $dbh;

      return $dbh->query("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function getmyArticles($id)
  {
      global $dbh;

      return $dbh->query("SELECT article.id, article.title, article.user_id, article.date, theme.description FROM theme left join theme_article on theme.id = theme_article.theme_id
 left join article on article.id = theme_article.article_id where article.user_id=$id ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function getArticle($id)
  {
      global $dbh;

      return $dbh->query("SELECT * FROM article WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
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



}
?>
