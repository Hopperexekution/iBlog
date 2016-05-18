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
                //Pfad auf die Textbox legen
                var textbox_pointer = document.getElementById("textareaEdit");
                //Inhalt aus der textbox holen
                var textbox_inhalt = textbox_pointer.value;
                selectedText = textbox_inhalt.substring(textbox_pointer.selectionStart,textbox_pointer.selectionEnd);
                if (selectedText != ""){
                    //Speichert den Teil des Textes vom Anfang BIS zur Selektion
                    var textbox_beginn = textbox_inhalt.substring(0,textbox_inhalt.indexOf(selectedText));
                    //Speichert den Teil ab ENDE der Selektion
                    var textbox_ende = textbox_inhalt.substring(textbox_inhalt.indexOf(selectedText)+selectedText.length,textbox_inhalt.length);
                    //Setzt die Tags vor und hinter den selektierten Text
                    selectedText = "<" + tag + ">" + selectedText + "</" + tag + ">";


                    //Generiert den kompletten Inhalt
                    textbox_inhalt = textbox_beginn+selectedText+textbox_ende;
                    //Schiebt es zurück ins Textfeld
                    document.getElementById("textareaEdit").value = textbox_inhalt;
                } else if(tag == "br"){
                    var textbox_start = textbox_inhalt.substring(0,textbox_inhalt.cursor);
                    //Generiert den kompletten Inhalt
                    textbox_inhalt = textbox_start+"<" + tag + ">";
                    document.getElementById("textareaEdit").value = textbox_inhalt;
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
