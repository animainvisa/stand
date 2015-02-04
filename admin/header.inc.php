<?php

	if (count(get_included_files()) == 1) { exit; }

	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" ";
	echo "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";

	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />\n";
	echo "<meta name=\"description\" content=\"\" />\n";
	echo "<meta name=\"keywords\" content=\"\" />\n";
	echo "<title></title>\n";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheet.css\" media=\"screen\" />\n";
	
	if (strcmp(basename($_SERVER["PHP_SELF"]), "login.php"))
	{ echo "<script type=\"text/javascript\" src=\"afunctions.js\"></script>\n"; }
	
	echo "</head>\n";
	echo "<body>\n\n";

?>
