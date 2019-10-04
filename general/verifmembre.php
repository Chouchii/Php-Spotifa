<?php 

      session_start();



      if (empty($_SESSION['pseudo']))
      {
        header ('Location:accueil.php');
        exit();
      }
      else
      {
         echo "Bienvenue " . htmlentities(trim($_SESSION['pseudo']))  ."!<br>";
      }





      if(isset($_SESSION['pseudo'])){

          echo "<form name='form3' method='POST' action=''>
           <input type='submit' value='Deconnexion' name='deconnexion'><br>
          </form>" ;
      }





      if (isset($_POST["deconnexion"]))
      {
        session_destroy();
        header('Location:accueil.php');
        exit();
      }

   
?>  