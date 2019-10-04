
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

      <h1>Les musiques</h1>

         <form name="form3" method="get" action="">
            <input type="text" value= "Musique" name ="musique">
            <input type="submit" value="Rechercher" name="recherche" >
            <input type="submit" value="Favoris" name="favoris">
        </form>



          <?php  


            ob_start();
       
              require 'general/configure.php';

              $db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );
              
              $db_name = "spotifa";
              $db_found = mysqli_select_db($db_connexion, $db_name );

              $iduser="";
              $idsong="";
              $idsongplay="";
              $idplaylist="";
              

                  if($db_found)
                  {

                       $sql_requete = "SELECT artists.*, songs.*, users.pseudo AS pseudoo, liked.id_song AS idlike FROM artists INNER JOIN songs ON artists.id_artist = songs.id_artist LEFT JOIN liked ON songs.id_song = liked.id_song LEFT JOIN users ON users.ref_user= liked.ref_user";
                      $result_requete = mysqli_query($db_connexion, $sql_requete);

       
                      while($db_field = mysqli_fetch_assoc($result_requete) )
                      {
                           echo "<br>";
                           echo "<a href='descriptionmusique.php?id=".$db_field['id_song']."'>" .$db_field['titre'] ." " ."<br>";  
                           echo "";
                           echo "<a href='ficheartiste.php?id=".$db_field['id_artist']."'>" .$db_field['nom'] . "</a>"."</a><form name='form2' method='POST' action=''> <input type='submit' id='like' value='' name=''><input type='hidden' name='like' value=".$db_field['id_song']."></form>";

                              if (isset($db_field['idlike']) AND $db_field['pseudoo'] == $_SESSION['pseudo'])
                            {
                                echo "<img src='images/coeur.png'> ";
                            }
                                echo "<form name='form3' method='POST' action=''><input type='submit' name='' value='ajouter à une playlist'><input type='hidden' name='ajoutplay' value=".$db_field['id_song'].">";
                                echo "</form><hr>";

                      } 



                      // partie ajout playlist

                      if (isset($_POST['ajoutplay']))
                      {



                        
                            //recupere dans une variable idsongplay

                          $sql_requete = "SELECT songs.id_song FROM songs WHERE songs.id_song = '".$_POST['ajoutplay'] ."'";
                          $result_requete = mysqli_query($db_connexion, $sql_requete);

               
                          while($db_field = mysqli_fetch_assoc($result_requete) )
                          {
                            $idsongplay=$db_field['id_song'];
                          }




                             //recupere dans une variable iduser 

                          $sql_requete = "SELECT users.ref_user, users.pseudo FROM users WHERE users.pseudo = '".$_SESSION['pseudo'] ."'";
                          $result_requete = mysqli_query($db_connexion, $sql_requete);

                          while($db_field = mysqli_fetch_assoc($result_requete) )
                          {
                              $iduser=$db_field['ref_user'];
                          }


                          $sql_requete = "SELECT * FROM playlists WHERE ref_user='".$iduser."'";
                          $result_requete = mysqli_query($db_connexion, $sql_requete);

                          echo "<form method='POST' class='form-horizontal'>
                          <fieldset>

                          <!-- Choix Playlist -->
                          <legend>Form Name</legend>

                          <!-- Playlist ? -->
                          <div class='form-group'>
                          <label class='col-md-4 control-label' for='selectbasic'>Select Basic</label>
                          <div class='col-md-4'>
                          <select id='selectbasic' name='selectbasic' class='form-control'>";


                          while($db_field = mysqli_fetch_assoc($result_requete) )
                          {
                          
                              echo "<option value='".$db_field['id_playlist']."'>".$db_field['name']."</option>";
                          }
                                    
                          echo "</select>
                          </div>
                          </div>

                          <div class='form-group'>
                          <label class='col-md-4 control-label' for='button1id'>Valider ?</label>
                          <div class='col-md-8'>
                            <button type='submit' id='button1id' name='buttonvalider' class='btn btn-success'>Valider</button>
                            <button type='submit' id='button2id' name='buttonannuler' class='btn btn-annuler'>Annuler</button>
                            <input type='hidden' value='".$_POST['ajoutplay']."' name='ajoutplay'>
                          </div>
                          </div>

                          </fieldset>
                          </form>";

                          if (isset($_POST['buttonvalider']))
                          {
                              $idplaylist=$_POST['selectbasic'];

                          $sql_requete2 = "INSERT INTO playlist_content (id_playlist,id_song) VALUES('".$idplaylist."','".$idsongplay."')";

                          mysqli_query($db_connexion, $sql_requete2) or die('Erreur SQL !'.$sql_requete2.'<br />'.mysqli_error($db_connexion));

                          header('Location:musique.php');
                          exit(); 
                          }
                            
                      }







                    // partie like

                      if (isset($_POST['like']))
                      {
                              
                              
                              //recupere dans une variable iduser 

                            $sql_requete = "SELECT users.ref_user, users.pseudo FROM users WHERE users.pseudo = '".$_SESSION['pseudo'] ."'";
                            $result_requete = mysqli_query($db_connexion, $sql_requete);

                            while($db_field = mysqli_fetch_assoc($result_requete) )
                            {
                                $iduser=$db_field['ref_user'];
                            }




                              //recupere dans une variable id song

                            $sql_requete = "SELECT songs.id_song FROM songs WHERE songs.id_song = '".$_POST['like'] ."'";
                            $result_requete = mysqli_query($db_connexion, $sql_requete);

               
                            while($db_field = mysqli_fetch_assoc($result_requete) )
                            {
                              $idsong=$db_field['id_song'];
                            }




                                //INSERT dans liked en evitant les doublons

                            $sql_requete = "SELECT id_song, ref_user FROM liked WHERE id_song = ".$idsong." AND  ref_user = ".$iduser;

                            $result_requete = mysqli_query($db_connexion, $sql_requete);

                              if (mysqli_num_rows($result_requete)==0)
                              {
                                    
                              $sql_requete = "INSERT INTO liked VALUES('".$idsong."','".$iduser ."')";
                          
                              mysqli_query ($db_connexion,$sql_requete) or die ('Erreur SQL !'.$sql_requete.'<br />'.mysqli_error($db_connexion));


                              }

                              header("Location:musique.php");
                              exit();
                        
                      }



                              //favoris

                      if (isset($_GET["favoris"]))
                      {
                          header("Location:favoris.php");
                          exit();
                      }   





                       // partie recherche

                      if (isset($_GET['recherche']))
                      {

                        $musique= $_GET['musique'];
                        $musique=mb_strtolower($musique);
                        $musique=ucfirst($musique);

          
                              $sql_requete = "SELECT * FROM songs WHERE titre = '". $musique."'";
                              $result_requete = mysqli_query($db_connexion, $sql_requete);

                        
                            while($db_field = mysqli_fetch_assoc($result_requete) )
                            {
                                    
                              if ($musique == $db_field['titre'])
                              {
                                  header("Location:descriptionmusique.php?id=".$db_field['id_song']); 
                                        exit();
                              }
                                
                            } 

                            echo "Musique introuvable";
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