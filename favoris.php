
<?php include "general/verifmembre.php" ?> 

<!DOCTYPE html>

<html>
  <head>
    <title>SPOTIFA</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/cssartiste.css" />
    <link href="https://fonts.googleapis.com/css?family=Charm" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:regular" rel="stylesheet">
  </head>

  <body>

    
    <?php include "general/menu.php" ?>

      <h1>Mes favoris</h1>




          <?php  
      
            require 'general/configure.php';

            $db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );
              
            $db_name = "spotifa";
            $db_found = mysqli_select_db($db_connexion, $db_name );



                if($db_found)
                {

                             //recupere dans une variable ref user 

                            $sql_requete = "SELECT users.ref_user, users.pseudo FROM users WHERE users.pseudo = '".$_SESSION['pseudo'] ."'";
                            $result_requete = mysqli_query($db_connexion, $sql_requete);

                            while($db_field = mysqli_fetch_assoc($result_requete) )
                            {
                                $iduser=$db_field['ref_user'];
                            }   
                  


                
                    
                          $sql_requete = "SELECT artists.*, songs.*, liked.* FROM artists INNER JOIN songs ON artists.id_artist = songs.id_artist INNER JOIN liked ON songs.id_song = liked.id_song WHERE liked.ref_user = ".$iduser;

                          $result_requete = mysqli_query($db_connexion, $sql_requete);

                            while($db_field = mysqli_fetch_assoc($result_requete) )
                            {
                              echo "<br>";
                              echo "<a href='descriptionmusique.php?id=".$db_field['id_song']."'>" .$db_field['titre'] ." " ."<br>";  
                              echo "<a href='ficheartiste.php?id=".$db_field['id_artist']."'>" .$db_field['nom'] . "</a><br>";
                            } 

                  
                }
                else
                {
                  echo $db_name . " database not found";
                }
            
                mysqli_close($db_connexion);

          ?>
 
   </body>

</html>