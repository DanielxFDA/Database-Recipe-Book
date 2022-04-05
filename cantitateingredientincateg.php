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
		$nume_ing= $_POST['nume_ing'];
		$nume_ing = trim($nume_ing);
		$nume_cat = $_POST['nume_cat'];
		$nume_cat = trim($nume_cat);
		if(!$nume_cat or !$nume_ing){
			echo  '<h1>Nu ati introdus un ingredient sau o categorie valida.</h1>';
		}
		$nume_ing = addslashes($nume_ing);
		$nume_cat = addslashes($nume_cat);
		$conexiune = new mysqli("localhost", "root", "", "retete");
		if($conexiune->connect_error){
			die ('Eroare conectare: '. $conexiune->connect_error);
		}
		
		$query = "SELECT SUM(cantitate) AS Cantitate, um AS UM
					FROM set_ingrediente
					WHERE ingred_id = (SELECT ingred_id FROM ingredient WHERE ingredient = '$nume_ing') AND reteta_id IN (SELECT reteta_id FROM reteta WHERE categ_id = (SELECT categ_id FROM categorie WHERE tip = '$nume_cat'))
							GROUP BY um";
		$result = $conexiune->query($query);
		if(!$result){
			die('Interogare gresita'.mysqli_error($conexiune));
		}
		$total_result = $conexiune->affected_rows;
		if(!$total_result){
			echo 'Niciun rezultat returnat, incercati alta valoare.';
		}else {
			echo '<h1>Cantitatea totala folosita pentru ingredientul ' .$nume_ing.' in retetele din categoria ' .$nume_cat. ' in functie de u.m. este: </h1>';
			echo '<table id="set_ingrediente"
			<tr align ="center">
			<th align="center">Cantitate</th>
			<th align="center">Unitate de masura</th>
			';
			$i=0;
			while($object = $result->fetch_assoc()){
				echo '<tr align = "center">';
				echo '<td>'.stripcslashes($object['Cantitate']).'</td>';
				echo '<td>'.stripcslashes($object['UM']) .'</td>';
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