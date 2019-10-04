
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
 	
    	<h1>En savoir plus</h1>



		<?php 

			echo "Présentation :<br>";



				if (isset($_GET["id"]))
				{
				
					require 'general/configure.php';
					$db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );

					
					$db_name = "spotifa";
					$db_found = mysqli_select_db($db_connexion, $db_name );


						if($db_found)
						{

							$sql_requete2 = "SELECT artists.nom,artists.gender,artists.age FROM artists WHERE artists.id_artist= ".$_GET['id']."";
							$result_requete2 = mysqli_query($db_connexion, $sql_requete2);

									while($db_field2 = mysqli_fetch_assoc($result_requete2) )
									{

										echo "<br>";
										echo $db_field2['nom'] . "<br>";
										echo $db_field2['gender'] . "<br>";
										echo $db_field2['age'] . "<br>";
									}

										echo "<br>Ses 3 dernier single :<br>";

							$sql_requete = "SELECT songs.titre FROM songs INNER JOIN artists ON artists.id_artist = songs.id_artist WHERE artists.id_artist= ".$_GET['id']." ORDER BY songs.release_date DESC LIMIT 3";
									$result_requete = mysqli_query($db_connexion, $sql_requete);

									
											while($db_field = mysqli_fetch_assoc($result_requete) )
											{

												echo "<br>";					
												echo $db_field['titre'];						
											}

						}
						else
						{
							echo $db_name . " database not found";
						}

				mysqli_close($db_connexion);

				}


		?>
 
	</body>

</html>