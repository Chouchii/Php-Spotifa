
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
 	
 		<h1>Les artistes</h1>


 			<form name="form1" method="get" action="">
	            <input type="text" value= "Artiste" name ="artiste">
	            <input type="submit" value="Rechercher" name="recherche" >
			</form>
  		


	    	<section id="nomartiste">

			<table>
			<tr>
				<th>Artiste</th>
				<th>Album</th>
			</tr>
			
		
		
	    	<?php  

				require 'general/configure.php';
				
				$db_connexion = mysqli_connect(DB_SERVER, DB_USER, DB_PASS );

				$db_name = "spotifa";
				$db_found = mysqli_select_db($db_connexion, $db_name );



					if($db_found)
					{
					
					$sql_requete = "SELECT artists.*, album.*  FROM artists INNER JOIN songs ON artists.id_artist = songs.id_artist INNER JOIN album ON album.id_album = songs.id_album GROUP BY album.title ORDER BY artists.nom";

					$result_requete = mysqli_query($db_connexion, $sql_requete);

					$group="";

					
							while($db_field = mysqli_fetch_assoc($result_requete) )
							{
									if(isset($group) AND $group == $db_field['nom'])
									{
										echo "<td>" . $db_field['title'] . "</td></tr>";
									}
									else
									{
										$group=$db_field['nom'];
										echo "<tr><td><a href='ficheartiste.php?id=".$db_field['id_artist']."'>" . $db_field['nom'] . "</a></td>";
										echo "<td>". $db_field['title'] . "</td>";
									}

									echo "<br>";	
							}
						
					}
					else
					{
						echo $db_name . " database not found";
					}
						



			// partie recherche


					if (isset($_GET['recherche']))
					{
			  			$artiste = $_GET['artiste'];
			  			$artiste =mb_strtolower($artiste);
			  			$artiste=ucfirst($artiste);

		
							if($db_found)
							{
							
							 	$sql_requete = "SELECT * FROM artists WHERE nom = '". $artiste."'";
								$result_requete = mysqli_query($db_connexion, $sql_requete);

										while($db_field = mysqli_fetch_assoc($result_requete) )
										{

												if ($artiste == $db_field['nom'])
												{
													 header("Location:ficheartiste.php?id=".$db_field['id_artist']); 
													 exit();
												}
													
										}	
										echo "Artiste introuvable";
							}			
							else
							{
								echo $db_name . " database not found";
							}

					mysqli_close($db_connexion);
						
					}
						
			?>

			</table>

			</section>
 
  </body>

</html>


