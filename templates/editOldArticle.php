<link rel="stylesheet" href="assets/stylesheets/editOldArticle.css">

<div class="sideHeaderDiv">
    <label class="sideHeader"><?php echo $article['title'] ?></label>
</div>

<form action="index.php?updateArticle" method="post" class="editOldArticle">
    <div class="singleArticle">

        <textarea id="widgEditor" name="widgEditor" class="widgEditor"><?php echo $article['text']?></textarea>

        


        <button>Speichern</button>
        <input type="button" value="U" onclick="formatText ('u');" class="underline"/>
        <input type="button" value="I" onclick="formatText ('i');" class="italic"/>
        <input type="button" value="B" onclick="formatText ('b');" class="bold" />
        <input type="button" value="Enter" onclick="formatText ('br');" class="enter"/>


    </div>

</form>
