<?php
	$author_name = "Ilja Leontjev";
	
	//kontrollin, kas post info jouab kuhugi
	//var_dump($_POST);
	//kontrollime kas klikiti "submit" nuppu
	$todays_adjective_html = null;
	$todays_adjective_error = null;
	$todays_adjective = null;
	if(isset($_POST["adjective_submit"]))
	{
		//echo "Klikiti!";
		//<p>tanane paev on tuuline.<p>
		//kontrollime kas midagi kirjutati ka
		if(!empty($_POST["todays_adjective_input"]))
		{
			$todays_adjective_html = "<p>tanane paev on " .$_POST["todays_adjective_input"] .".</p>";
			$todays_adjective = $_POST["todays_adjective_input"];
		}
		else
		{
			$todays_adjective_error = "Palun sisesta tanase kohta sobiv omadussona!";
		}
	}
	
	//juhusliku foto lisamine
	$photo_dir = "Photos/";
	//loen kataloogi sisu
	$all_files = scandir($photo_dir);
	$all_real_files = array_slice($all_files, 2);
	
	//sõelume välja päris pilt
	$photo_files = [];
	$allowed_photo_types = ["image/jpeg", "image/png"];
	foreach($all_real_files as $file_name)
	{
		$file_info = getimagesize($photo_dir .$file_name);
		if(isset($file_info["mime"]))
		{
			if(in_array($file_info["mime"], $allowed_photo_types))
			{
				array_push($photo_files, $file_name);
			}	
		}
	}
	
	//echo $all_files;
	//var_dump($all_real_files);
	
	//loen massiivi elemendid kokku
	$file_count = count($photo_files);
	//loosin juhusliku arvu(min peab olema 0 ja max count - 1)
	$photo_num = mt_rand(0, $file_count - 1);
	//echo $photo_num;
	//<img src="kataloog/fail" alt="Tallinna Ülikool">
	$photo_html = '<img src="' . $photo_dir .$photo_files[$photo_num] .'"alt = "Tallinna Ülikool">';
	
	//tsukkel
	//naiteks:
	//<ul>
	//		<li>pildifailinimi.jpg</li>
	//		<li>pildifailinimi.jpg</li>
	//		<li>pildifailinimi.jpg</li>
	//		...
	//</ul>
	$photo_list_html = "\n <ul> \n";
	for($i = 0; $i < $file_count; $i++)
	{
		$photo_list_html .= "<li>" .$photo_files[$i] ."</li> \n"; 
	}
	$photo_list_html .= "</ul> \n";
	
	$photo_select_html = "\n" .'<select name="photo_select">' ."\n";
	for($i = 0; $i < $file_count; $i++)
	{
		$photo_select_html .= '<option value="' .$i .'">' .$photo_files[$i] ."</option> \n"; 
	}
	$photo_select_html .= "</select> \n";
	
?>
<!DOCTYPE html>
<html lang="et">
	<head>
		<meta charset="utf-8">
		<title><?php echo $author_name; ?>, veebiprogrameerimine</title>
	</head>
	<body>
		<h1><?php echo $author_name; ?>, veebiprogrameerimine</h1>
		<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
		<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna ülikooli Digitehnoloogiate instituudis</a>.</p>
		<hr>
		<form method="POST">
			<input type="text" placeholder="omadussõna tänase kohta" name="todays_adjective_input" value="<?php echo $todays_adjective; ?>">
			<input type="submit" name="adjective_submit" value="Saada">
			<span><?php echo $todays_adjective_error; ?></span>
		<form>
		<?php echo $todays_adjective_html; ?>
		<hr>
		<hr>
		<form method="POST">
			<?php echo $photo_select_html; ?>
		</form>
		<hr>
		<?php 
			echo $photo_html;
			echo $photo_list_html;
		?>
	</body>
</html>
