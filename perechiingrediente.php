<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="cartearetetelor.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cartea retetelor</title>
</head>
<body>
	<header> <a href="cartea_retetelor.html"><img src="logo.png"></a>
		<ul>
			<li><a href="retetevegnveg.html">Retete dupa tip</a></li>
			<li><a href="ingredienteculitere.html">Ingrediente cu a treia litera data</a></li>
			<li><a href="retetecuingredient.html">Retete cu un anumit ingredient</a></li>
			<li><a href="perechiingrediente.html">Perechi de ingrediente</a></li>
			<li><a href="retetevegtimpmin.html">Retete vegetariene cu timp de preparare minim</a></li>
			<li><a href="retetedincategorie.html">Retete din aceeasi categorie cu reteta data</a></li>
			<li><a href="timppreparare.html">Timp de preparare minim, mediu, maxim pe categorii de retete</a></li>
			<li><a href="cantitateingredientincateg.html">Cantitatea de ingredient folosita intr-o categorie</a></li>
		</ul>
	</header>
	<main>
		<?php
		$conexiune = new mysqli("localhost", "root", "", "retete");
		if($conexiune->connect_error){
			die ('Eroare conectare: '. $conexiune->connect_error);
		}
		
		$query = "SELECT i1.ingredient as ing1, i2.ingredient as ing2
					FROM set_ingrediente a INNER JOIN set_ingrediente b ON (a.reteta_id = b.reteta_id) JOIN ingredient i1 ON(b.ingred_id = i1.ingred_id) JOIN ingredient i2 ON(a.ingred_id = i2.ingred_id)
					WHERE a.cantitate = b.cantitate AND a.um = b.um AND a.ingred_id > b.ingred_id";
		$result = $conexiune->query($query);
		if(!$result){
			die('Interogare gresita'.mysqli_error($conexiune));
		}
		$total_result = $conexiune->affected_rows;
		if(!$total_result){
			echo 'Niciun rezultat returnat, incercati alta valoare.';
		}else {
			echo '<h1>Perechile de ingrediente folosite la aceeasi reteta in aceeasi cantitate si unitate de masura sunt: </h1>';
			echo '<table id="set_ingrediente"
			<tr align ="center">
			<th align="center">Ingredient I</th>
			<th align="center">Ingredient II</th>
			';
			$i=0;
			while($object = $result->fetch_assoc()){
				echo '<tr align = "center">';
				echo '<td>'.stripcslashes($object['ing1']) .'</td>';
				echo '<td>'.stripcslashes($object['ing2']) .'</td>';
				echo '</tr>';
				$i++;
			}
			echo '</table>';
		}
		$conexiune->close();
		?>

	</main>
</body>
</html>