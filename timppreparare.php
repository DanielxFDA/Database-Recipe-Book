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
		$nume_cat = $_POST['nume_cat'];
		$nnume_cat = trim($nume_cat);
		if(!$nume_cat){
			echo  '<h1>Nu ati introdus un ingredient valid</h1>';
		}
		$nume_cat = addslashes($nume_cat);
		$conexiune = new mysqli("localhost", "root", "", "retete");
		if($conexiune->connect_error){
			die ('Eroare conectare: '. $conexiune->connect_error);
		}
		
		$query = "SELECT categ_id, MIN(CONVERT(SUBSTR(timp_preparare,1,3),double)) AS tmin, ROUND(AVG(CONVERT(SUBSTR(timp_preparare,1,3),double)),0) AS tmed, MAX(CONVERT(SUBSTR(timp_preparare,1,3),double)) as tmax
						FROM reteta
						Where categ_id = (SELECT categ_id FROM categorie c1 WHERE c1.tip = '$nume_cat') group by categ_id";
		$result = $conexiune->query($query);
		if(!$result){
			die('Interogare gresita'.mysqli_error($conexiune));
		}
		$total_result = $conexiune->affected_rows;
		if(!$total_result){
			echo 'Niciun rezultat returnat, incercati alta valoare.';
		}else {
			echo '<h1>Timpul de preparare minim, mediu si maxim pentru categoria ' .$nume_cat.': </h1>';
			echo '<table id="reteta"
			<tr align ="center">
			<th align="center">Categ_id</th>
			<th align="center">Timp minim</th>
			<th align="center">Timp maxim</th>
			<th align="center">Timp mediu</th>
			';
			$i=0;
			while($object = $result->fetch_assoc()){
				echo '<tr align = "center">';
				echo '<td>'.stripcslashes($object['categ_id']).'</td>';
				echo '<td>'.stripcslashes($object['tmin']) .'</td>';
				echo '<td>'.stripcslashes($object['tmax']) .'</td>';
				echo '<td>'.stripcslashes($object['tmed']) .'</td>';
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