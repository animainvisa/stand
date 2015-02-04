<?php

	if (count(get_included_files()) == 1) { exit; }

	define("MYSQL_SERVER", "sql305.byethost7.com");
	define("MYSQL_USER", "b7_15829818");
	define("MYSQL_PASSWD", "blahblah5");
	define("MYSQL_DB", "b7_15829818_tvt");
	
	define("SMALL_THUMBNAIL", 80); # default 80
	define("MEDIUM_THUMBNAIL", 150);
	define("BIG_THUMBNAIL", 250); # default 250
	
	define("MAX_ENTRIES", 2);

	define("STAND_NAME", "Foobar");	
	define("STAND_EMAIL", "Foobar <stand@email.here>");
	
	@mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWD) && mysql_select_db(MYSQL_DB) or exit(mysql_error());

?>
