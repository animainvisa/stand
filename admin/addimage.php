<?php

	session_start();
	
/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	if (!isset($_POST["vid"], $_FILES["userfile"]) || !ctype_digit($_POST["vid"])) { exit; }
	
	if (	!(list(,, $image_type) = @getimagesize($_FILES["userfile"]["tmp_name"])) 
			|| $image_type > IMAGETYPE_PNG 
			|| !is_uploaded_file($_FILES["userfile"]["tmp_name"])	)
	{ exit("Só são permitidas imagens vulgares e de formato GIF, JPEG ou PNG!"); }
			
	require_once("setstartup.inc.php");
	
	$fp = fopen($_FILES["userfile"]["tmp_name"], "rb");
	$image_data = fread($fp, filesize($_FILES["userfile"]["tmp_name"]));
	fclose($fp);
	
	$query = sprintf("INSERT INTO images (image_data, image_type, primary_image, id_vehicle) VALUES ('%s', %u, %u, %u)", 
				mysql_real_escape_string($image_data), $image_type, time(), $_POST["vid"]);
	
	mysql_query($query) or exit(mysql_error());
		
	header("Location: editvehicle.php?id={$_POST["vid"]}");

?>
