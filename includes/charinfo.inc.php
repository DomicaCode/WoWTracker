<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<div class="alert alert-danger" role="alert">
  Sajt ce se nekad ciniti kao da ne radi, Blizzard api je dosta nesiguran :( -- cekat i refreshat dok ne proradi eventualno
</div>

<pre>
<?php 

include 'dbh.inc.php';

if (isset($_POST['submit'])) {

	$data = "";
	$charname = $_POST['charname'];
	$realmname = $_POST['realmname'];


	function geturldata($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}



	$decoded = json_decode(geturldata("https://eu.api.battle.net/wow/character/$realmname/$charname?locale=en_GB&apikey=kzda7n5gg576nefk976qhvn84cs8u6w6"));
	echo ($decoded->name);
	echo " ";
	echo ($decoded->level);
	echo " Levels ";
	echo ($decoded->achievementPoints);
	echo " Achivement Points ";
	echo " Klasa ";
		switch ($decoded->class) {
			case 1:
				echo 'Warrior';
				break;
			case 2:
				echo 'Paladin';
				break;
			case 3:
				echo 'Hunter';
				break;
			case 4:
				echo 'Rogue';
				break;
			case 5:
				echo 'Priest';
				break;
			case 6:
				echo 'Death Knight';
				break;
			case 7:
				echo 'Shaman';
				break;
			case 8:
				echo 'Mage';
				break;
			case 9:
				echo 'Warlock';
				break;
			case 10:
				echo 'Monk';
				break;
			case 11:
				echo 'Druid';
				break;
			case 12:
				echo 'Demon Hanter';
				break;
			default:
				echo 'Tvoja klasa ne postoji';
				break;

	}

	// uzmi json za SVE mounte
	$mountarray = json_decode(geturldata("https://eu.api.battle.net/wow/mount/?locale=en_GB&apikey=kzda7n5gg576nefk976qhvn84cs8u6w6"), true);


	// KOD ZA UBACIVANJE SVIH MOUNTA U DB
	/*foreach ($mountarray['mounts'] as $value) {
		if ($value['itemId'] != 0) {
			$html=file_get_contents('https://www.wowhead.com/item='.$value['itemId']);
			xml_parse_into_struct(xml_parser_create(),$html,$array);
			//print_r($array);
			$mnt_id = $value['itemId'];
			echo end(explode(',', $array[11]['attributes']['CONTENT']));
			echo '<br>';
			$mnt_xpac = end(explode(',', $array[11]['attributes']['CONTENT']));
			echo($array[13]['attributes']['CONTENT']);
			echo '<br>';
			$mnt_name = $array[13]['attributes']['CONTENT'];
			$mnt_icon = $array[41]['attributes']['HREF'];
			echo "<img src=$mnt_icon />";
			echo '<br>';
			$sql = "INSERT INTO mounts (mnt_id, mnt_name, mnt_icon, mnt_xpac) VALUES ('$mnt_id', '$mnt_name', '$mnt_icon', '$mnt_xpac')";
			mysqli_query($conn, $sql);
		}

	}
*/

	// uzmi json za trenutno OBTAINED mounte
	$decodedd = json_decode(geturldata("https://eu.api.battle.net/wow/character/$realmname/$charname?fields=mounts&locale=en_GB&apikey=kzda7n5gg576nefk976qhvn84cs8u6w6"), true);

	$mountarray2=$mountarray;

	//izvadi mounte koje imas
	foreach($mountarray['mounts'] as $k1=>$v1){
		
		foreach($decodedd['mounts']['collected'] as $v2){
			if ($v1['spellId']== $v2['spellId'])
			{
				unset($mountarray2['mounts'][$k1]);
				break;
			}
		}
	}

	foreach ($mountarray2['mounts'] as $value) {
		$mnt_id = $value['itemId'];
		$sql = "SELECT * FROM mounts WHERE mnt_id = $mnt_id";
		$result = mysqli_query($conn, $sql);
		$actualresult = mysqli_fetch_all($result, MYSQLI_ASSOC);
		//print_r($actualresult);
		echo $actualresult[0]['mnt_name'];
		echo '<br>';
		echo $actualresult[0]['mnt_xpac'];
		echo '<br>';
		$icon = $actualresult[0]['mnt_icon'];
		echo "<img src='$icon' />";
		echo '<br>';
		}
}

else
{
	echo 'zagubio si se';
}
 ?>
</pre>