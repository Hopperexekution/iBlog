<form action="index.php?updateArticle" method="post" class="editOldArticle">

    <div class="sideHeaderDiv">
        <label class="sideHeader"><?php echo $article['title'] ?></label>
    </div>

    <div class="singleArticle">

        <textarea id="textareaEdit" name="textareaEdit" class="textareaEdit">
<?php echo $article['text']?>
        </textarea>

        <button>Speichern</button>
        <button class="underline">U</button>
        <button class="italic">K</button>
        <button class="bold">F</button>


    </div>

</form>
