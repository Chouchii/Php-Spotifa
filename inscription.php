
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

      <form name="form1" method="POST" action="">
                  Ton pseudo : <input type="text" name= "pseudo" value="<?php if (isset($_POST['pseudo'])) echo htmlentities(trim($_POST['pseudo'])); ?>"><br>
                  Ton mot de passe : <input type="password" name= "mdp" value ="<?php if (isset($_POST['mdp'])) echo htmlentities(trim($_POST['mdp'])); ?>"><br>
                  Confirme ton mot de passe : <input type="password"  name="confirmation" value="<?php if (isset($_POST['confirmation'])) echo htmlentities(trim($_POST['confirmation'])); ?>"><br />
                  Ton mail : <input type="text" name="email" value="<?php if (isset($_POST['email'])) echo htmlentities(trim($_POST['email'])); ?>"><br />
                  Ton adresse : <input type="text" name="adresse" value="<?php if (isset($_POST['adresse'])) echo htmlentities(trim($_POST['adresse'])); ?>"><br />
                  Ton telephone : <input type="text" name="telephone" value="<?php if (isset($_POST['telephone'])) echo htmlentities(trim($_POST['telephone'])); ?>"><br />
                  <input type="submit" value="Inscription" name="inscription" >
          </form>



               <?php  

                  if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription')
                  {

                      if ((isset($_POST['pseudo']) && !empty($_POST['pseudo'])) && (isset($_POST['mdp']) && !empty($_POST['mdp'])) && (isset($_POST['confirmation']) && !empty($_POST['confirmation'])) && (isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['adresse']) && !empty($_POST['adresse'])) && (isset($_POST['telephone']) && !empty($_POST['telephone'])))
                      {

                          if ($_POST['mdp'] != $_POST['confirmation'])
                          {
                            $erreur = "Les deux mots de passe sont differents.";
                          }
                          else
                          {

                            require 'general/configure.php';

                            $db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );

                            $db_name = "spotifa";
                            $db_found = mysqli_select_db($db_connexion, $db_name );   

                            $sql_requete = 'SELECT count(*) FROM users WHERE pseudo="'.mysqli_escape_string($db_connexion, $_POST['pseudo']).'"';
                            $req = mysqli_query($db_connexion,$sql_requete) or die('Erreur SQL !<br />'.$sql_requete.'<br />'.mysqli_error($db_connexion));

                            $data = mysqli_fetch_array($req);

                            $md5pass = md5($_POST['mdp']);
                                 
                                if ($data[0] == 0)
                                {
                                  $sql_requete = 'INSERT INTO users (pseudo,address,mail,phone,mdp)VALUES("'.mysqli_escape_string($db_connexion,$_POST['pseudo']).'","'.mysqli_escape_string($db_connexion,$_POST['adresse']).'","'.mysqli_escape_string($db_connexion,$_POST['email']).'","'.mysqli_escape_string($db_connexion,$_POST['telephone']).'","'.mysqli_escape_string($db_connexion,$md5pass).'")';

                                    mysqli_query($db_connexion, $sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysqli_error($db_connexion));

                                    session_start();
                                    $_SESSION['pseudo'] = $_POST['pseudo'];
                                    header('Location:accueil.php');
                                    exit();

                                }
                                else 
                                {
                                  $erreur = 'Un membre possède déjà ce login.';
                                }

                          }

                      }
                      else
                      {
                        $erreur = "Vous n'avez pas rempli tous les champs!";
                      }
                  }      



                  if (isset($erreur))
                  {
                    echo '<br />',$erreur;
                  }  

               ?>
 
   </body>

</html>