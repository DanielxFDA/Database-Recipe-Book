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
		/*scriptul php*/
		$conexiune = new mysqli("localhost", "root", "", "retete");
		if($conexiune->connect_error){
			die ('Eroare conectare: '. $conexiune->connect_error);
		}
		
		$query = "SELECT nume, descriere, timp_preparare
					FROM reteta r1
					WHERE vegetariana IN ('D') AND timp_preparare < ALL(SELECT r2.timp_preparare
                                                    FROM reteta r2
                                                    WHERE r1.reteta_id != r2.reteta_id)";
		$result = $conexiune->query($query);
		if(!$result){
			die('Interogare gresita'.mysqli_error($conexiune));
		}
		$total_result = $conexiune->affected_rows;
		if(!$total_result){
			echo 'Niciun rezultat returnat, incercati alta valoare.';
		}else {
			echo '<h1>Retetele vegetariene cu timp minim de preparare sunt:</h1>';
			echo '<table id="retete"
			<tr align ="center">
			<th align="center">Nume</th>
			<th align="center">Descriere</th>
			<th align="center">Timp_preparare</th>
			';
			$i=0;
			while($object = $result->fetch_assoc()){
				echo '<tr align = "center">';
				echo '<td>'.stripcslashes($object['nume']) .'</td>';
				echo '<td>'.stripcslashes($object['descriere']) .'</td>';
				echo '<td>'.stripcslashes($object['timp_preparare']) .'</td>';
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