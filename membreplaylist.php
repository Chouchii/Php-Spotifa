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


	  <?php  include "general/menu.php" ?>

      <h1>Mes playlists</h1>

         <form name="form" method="post" action="">
            <input type="submit" value="Nouvelle playlist" name="newplaylist">
           <!--  <input type="submit" value="Supprimer" name="Supprimer">
            <input type="submit" value="Supprimer" name="Supprimer"> -->
        </form>

      <?php  

        require 'general/configure.php';

                $db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );
                
                $db_name = "spotifa";
                $db_found = mysqli_select_db($db_connexion, $db_name );

                $iduser="";


                    if($db_found)
                    {

                      $sql_requete = "SELECT playlists.*, songs.*, playlists.id_playlist AS idplaylist FROM playlists INNER JOIN playlist_content ON playlists.id_playlist = playlist_content.id_playlist INNER JOIN songs ON songs.id_song = playlist_content.id_song INNER JOIN users ON users.ref_user = playlists.ref_user WHERE users.pseudo = '".$_SESSION['pseudo'] ."'";
                      $result_requete = mysqli_query($db_connexion, $sql_requete);

                      $group="";
       
                            while($db_field = mysqli_fetch_assoc($result_requete) )
                            {

                               if (isset($group) AND $group == $db_field['name'])
                               {
                                  echo $db_field['titre']."<br><form name='form' method='POST' action=''><input type='submit' name='' value='Supprimer la musique'><input type='hidden' name='supprimermusique' value=".$db_field['id_song']."></form>";
                               }
                               else
                               {
                                  $group=$db_field['name'];

                                  echo $db_field['name']."</form><form name='form2' method='POST' action=''><input type='submit' name='' value='Modifier le nom'><input type='hidden' name='modif' value=".$db_field['idplaylist']."></form><form name='form3' method='POST' action=''><input type='submit' name='' value='Supprimer la playlist'><input type='hidden' name='supprimerplay' value=".$db_field['idplaylist'].">";

                                  echo " crée en ". $db_field['creation_date']."<br>";
                                  echo $db_field['titre']."<br><form name='form' method='POST' action=''><input type='submit' name='' value='Supprimer la musique'><input type='hidden' name='supprimermusique' value=".$db_field['id_song']."></form>";
                               }
                              
                            }


                              //modif le nom

                            if (isset($_POST['modif']))
                            {
                              echo "<form name='form4' method='POST' action=''>
                              <input type='text' name='new' value='Nouveau nom'>
                              <input type='submit' name='ok' value='ok'>
                              <input type='hidden' name='modif' value='".$_POST['modif']."'>";

                                if (isset($_POST['ok']))
                                {
                                    $sql_requete = "UPDATE playlists SET name ='"
                                    . $_POST['new']
                                    . "' WHERE id_playlist ="
                                    . $_POST['modif'];


                                   mysqli_query($db_connexion, $sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysqli_error($db_connexion));

                                    header("Location:membreplaylist.php");
                                    exit();

                                }
                            }




                              //supprimer une musique

                            if (isset($_POST['supprimermusique']))
                            {
                                $sql_requete = "DELETE FROM playlist_content WHERE id_song ='".$_POST['supprimermusique']."'";

                                mysqli_query($db_connexion, $sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysqli_error($db_connexion));

                                header("Location:membreplaylist.php");
                                exit(); 

                            }



                                //supprimer la playlist
       
                            if (isset($_POST['supprimerplay']))
                            {

                               $sql_requete = "DELETE FROM playlist_content WHERE id_playlist ='".$_POST['supprimerplay']."'";

                               mysqli_query($db_connexion, $sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysqli_error($db_connexion));

                               $sql_requete = "DELETE FROM playlists WHERE id_playlist ='".$_POST['supprimerplay']."'";

                                mysqli_query($db_connexion, $sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysqli_error($db_connexion));

                                header("Location:membreplaylist.php");
                                exit(); 

                            }






                              // ajout de playlist

                            if (isset($_POST["newplaylist"]))
                            {
                              echo "<form name='form2' method='post' action=''>
                              <input type='text' value='nom de ma playlist' name='nameplay'>
                              <input type='submit' value='Envoyer' name='envoyer'>
                               <input type='hidden' value='Envoyer' name='newplaylist'>
                              </form>";

                              echo "N'oubliez pas de rajouter vos musiques ensuite ;) Direction ==> musique ! ";

                                if (isset($_POST['envoyer']))
                                {


                                   // recupere dans une variable ref user 

                                  $sql_requete = "SELECT users.ref_user, users.pseudo FROM users WHERE users.pseudo = '".$_SESSION['pseudo'] ."'";

                                  $result_requete = mysqli_query($db_connexion, $sql_requete);

                                    while($db_field = mysqli_fetch_assoc($result_requete) )
                                    {
                                        $iduser=$db_field['ref_user'];
                                    }



                                  $sql_requete2 = 'INSERT INTO playlists (name,creation_date,ref_user) VALUES("'.mysqli_escape_string($db_connexion,$_POST['nameplay']).'","'.date('Y').'","'.$iduser.'")';

                                  mysqli_query($db_connexion, $sql_requete2) or die('Erreur SQL !'.$sql_requete2.'<br />'.mysqli_error($db_connexion));


                                }
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



