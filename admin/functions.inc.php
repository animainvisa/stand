<?php
	
	if (count(get_included_files()) == 1) { exit; }
	
	function generate_fingerprint()
	{
		$string = null;
		
		$fragments = !empty($_SERVER["HTTP_USER_AGENT"]) ? preg_split("/(\.|;)/", $_SERVER["HTTP_USER_AGENT"]) : "0";
		
		for ($i=0; $i < count($fragments); $i++) { $string .= substr(strrev(md5($fragments[$i])), 10, 2); }
		
		return md5($string);
	}
	
	function is_loggedin()
	{
		if (isset($_SESSION["fingerprint"]) && 
			!strcmp($_SESSION["fingerprint"], md5(generate_fingerprint())))
		{ return true; }
		
		return false;
	}
	
	function js_data_updater()
	{	
		$makes_data = mysql_query("SELECT DISTINCT make FROM vehicles WHERE make <> '' ORDER BY make ASC") 
		or exit(mysql_error());
		
		$f = "var makes = [";
		$s = "var models = [];\n";
		
		if (mysql_num_rows($makes_data))
		{
			for ($i = 0; list($make) = mysql_fetch_row($makes_data); $i++)
			{
				$f .= "\"{$make}\", ";
				$s .= "models[{$i}] = [";
				
				$models_data = mysql_query("SELECT DISTINCT model FROM vehicles WHERE make='{$make}' 
									AND model <> '' ORDER BY model ASC") or exit(mysql_error());				
				
				if (mysql_num_rows($models_data))
				{ 
					while (list($model) = mysql_fetch_row($models_data)) { $s .= "\"{$model}\", "; } 
					
					$s = substr($s, 0, -2);
				}
			
				$s .= "];\n";
			}
		
			$f = substr($f, 0, -2);
		}
		
		$f .= "];\n\n";
		
		$fp = fopen("../vsdata.js", "w"); /* set the file permissions to 666 */
		fwrite($fp, $f.$s);
		fclose($fp);
	}

?>
