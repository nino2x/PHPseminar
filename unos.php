<?php
//spaja se na server i bazu
$mysqli = new mysqli("localhost", "root", "", "kolekcija");

if($mysqli->connect_errno) {
	print "Error ".$mysqli->connect_errno.": ".$mysqli->connect_error;
}

//uzima id filma iz GET parametra i briše ga iz baze
//razlog zašto je ovo na početku je jer se header mora izvršit prije nego html kod bude ispisan na stranici
if(isset($_GET["delete"])) {
	//prvo traži ime slike za film koji treba obrisati
	$delete_row = $_GET["delete"];
	$sql = "SELECT slika FROM filmovi WHERE id='".$delete_row."'";
	$result = $mysqli->query($sql);
	$slika = $result->fetch_assoc();
	$result->close();
	
	//onda briše red iz baze i briše sliku iz foldera slike
	//header onda preusmjerava GET link npr "unos.php?delete=11" na "unos.php"
	//ovako nema problema ako korisnik izbriše film i odmah nakon toga napravi refresh stranice
	$sql = "DELETE FROM filmovi WHERE id='".$delete_row."'";
	$result = $mysqli->query($sql);
	unlink(realpath(dirname(__FILE__)).'/slike/'.$slika['slika']);
	header('Location: '.$_SERVER["PHP_SELF"]);
	die;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8 />
	<title></title>
	<style>
	div {
	margin: 20px auto;
	width: 95%;
	}
	
	.table {
	padding: 5px;
	border-collapse: collapse;
	border: 1px solid black;
	}

	.max {
	width: 100%;
	}

	th {
	background-color: lightgray;
	border: 1px solid black;
	}

	.center {
	text-align: center;
	}
	
	.border {
	border: 1px solid black;
	padding: 5px 15px;
	}

	.picture {
	text-align: center;
	width: 214px;
	}

	.padding {
	padding: 5px 15px;
	}
	
	.width {
	width: 100px;
	}
	</style>
</head>
<body>
	<?php
	//dohvaća sve žanrove za <select> u tablici za unos
	if($result = $mysqli->query("SELECT * FROM zanr ORDER BY id ASC")) {
		while($obj = $result->fetch_object()) {
			$zanr[$obj->id] = $obj->naziv;
		}
		$result->close();
	}
	?>
	<div>	
	<form action="" method="POST" enctype="multipart/form-data">	
	<table>
		<tr>
			<td>Naslov:</td>
			<td><input type="text" name="naslov"></td>
		</tr>
		<tr>
			<td>Žanr:</td>
			<td><select name="zanr"><?php foreach($zanr as $key => $value) { print "<option value='$key'>$value</option>"; } ?></select></td>
		</tr>
		<tr>
			<td>Godina:</td>
			<td><select name="godina"><?php for($godina = date("Y"); $godina >= 1900; $godina--) { print "<option value='".$godina."'>".$godina."</option>"; } ?></select></td>
		</tr>
		<tr>
			<td>Trajanje:</td>
			<td><input type="number" name="trajanje" min="1" max="9999"> minuta</td>
		</tr>
		<tr>
			<td>Slika:</td>
			<td><input type="file" name="slika"></td>
		</tr>
		<tr>
			<td colspan="2" class="center"><input type="submit" name="prihvati" value="Prihvati"></td>
		</tr>
	</table>
	</form>
	</div>
	<?php
	//unos filmova u bazu preko POST-a
	//uz to prebacuje sliku filma iz /tmp foldera u /slike koji se nalazi u istom folderu kao i "unos.php"
	//slici daje originalno upload ime
	if(isset($_POST["prihvati"])) {
		$uploaddir = "/slike/";
		$uploadfile = basename($_FILES["slika"]["name"]);
		$uploaded_location = $uploaddir.$uploadfile;
		$final_destination = realpath(dirname(__FILE__)).$uploaded_location;
		$tmp_name = $_FILES["slika"]["tmp_name"];
		
		//ako je slika uspješno prebačena, tek onda šalje upit bazi i izbacuje poruku za uspješan unos
		if(move_uploaded_file($tmp_name, $final_destination)) {
			$sql = 'INSERT INTO filmovi (naslov, id_zanr, godina, trajanje, slika) VALUES ("'.$_POST["naslov"].'", "'.$_POST["zanr"].'", "'.$_POST["godina"].'", "'.$_POST["trajanje"].'", "'.$uploadfile.'")';
			if($result = $mysqli->query($sql)) {
				print '<div id="popup"><p>Film uspješno unesen u bazu!</p></div>';
			}
		}
	}
	?>
	<div>	
	<table class="table max">
		<tr>
			<th>Slika</th>
			<th>Naslov filma</th>
			<th>Godina</th>
			<th>Trajanje</th>
			<th>Akcija</th>
		</tr>
		<?php
		//ispisuje sve filmove iz baze u tablicu
		$sql = 'SELECT * FROM filmovi ORDER BY naslov ASC';
		$result = $mysqli->query($sql);
		
		while($row = $result->fetch_assoc()) {
			$movies[] = $row;
		}

		foreach($movies as $movie) {
			print "<tr>";
			print "<td class='picture border'><img src='/seminar/slike/".$movie['slika']."' alt='".$movie['slika']."' style='width:214px;height=317px'></td>";
			print "<td class='border'>".$movie['naslov']."</td>";
			print "<td class='center border'>".$movie['godina']."</td>";
			print "<td class='center border'>".$movie['trajanje']." min</td>";
			print "<td class='center border'>[ <a href='unos.php?delete=".$movie['id']."'>obriši</a> ]</td>";
			print "</tr>";
		}
		?>
	</table>
	</div>
</body>
</html>