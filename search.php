<?php

	require_once("header.inc.php");
	
	echo "\t\t<form action=\"vehicles.php\" method=\"get\">\n";
	echo "\t\t\t<fieldset>\n";
	echo "\t\t\t\t<legend>Pesquisa</legend>\n\n";
	echo "\t\t\t\t<label for=\"l_make\">Marca</label>\n";
	echo "\t\t\t\t\t<select name=\"make\" id=\"l_make\" onchange=\"getmodels(this.value);\">\n";
	echo "\t\t\t\t\t\t<option value=\"\" selected=\"selected\">Qualquer</option>\n";
	echo "\t\t\t\t\t</select>\n\n";
	
	echo "\t\t\t\t<label for=\"l_model\">Modelo</label>\n";
	echo "\t\t\t\t\t<select name=\"model\" id=\"l_model\">\n"; 
	echo "\t\t\t\t\t\t<option value=\"\" selected=\"selected\">Qualquer</option>\n"; 
	echo "\t\t\t\t\t</select>\n\n";
	
	echo "\t\t\t\t<label for=\"l_section\">Secção</label>\n";
	echo "\t\t\t\t\t<select name=\"section\" id=\"l_section\">\n";
	echo "\t\t\t\t\t\t<option value=\"\" selected=\"selected\">Qualquer</option>\n";
	echo "\t\t\t\t\t\t<option value=\"Novos\">Novos</option>\n";
	echo "\t\t\t\t\t\t<option value=\"Usados\">Usados</option>\n";
	echo "\t\t\t\t\t</select>\n\n";
	
	echo "\t\t\t\t<label for=\"l_yf\">Ano</label>\n";
	echo "\t\t\t\t\t<input type=\"text\" name=\"yearf\" size=\"4\" id=\"l_yf\" />\n";
	echo "\t\t\t\t\t<label for=\"l_yt\" class=\"to\">a</label>\n";
	echo "\t\t\t\t\t\t<input type=\"text\" name=\"yeart\" size=\"4\" id=\"l_yt\" />\n\n";
	
	echo "\t\t\t\t<label for=\"l_pf\">Preço</label>\n";
	echo "\t\t\t\t\t<input type=\"text\" name=\"pricef\" size=\"8\" id=\"l_pf\" />\n";
	echo "\t\t\t\t\t<label for=\"l_pt\" class=\"to\">até</label>\n";
	echo "\t\t\t\t\t\t<input type=\"text\" name=\"pricet\" size=\"8\" id=\"l_pt\" />\n\n";
	
	echo "\t\t\t\t<input type=\"submit\" value=\"Pesquisar\" />\n";
	echo "\t\t\t</fieldset>\n";
	echo "\t\t</form>\n";	
	
	require_once("footer.inc.php");

?>
