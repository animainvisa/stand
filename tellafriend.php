<?php

	if (!isset($_GET["vid"]) || !ctype_digit($_GET["vid"])) { exit; }
	
	require_once("setstartup.inc.php");	
	
/*******************************************************************************************************************/
	
	($result = mysql_query("SELECT make, model, version FROM vehicles WHERE id_vehicle={$_GET["vid"]}")) 
	&& mysql_num_rows($result) 
	or exit(mysql_error());
	
/*******************************************************************************************************************/
	
	require_once("header.inc.php");
	
	list($make, $model, $version) = mysql_fetch_row($result);
	
	$vehicle_info = "{$make} {$model} {$version}";
	
	foreach ($_POST as $key => $value) { $$key = $value; }
	
	if (isset($namef, $emailt, $message))
	{
		if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())
		{ foreach ($_POST as $key => $value) { $$key = stripslashes($value); } }		
		
		$subject = "{$namef} recomenda-lhe um veículo do nosso stand - " . STAND_NAME;
		
		strlen($message) && ($message .= "\n\n---\n\n");
		
		$message .= "{$vehicle_info} - http://{$_SERVER["HTTP_HOST"]}/vehicle.php?id={$_GET["vid"]}";
		
		$headers = "From: " . STAND_EMAIL;
		
		echo mail($emailt, $subject, $message, $headers) ? 
			"\t\t<p id=\"return\">O email foi enviado com sucesso!</p>\n\n" : 
			"\t\t<p id=\"return\">O email não pôde ser enviado. Tente de novo.</p>\n\n";
	}
	
	echo "\t\t<form action=\"tellafriend.php?vid={$_GET["vid"]}\" method=\"post\" ";
	echo "onsubmit=\"return tellafriendformval(this);\">\n";
	echo "\t\t\t<fieldset>\n";
	echo "\t\t\t\t<legend>Comunicar a um amigo</legend>\n\n";
		
	echo "\t\t\t\t<h6>{$vehicle_info}</h6>\n\n";
	
	echo "\t\t\t\t<label for=\"l_namef\">Nome</label>\n";
	echo "\t\t\t\t\t<input type=\"text\" name=\"namef\" id=\"l_namef\" />\n";
	echo "\t\t\t\t<label for=\"l_emailt\">Email (do amigo)</label>\n";
	echo "\t\t\t\t\t<input type=\"text\" name=\"emailt\" id=\"l_emailt\" />\n";
	echo "\t\t\t\t<label for=\"l_message\">Mensagem</label>\n";
	echo "\t\t\t\t\t<textarea cols=\"40\" rows=\"5\" name=\"message\" id=\"l_message\"></textarea>\n\n";
	
	echo "\t\t\t\t<input type=\"submit\" value=\"Enviar\" />\n";
	echo "\t\t\t</fieldset>\n";
	echo "\t\t</form>\n\n";
	
	echo "\t\t<p><a href=\"vehicle.php?id={$_GET["vid"]}\">Voltar</a></p>\n";
		
	require_once("footer.inc.php");

?>
