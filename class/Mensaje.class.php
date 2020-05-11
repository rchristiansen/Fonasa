<?php class Mensaje{
	function enviarMensaje($url, $parametros){
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		//curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
		//execute post
		$result = curl_exec($ch);
		//var_dump($result);
		//close connection
		curl_close($ch);
	}
}?>