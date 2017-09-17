<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title></title>
	<style>
	.center {
	margin: 15px auto;
	width: 100%;
	text-align: center;
	}
	.movie {
	font-style: italic;
	text-align: center;
	width: 100%;
	margin: 0 auto 30px;
	}
	p {
	margin: 3px;
	}
	</style>
</head>
<body>
	<div class="center">	
	<?php
	//izbor slova na vrhu stranice
	print "|";
	foreach (range('A', 'Z') as $letter) {
		print " <a href='index.php?letter=".$letter."'>".$letter."</a> |";
	}
	?>
	</div>
	<div>
	<?php
	//spaja se na server i bazu
	$mysqli = new mysqli("localhost", "root", "", "kolekcija");

	if($mysqli->connect_errno) {
		print "Error ".$mysqli->connect_errno.": ".$mysqli->connect_error;
	}
	
	//uzima slovo iz GET parametra i šalje upit bazi
	if(isset($_GET["letter"])) {
		$letter = $_GET["letter"];
		$sql = "SELECT * FROM filmovi LEFT JOIN zanr ON filmovi.id_zanr=zanr.id WHERE naslov LIKE '".$letter."%'";
			
		$result = $mysqli->query($sql);
		
		//ako je vraćen rezultat, sprema rezultat u polje i ispisuje
		//bez if provjere bi izbacio grešku na stranici ako vrati 0 redova iz baze, ovako samo ništa ne ispiše
		if($result->num_rows) {
			while($row = $result->fetch_assoc()) {
				$movies[] = $row;
			}

			foreach($movies as $movie) {
				print "<div class='movie'>";
				print "<img src='/seminar/slike/".$movie['slika']."' alt='".$movie['slika']."'>";
				print "<p>".$movie['naslov']." (".$movie['godina'].")</p>";
				print "<p>Trajanje: ".$movie['trajanje']." min</p>";
				print "</div>";
			}
		}
	}
	?>
	</div>
</body>
</html>