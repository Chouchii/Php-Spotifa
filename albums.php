
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

      <h1>Les albums</h1>




          <?php  
      
            require 'general/configure.php';

            $db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );
              
            $db_name = "spotifa";
            $db_found = mysqli_select_db($db_connexion, $db_name );



                if($db_found)
                {
                  
                  $sql_requete = "SELECT * FROM album INNER JOIN songs ON album.id_album = songs.id_album";
                  $group="";
                  $result_requete = mysqli_query($db_connexion, $sql_requete);

                 
                      while($db_field = mysqli_fetch_assoc($result_requete) )
                      {

                          if (isset($group) AND $group == $db_field['title'])
                          {
                            echo $db_field['titre'] . "<br>";
                          }
                          else
                          { 
                            $group=$db_field['title'];
                            echo "<hr>".$db_field['title'] . "<br>";
                            echo $db_field['titre'] . "<br>";
                          }
                          echo "<br>";
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