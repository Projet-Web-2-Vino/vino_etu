<!DOCTYPE HTML>
<html>
	
	<head>
		<meta charset="UTF-8" />	
	</head>
	<body>
		<h2>Importation de la SAQ</h2>
		<a href='/'>Retour liste bouteilles</a>
<?php
	


	foreach ($data as $cle => $bouteille) 	//permet d'importer séquentiellement plusieurs pages.
	{
		echo $bouteille['nom'];
		echo "importation : ". $cle. "<br>";
		
	
	}


	
	
	

?>
</body>
</html>