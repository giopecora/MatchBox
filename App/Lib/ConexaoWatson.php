<?php

namespace App\Lib;

class ConexaoWatson {

	private $Usuario = "";
	private $Contraseña = "";
	private $Contexto = "";

	function __construct()
    {
    	$this->Contexto = $_SESSION['context'];
    }



	public function set_credenciales($usr,$pass){
		$this->Usuario = $usr;
		$this->Contraseña = $pass;
	}

	public function set_contexto($context){
	
			$this->Contexto = $context;
			$_SESSION['context'] = $context;
		
	}

	 public function Enviar_Pergunta($text, $workspace) {
	     $curl = curl_init();
	     
	     $context_data = json_decode($this->Contexto);
	     $resp = array(
		         'input' => array(
		         		'text' => $text
		         	),
		         'context' => $context_data
	     );
	 	 
		 $dataa = json_encode($resp);

	     curl_setopt($curl, CURLOPT_POST, true);
	     curl_setopt($curl, CURLOPT_POSTFIELDS, $dataa);
	     curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	     	'Content-Type: application/json',                                                                               
	    	'Content-Length: ' . strlen($dataa))                                                                       
		 );  
	     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	     curl_setopt($curl, CURLOPT_USERPWD, $this->Usuario.":".$this->Contraseña);
         curl_setopt($curl, CURLOPT_URL, "https://gateway.watsonplatform.net/conversation/api/v1/workspaces/".$workspace."/message/?version=2017-09-09");
	     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($curl);
         
	     if (curl_errno($curl)) {
			    echo 'Error:' . curl_error($curl);
		 }
	     curl_close($curl);
	     $decoded = json_decode($result, true);
     return $decoded;
 	 }
 	
 	 }
 	?>