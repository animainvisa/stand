<?php

	if (count(get_included_files()) == 1) { exit; }
	
	require_once("setstartup.inc.php");
	
	ob_start();

	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" ";
	echo "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";

	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />\n";
	echo "<meta name=\"description\" content=\"\" />\n";
	echo "<meta name=\"keywords\" content=\"\" />\n";
	echo "<title></title>\n";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheet.css\" media=\"screen\" />\n";
	
	if (!strcmp($pagename = basename($_SERVER["PHP_SELF"]), "index.php"))
	{
		echo "<script type=\"text/javascript\" src=\"vsdata.js\"></script>\n";
		echo "<script type=\"text/javascript\" src=\"vsfunctions.js\"></script>\n";
	}
	elseif (!strcmp($pagename, "askabout.php") || !strcmp($pagename, "tellafriend.php"))
	{ echo "<script type=\"text/javascript\" src=\"formsvalidation.js\"></script>\n"; }
	
	echo "</head>\n";
	echo "<body>\n\n";
	
	echo "<div id=\"container\">\n\n";
	
	echo "\t<div id=\"logo\">\n";
	echo "\t\t<img alt=\"\" src=\"logo.png\" />\n";
	echo "\t</div>\n\n";
	
	echo "\t<div id=\"menu\">\n";
	echo "\t\t<ul>\n";
	echo "\t\t\t<li><a ", !strcmp($pagename, "index.php") ? "id=\"active\" " : "", "href=\"index.php\">Início</a></li>\n";
	echo "\t\t\t<li><a ", !strcmp($pagename, "company.php") ? "id=\"active\" " : "", "href=\"company.php\">Empresa</a></li>\n";
	echo "\t\t\t<li><a ", !strcmp($pagename, "vehicles.php") ? "id=\"active\" " : "", "href=\"vehicles.php\">Viaturas</a></li>\n";
	echo "\t\t\t<li><a ", !strcmp($pagename, "services.php") ? "id=\"active\" " : "", "href=\"services.php\">Serviços</a></li>\n";
	echo "\t\t\t<li><a ", !strcmp($pagename, "financing.php") ? "id=\"active\" " : "", "href=\"financing.php\">Financiamento</a></li>\n";
	echo "\t\t\t<li><a ", !strcmp($pagename, "contactus.php") ? "id=\"active\" " : "", "href=\"contactus.php\">Contactos</a></li>\n";
	echo "\t\t</ul>\n";
	echo "\t</div>\n\n";
	
	echo "\t<div id=\"" .basename($pagename, ".php"). "\">\n";

?>
