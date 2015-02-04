<?php

	session_start();

/*******************************************************************************************************************/

	require_once("functions.inc.php");
	
	if (!is_loggedin()) { header("Location: login.php"); exit; }

/*******************************************************************************************************************/

	if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) { exit; }
	
	require_once("setstartup.inc.php");
	
/*******************************************************************************************************************/
	
	($result = mysql_query("SELECT image_data, image_type FROM images WHERE id_image={$_GET["id"]}")) 
	&& mysql_num_rows($result) 
	or exit(mysql_error());
	
/*******************************************************************************************************************/
	
	list($image_data, $image_type) = mysql_fetch_row($result);
	
	$o_image = imagecreatefromstring($image_data);
	
	$i_width = imagesx($o_image);
	$i_height = imagesy($o_image);

	if ($i_width <= SMALL_THUMBNAIL && $i_height <= SMALL_THUMBNAIL) 
	{
		$thumb_x = $i_width;
		$thumb_y = $i_height;
	}
	elseif ($i_width > $i_height)
	{
		$thumb_x = SMALL_THUMBNAIL;
		$thumb_y = $i_height * SMALL_THUMBNAIL / $i_width;
	}
	else
	{		
		$thumb_x = $i_width * SMALL_THUMBNAIL / $i_height;
		$thumb_y = SMALL_THUMBNAIL;
	}	
	
	$n_image = ($image_type != IMAGETYPE_GIF) 
					? imagecreatetruecolor($thumb_x, $thumb_y) 
					: imagecreate($thumb_x, $thumb_y);	
	
	imagecopyresampled($n_image, $o_image, 0, 0, 0, 0, $thumb_x, $thumb_y, $i_width, $i_height);
	
	header("Content-Type: " . image_type_to_mime_type($image_type));
	
	switch ($image_type)
	{
		case IMAGETYPE_GIF: imagegif($n_image); break;
		case IMAGETYPE_JPEG: imagejpeg($n_image, NULL, 100); break;
		case IMAGETYPE_PNG: imagepng($n_image); break;
	}
	
	imagedestroy($o_image); 
	imagedestroy($n_image);

?>
