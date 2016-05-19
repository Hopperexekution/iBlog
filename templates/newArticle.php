<link rel="stylesheet" href="assets/stylesheets/newArticle.css">

<div class="sideHeaderDiv">
    <label class="sideHeader">Neuen Beitrag erfassen</label>
</div>

<form action="index.php?saveArticle" method="post" class="newArticle">

    <?php if(Session::inputfalse()) : ?>
        <div class="infoDiv">
            <span onclick="this.parentElement.style.display='none';">&times;</span>
            <textarea class="failRegistration" rows="1"><?php echo $_SESSION['error_input'] ?></textarea>
        </div>
    <?php endif ?>

    <div class="addArticleDiv">
        <input id="theme" type="text" name="theme" placeholder="Thema des Beitrags" value=<?php echo $_REQUEST['theme']?> >
        <input id="title" type="text" name="title" placeholder="Titel des Beitrags" value=<?php echo $_REQUEST['title']?>>
    </div>

    <div class="singleArticle">
        <textarea id="textareaEdit" class="textareaEdit" name="textareaEdit" ><?php echo $_REQUEST['textareaEdit']?></textarea>

        <script type="text/javascript">
            function formatText(tag) {
                //Pfad auf die Textarea legen
                var textarea_pointer = document.getElementById("textareaEdit");
                //Inhalt aus der textarea lesen
                var textarea_inhalt = textarea_pointer.value;
                selectedText = textarea_inhalt.substring(textarea_pointer.selectionStart,textarea_pointer.selectionEnd);
                if (selectedText != ""){
                    //Speichert den Teil des Textes vom Anfang bis zur Selektion
                    var textarea_beginn = textarea_inhalt.substring(0,textarea_inhalt.indexOf(selectedText));
                    //Speichert den Teil ab Ende der Selektion
                    var textarea_ende = textarea_inhalt.substring(textarea_inhalt.indexOf(selectedText)+selectedText.length,textarea_inhalt.length);
                    //Setzt die Tags vor und hinter den selektierten Text
                    selectedText = "<" + tag + ">" + selectedText + "</" + tag + ">";


                    //Generiert den Inhalt
                    textarea_inhalt = textarea_beginn+selectedText+textarea_ende;
                    //Schiebt es zurück in die Textarea
                    document.getElementById("textareaEdit").value = textarea_inhalt;
                } else if(tag == "br"){
                    var textarea_start = textarea_inhalt.substring(0,textarea_inhalt.cursor);
                    //Generiert den Inhalt
                    textarea_inhalt = textarea_start+"<" + tag + ">";
                    document.getElementById("textareaEdit").value = textarea_inhalt;
                }
            }
        </script>


        <button>Speichern</button>
        <input type="button" value="U" onclick="formatText ('u');" class="underline"/>
        <input type="button" value="I" onclick="formatText ('i');" class="italic"/>
        <input type="button" value="B" onclick="formatText ('b');" class="bold" />
        <input type="button" value="Enter" onclick="formatText ('br');" class="enter" />

    </div>
    
</form>
