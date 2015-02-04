<?php

	if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) { exit; }
	
	require_once("setstartup.inc.php");
	
/*******************************************************************************************************************/

	($result = mysql_query("SELECT image_data, image_type FROM images WHERE id_image={$_GET["id"]}")) 
	&& mysql_num_rows($result) 
	or exit(mysql_error());

/*******************************************************************************************************************/
	
	list($image_data, $image_type) = mysql_fetch_row($result);
	
	$image = imagecreatefromstring($image_data);
	
	header("Content-Type: " . image_type_to_mime_type($image_type));
	
	switch ($image_type)
	{
		case IMAGETYPE_GIF: imagegif($image); break;
		case IMAGETYPE_JPEG: imagejpeg($image, NULL, 100); break;
		case IMAGETYPE_PNG: imagepng($image); break;
	}
	
	imagedestroy($image);

?>
