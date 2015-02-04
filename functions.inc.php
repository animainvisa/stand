<?php

	if (count(get_included_files()) == 1) { exit; }

	function image_data_resize($i_data, $i_type, $max_xy)
	{
		$o_image = imagecreatefromstring($i_data);
	
		$i_width = imagesx($o_image);
		$i_height = imagesy($o_image);

		if ($i_width <= $max_xy && $i_height <= $max_xy) 
		{
			$thumb_x = $i_width;
			$thumb_y = $i_height;
		}
		elseif ($i_width > $i_height)
		{
			$thumb_x = $max_xy;
			$thumb_y = $i_height * $max_xy / $i_width;
		}
		else
		{		
			$thumb_x = $i_width * $max_xy / $i_height;
			$thumb_y = $max_xy;
		}	
	
		$n_image = ($i_type != IMAGETYPE_GIF) 
						? imagecreatetruecolor($thumb_x, $thumb_y) 
						: imagecreate($thumb_x, $thumb_y);	
	
		imagecopyresampled($n_image, $o_image, 0, 0, 0, 0, $thumb_x, $thumb_y, $i_width, $i_height);
	
		header("Content-Type: " . image_type_to_mime_type($i_type));
	
		switch ($i_type)
		{
			case IMAGETYPE_GIF: imagegif($n_image); break;
			case IMAGETYPE_JPEG: imagejpeg($n_image, NULL, 100); break;
			case IMAGETYPE_PNG: imagepng($n_image); break;
		}
	
		imagedestroy($o_image); 
		imagedestroy($n_image);
	}

?>
