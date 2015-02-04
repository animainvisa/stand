<?php

	if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) { exit; }
	
	require_once("setstartup.inc.php");	
	
/*******************************************************************************************************************/
	
	($result = mysql_query("SELECT image_data, image_type FROM images WHERE id_image={$_GET["id"]}")) 
	&& mysql_num_rows($result) 
	or exit(mysql_error());
	
/*******************************************************************************************************************/
	
	require_once("functions.inc.php");
	
	list($image_data, $image_type) = mysql_fetch_row($result);
	
	$max_size = isset($_GET["primary"]) ? BIG_THUMBNAIL : (isset($_GET["latest"]) ? MEDIUM_THUMBNAIL : SMALL_THUMBNAIL);
	
	image_data_resize($image_data, $image_type, $max_size);

?>
