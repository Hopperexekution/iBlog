<link rel="stylesheet" href="assets/stylesheets/newArticle.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Neuen Beitrag erfassen</label>
</div>

<form action="index.php?saveArticle" method="post" class="newArticle">

    <div class="addArticleDiv">
        <input id="theme" type="text" name="theme" placeholder="Thema des Beitrags">
        <input id="title" type="text" name="title" placeholder="Titel des Beitrags">
    </div>

    <div class="singleArticle">

            <textarea id="textareaEdit" class="textareaEdit" name="textareaEdit">

            </textarea>

        <button>Speichern</button>
        <button class="underline">U</button>
        <button class="italic">K</button>
        <button class="bold">F</button>


    </div>

</form>
