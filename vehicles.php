<?php

	if (isset($_GET["page"]) && !ctype_digit($_GET["page"])) { exit; }
	
	require_once("setstartup.inc.php");
	
/*******************************************************************************************************************/
	
	$query = "SELECT id_vehicle, make, model, version, year, price, section FROM vehicles ";

	if (!empty($_GET))
	{
		foreach ($_GET as $key => $value) { $$key = mysql_real_escape_string($value); }
		
		$where_condition = null;
		
		if (!empty($make)) { $where_condition .= "make='{$make}' && "; }
		
		if (!empty($model)) { $where_condition .= "model='{$model}' && "; }
		
		if (!empty($section)) { $where_condition .= "section='{$section}' && "; }
		
		if (!empty($yearf)) { $where_condition .= "year >= " .intval($yearf). " && "; }
		
		if (!empty($yeart)) { $where_condition .= "year <= " .intval($yeart). " && "; }
		
		if (!empty($pricef)) { $where_condition .= "price >= " .intval($pricef). " && "; }
		
		if (!empty($pricet)) { $where_condition .= "price <= " .intval($pricet). " && "; }		
		
		if (!is_null($where_condition)) { $query .= "WHERE " . substr($where_condition, 0, -3); }				
	}
	
	$query .= "ORDER BY id_vehicle DESC";
	
	
	$page = isset($_GET["page"]) ? $_GET["page"] : 0;
	
	$l_query = "{$query} LIMIT " .($page * MAX_ENTRIES). ", " . MAX_ENTRIES;
	
	$vehicles_data = mysql_query($l_query) or exit(mysql_error());
	
	
	require_once("header.inc.php");
	
	echo "\t\t<h2>Viaturas</h2>\n\n";
	
	if (mysql_num_rows($vehicles_data))
	{
		echo "\t\t<table>\n";
		echo "\t\t\t<thead>\n";
		echo "\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t<th>Marca</th>\n";
		echo "\t\t\t\t\t<th>Modelo</th>\n";
		echo "\t\t\t\t\t<th>Versão</th>\n";
		echo "\t\t\t\t\t<th>Ano</th>\n";
		echo "\t\t\t\t\t<th>Secção</th>\n";
		echo "\t\t\t\t\t<th>Imagem</th>\n";
		echo "\t\t\t\t\t<th>Preço</th>\n";
		echo "\t\t\t\t\t<th><!-- more --></th>\n";
		echo "\t\t\t\t</tr>\n";
		echo "\t\t\t</thead>\n";
		echo "\t\t\t<tbody>\n";
		
		while (list($id_vehicle, $make, $model, $version, $year, $price, $section) = mysql_fetch_row($vehicles_data))
		{
			echo "\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t<td>{$make}</td>\n";
			echo "\t\t\t\t\t<td>{$model}</td>\n";
			echo "\t\t\t\t\t<td>{$version}</td>\n";
			echo "\t\t\t\t\t<td>{$year}</td>\n";
			echo "\t\t\t\t\t<td>{$section}</td>\n";
		
			$image_data = mysql_query("SELECT id_image FROM images WHERE id_vehicle={$id_vehicle} 
						ORDER BY primary_image DESC LIMIT 1") or ob_end_clean() && exit(mysql_error());
			
			echo "\t\t\t\t\t<td>";
			echo mysql_num_rows($image_data) 
					? "<img alt=\"\" src=\"thumbnail.php?id=" .mysql_result($image_data, 0). "\" />" 
					: "n/a";
			echo "</td>\n";
			
			echo "\t\t\t\t\t<td>{$price}</td>\n";
			echo "\t\t\t\t\t<td><a href=\"vehicle.php?id={$id_vehicle}\">ver mais</a></td>\n";			
			echo "\t\t\t\t</tr>\n";
		}
		
		echo "\t\t\t</tbody>\n";
		echo "\t\t</table>\n\n";
		
		
		$q_result = mysql_query($query) or ob_end_clean() && exit(mysql_error());
		
		$num_rows = mysql_num_rows($q_result); 
		
		
		$num_pages = intval($num_rows / MAX_ENTRIES) + 1;
		
		!($num_rows % MAX_ENTRIES) && $num_pages--;		
		
		
		echo "\t\t<div id=\"pagination\">\n";
		echo "\t\t\t<ul>\n";
		
		for ($i=0; $i < $num_pages; $i++)
		{
			echo "\t\t\t\t<li>";
			
			if ($i != $page)
			{
				if (!isset($_GET["page"]))
				{
					$query_string = $_SERVER["QUERY_STRING"];
					
					strlen($_SERVER["QUERY_STRING"]) && ($query_string .= "&amp;");
					
					$query_string .= "page={$i}";
				}
				else { $query_string = str_replace("page={$_GET["page"]}", "page={$i}", $_SERVER["QUERY_STRING"]); }
				
				echo "<a href=\"vehicles.php?{$query_string}\">" .($i+1). "</a>";
			}
			else { echo $i+1; }
			
			echo "</li>\n";
		}
		
		echo "\t\t\t</ul>\n";
		echo "\t\t</div>\n";
	}
	else { echo "\t\t<p>Pesquisa sem resultados.</p>\n"; }
	
	require_once("footer.inc.php");

?>
