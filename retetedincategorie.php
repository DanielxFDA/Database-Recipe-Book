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
		$nume_ret= $_POST['nume_ret'];
		$nume_ret = trim($nume_ret);
		if(!$nume_ret){
			echo  '<h1>Nu ati introdus un ingredient valid</h1>';
		}
		$nume_ret = addslashes($nume_ret);
		$conexiune = new mysqli("localhost", "root", "", "retete");
		if($conexiune->connect_error){
			die ('Eroare conectare: '. $conexiune->connect_error);
		}
		
		$query = "SELECT reteta_id, nume, descriere, categ_id, vegetariana, timp_preparare,portii, autor
						FROM reteta
						WHERE categ_id =  (SELECT r2.categ_id
                  							 FROM reteta r2
                   							 WHERE r2.nume = '$nume_ret')";
		$result = $conexiune->query($query);
		if(!$result){
			die('Interogare gresita'.mysqli_error($conexiune));
		}
		$total_result = $conexiune->affected_rows;
		if(!$total_result){
			echo 'Niciun rezultat returnat, incercati alta valoare.';
		}else {
			echo '<h1>Retete din aceeasi categorie cu reteta ' .$nume_ret.' sunt: </h1>';
			echo '<table id="retete"
			<tr align ="center">
			<th align="center">Reteta_id</th>
			<th align="center">Nume</th>
			<th align="center">Descriere</th>
			<th align="center">Categ_id</th>
			<th align="center">Vegetariana</th>
			<th align="center">Timp preparare</th>
			<th align="center">Portii</th>
			<th align="center">Autor</th>
			';
			$i=0;
			while($object = $result->fetch_assoc()){
				echo '<tr align = "center">';
				echo '<td>'.stripcslashes($object['reteta_id']).'</td>';
				echo '<td>'.stripcslashes($object['nume']) .'</td>';
				echo '<td>'.stripcslashes($object['descriere']) .'</td>';
				echo '<td>'.stripcslashes($object['categ_id']) .'</td>';
				echo '<td>'.stripcslashes($object['vegetariana']) .'</td>';
				echo '<td>'.stripcslashes($object['timp_preparare']) .'</td>';
				echo '<td>'.stripcslashes($object['portii']) .'</td>';
				echo '<td>'.stripcslashes($object['autor']) .'</td>';
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