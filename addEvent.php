
<!<!DOCTYPE html>
<html lang="en">



<body>

      <?php
         include __DIR__ . '/layout.php';

      ?>
        <!--parti di registrazioen-->
        <div class="containerMain">
        <button class="backButton" ><a href="./personalPage.php"> Back </a></button>
            <div class="containerLogin">
                <form action="./personalPage.php" method="POST">
                     <div class="input">
                         <label for="date">Inserisci data</label>
                         <input type="date" id="date" name="date">
                     </div>
                     <div class="input">
                         <label for="title">Inserisci titolo</label>
                         <input type="text" placeholder="Event"  id="title" name="title">
                    </div>
                    <div class="input">
                         <label for="participants">Inserisci partecipanti</label>
                         <input type="text" placeholder="Inserisci partecipanti" id="participants" name="participants">
                    </div>
                    <div class="input">
                         <label for="description">Inserisci la descrizione</label>
                         <input type="text" placeholder="Scrivila qui" id="description" name="description">
                    </div>
                    <div class="buttonGo">
                    <button type="submit" name="login">CREA EVENTO</button>
                    </div>
                </form>   
            </div>
        </div>
  

</body>
</html>