<form action="index.php" method="post" class="login">
   <label for="artist">
       Künstler:
   </label>
   <input id="artist" type="text" name="artist">

   <label for="album">
       Album:
   </label>
   <input id="album" type="text" name="album">

   <label for="year">
       Erscheinungsjahr:
   </label>
   <input id="year" type="text" name="year">

   <button>Erstellen</button>

   <input type="hidden" name="action" value="create_album">
</form>
