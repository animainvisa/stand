<?php

	if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) { exit; }
	
	require_once("setstartup.inc.php");
	
/*******************************************************************************************************************/
	
	($d_result = mysql_query("SELECT * FROM vehicles WHERE id_vehicle={$_GET["id"]}")) 
	&& mysql_num_rows($d_result) 
	or exit(mysql_error());
	
	$i_result = mysql_query("SELECT id_image FROM images WHERE id_vehicle={$_GET["id"]} ORDER BY primary_image DESC") 
	or exit(mysql_error());
	
/*******************************************************************************************************************/
	
	file_exists("vf.xml") or exit("Ficheiro crucial em falta!");
	
	require_once("header.inc.php");
	
	$d_row = mysql_fetch_row($d_result);
	
	$offset = 1; /* skip the id column value */
	
	echo "\t\t<h2>{$d_row[$offset++]} {$d_row[$offset++]} {$d_row[$offset++]}</h2>\n\n";
	
	echo "\t\t<div id=\"images\">\n";
	
	if (mysql_num_rows($i_result))
	{	
		for ($row_number = 0; list($id_image) = mysql_fetch_row($i_result); $row_number++)
		{ 
			echo "\t\t\t<a ", !(($row_number-1) % 3) ? "class=\"clear\" " : "", "href=\"image.php?id={$id_image}\">";
			echo "<img alt=\"\" src=\"thumbnail.php?id={$id_image}", !$row_number ? "&amp;primary" : "", "\" />";
			echo "</a>\n";
		}
	}
	else { echo "\t\t\t<p>Veículo, de momento, sem imagens.</p>\n"; }
	
	echo "\t\t</div>\n\n";
	
	echo "\t\t<div id=\"links\">\n";
	echo "\t\t\t<ul>\n";
	echo "\t\t\t\t<li>&#x25AA; <a href=\"tellafriend.php?vid={$_GET["id"]}\">Comunicar a um amigo</a></li>\n";
	echo "\t\t\t\t<li>&#x25AA; <a href=\"askabout.php?vid={$_GET["id"]}\">Pedido de informação</a></li>\n";
	echo "\t\t\t\t<li>&#x25AA; <a href=\"javascript:window.print();\">Imprimir</a></li>\n";
	echo "\t\t\t</ul>\n";
	echo "\t\t</div>\n\n";
	
	$vf = simplexml_load_file("vf.xml");
	
	echo "\t\t<div id=\"data\">\n";
	echo "\t\t\t<dl>\n";
	
	$c = 0;
	
	foreach ($vf->characteristic as $characteristic)
	{
		if ($c++ > 2) /* skip the make, model and version characteristics */
		{
			echo "\t\t\t\t<dt>", utf8_decode($characteristic->name), "</dt>\n";
			echo "\t\t\t\t\t<dd>", htmlentities($d_row[$offset++]), "</dd>\n";
		}
	}
	
	echo "\t\t\t\t<dt>Secção</dt>\n";
	echo "\t\t\t\t\t<dd>{$d_row[$offset++]}</dd>\n";
	
	echo "\t\t\t\t<dt>Equipamento</dt>\n";
	echo "\t\t\t\t\t<dd>\n", nl2br(htmlentities($d_row[$offset])), "\n\t\t\t\t\t</dd>\n";
	
	echo "\t\t\t</dl>\n";
	echo "\t\t</div>\n";
	
	require_once("footer.inc.php");

?>
