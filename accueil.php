<?php session_start(); ?>
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


        <h1>Bienvenue sur SPOTIFA</h1>
          <h2> Veuillez vous connecter pour accéder au site : </h2>


           <form name="form1" method="POST" action="">
              Pseudo : <input type="text" name ="pseudo" value="<?php if (isset($_POST['pseudo'])) echo htmlentities(trim($_POST['pseudo'])); ?>"><br> 
               Mot de passe : <input type="password" name ="mdp" value= "<?php if (isset($_POST['mdp'])) echo htmlentities(trim($_POST['mdp'])); ?>"><br>
              <input type="submit" value="Connexion" name="connexion" ><br>
              Nouveau ? Inscrivez vous ici : <input type="submit" value="S'inscrire" name="inscription" >
           </form>




            <?php 

              if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion')
              {

                  if ((isset($_POST['pseudo']) && !empty($_POST['pseudo'])) && (isset($_POST['mdp']) && !empty($_POST['mdp'])))
                  {

                 
                    require 'general/configure.php';
                  
                    $db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );

                    $db_name = "spotifa";
                    $db_found = mysqli_select_db($db_connexion, $db_name );

                    $md5pass = md5($_POST['mdp']);

                    $sql_requete = 'SELECT count(*) FROM users WHERE pseudo="'.mysqli_escape_string($db_connexion,$_POST['pseudo']).'" AND mdp="'.mysqli_escape_string($db_connexion,$md5pass).'"';

                    $req = mysqli_query($db_connexion,$sql_requete) or die('Erreur SQL !<br />'.$sql_requete.'<br />'.mysqli_error($db_connexion));
                    $data = mysqli_fetch_array($req);

                    mysqli_free_result($req);
                    mysqli_close($db_connexion);

                        if ($data[0] == 1)
                        {
                          $_SESSION['pseudo'] = $_POST['pseudo'];
                          header('Location:membreplaylist.php');
                          exit();
                        }
                        
                        elseif ($data[0] == 0)
                        {
                          $erreur = 'Compte non reconnu.';
                        }
            
                        else
                        {
                          $erreur = 'Problème dans la base de données : plusieurs membres ont les mêmes identifiants de connexion.';
                        }
                  }
                  else
                  {
                    $erreur = 'Au moins un des champs est vide.';
                  }
              }


              if (isset($erreur)) echo '<br /><br />',$erreur;


              if (isset($_POST['inscription']))
              {
                 header("Location:inscription.php"); 
              }

            ?>

	
 
   </body>

</html>