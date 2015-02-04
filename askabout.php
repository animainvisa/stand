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
	
	if (isset($name, $contact, $email, $question))
	{
		if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())
		{ foreach ($_POST as $key => $value) { $$key = stripslashes($value); } }
		
		$subject = "Questão acerca do {$vehicle_info}";
		
		$message = "Nome: {$name}\n";
		$message .= "Contacto(s): {$contact}\n";
		$message .= "Email: {$email}\n";
		$message .= "Veículo: http://{$_SERVER["HTTP_HOST"]}/vehicle.php?id={$_GET["vid"]}\n";
		$message .= "Questão: {$question}";
		
		$headers = "From: {$email}";		
		
		echo mail(STAND_EMAIL, $subject, $message, $headers) ?
			"\t\t<p id=\"return\">A mensagem foi enviada com sucesso!</p>\n\n" :
			"\t\t<p id=\"return\">A mensagem não pôde ser enviada. Tente de novo.</p>\n\n";
	}
	
	echo "\t\t<form action=\"askabout.php?vid={$_GET["vid"]}\" method=\"post\" ";
	echo "onsubmit=\"return askaboutformval(this);\">\n";
	echo "\t\t\t<fieldset>\n";
	echo "\t\t\t\t<legend>Pedido de informação</legend>\n\n";
	
	echo "\t\t\t\t<h6>{$vehicle_info}</h6>\n\n";
	
	echo "\t\t\t\t<label for=\"l_name\">Nome</label>\n";
	echo "\t\t\t\t\t<input type=\"text\" name=\"name\" id=\"l_name\" />\n";
	echo "\t\t\t\t<label for=\"l_contact\">Contacto(s)</label>\n";
	echo "\t\t\t\t\t<input type=\"text\" name=\"contact\" id=\"l_contact\" />\n";
	echo "\t\t\t\t<label for=\"l_email\">Email</label>\n";
	echo "\t\t\t\t\t<input type=\"text\" name=\"email\" id=\"l_email\" />\n";
	echo "\t\t\t\t<label for=\"l_question\">Questão</label>\n";
	echo "\t\t\t\t\t<textarea cols=\"40\" rows=\"5\" name=\"question\" id=\"l_question\"></textarea>\n\n";
	
	echo "\t\t\t\t<input type=\"submit\" value=\"Enviar\" />\n";
	echo "\t\t\t</fieldset>\n";
	echo "\t\t</form>\n\n";

	echo "\t\t<p><a href=\"vehicle.php?id={$_GET["vid"]}\">Voltar</a></p>\n";	
	
	require_once("footer.inc.php");

?>
