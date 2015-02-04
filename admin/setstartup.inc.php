<?php

	if (count(get_included_files()) == 1) { exit; }
	
	define("MYSQL_SERVER", "sql305.byethost7.com");
	define("MYSQL_USER", "b7_15829818");
	define("MYSQL_PASSWD", "blahblah5");
	define("MYSQL_DB", "b7_15829818_tvt");
	
	define("SMALL_THUMBNAIL", 80);	
	define("DELAY", 120);
	define("MAX_ENTRIES", 2);

	define("ADMIN_PASSWD", "698dc19d489c4e4db73e28a713eab07b");
	
	@mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWD) && mysql_select_db(MYSQL_DB) or exit(mysql_error());

?>
