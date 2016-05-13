<?php

class Article {

  public static function saveArticle($title, $theme, $text){
    global $dbh;

    $stmt = $dbh->prepare("INSERT INTO article (title, text, user_id) VALUES (:title, :text, :user_id)");

    $stmt->execute(array(
        'title'     => $title,
        'text'     => $text,
        'user_id' => Session::getuserid()
    ));
    $stmt = $dbh->prepare("INSERT INTO theme (description) VALUES (:theme)");

    $stmt->execute(array(
        'theme'     => $theme,
    ));
    $stmt = $dbh->prepare("INSERT INTO theme_article (theme_id, article_id) VALUES (:theme_id, :article_id)");

    $stmt->execute(array(
        'theme_id'     => Article::getthemeid($theme),
        'article_id'   => Article::getarticleid($title)
    ));
  }
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

      return $dbh->query("SELECT * FROM article")->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function getmyArticles($id)
  {
      global $dbh;

      return $dbh->query("SELECT * FROM article WHERE user_id=$id")->fetchAll(PDO::FETCH_ASSOC);
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


}
?>
