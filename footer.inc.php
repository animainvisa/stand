<?php

	if (count(get_included_files()) == 1) { exit; }

	echo "\t</div>\n\n";	
	
	$query = "SELECT tbl1.id_image, tbl1.id_vehicle FROM images tbl1 ";
	$query .= "LEFT JOIN images tbl2 ON tbl1.id_vehicle = tbl2.id_vehicle ";
	$query .= "AND tbl1.primary_image < tbl2.primary_image ";
	$query .= "WHERE tbl2.id_image IS NULL ";
	$query .= "ORDER BY tbl1.id_vehicle DESC ";
	$query .= "LIMIT 2";
	
	$vehicles_data = mysql_query($query) or ob_end_clean() && exit(mysql_error());
	
	if (mysql_num_rows($vehicles_data))
	{
		echo "\t<div id=\"latestentries\">\n";
		echo "\t\t<h3>Últimas Entradas</h3>\n\n";
	
		while (list($image_id, $vehicle_id) = mysql_fetch_row($vehicles_data))
		{		
			echo "\t\t<a href=\"vehicle.php?id={$vehicle_id}\">";
			echo "<img alt=\"\" src=\"thumbnail.php?id={$image_id}&amp;latest\" /></a>\n";
		}
		
		echo "\n\t\t<p><a href=\"vehicles.php\">ver mais</a></p>\n";
		echo "\t</div>\n\n";	
	}
	
	echo "\t<div style=\"clear:both;\"></div>\n\n";
	
	echo "\t<div id=\"copyright\">\n";
	echo "\t\t<p>Copyright &copy; 2008 Stand Exemplo, Lda</p>\n";
	echo "\t\t<p>Desenvolvido por <a href=\"http://www.foobar.com\">Foobar</a></p>\n";
	echo "\t</div>\n\n";
	
	echo "</div>\n\n";

	echo "</body>\n";
	echo "</html>\n\n";

?>
