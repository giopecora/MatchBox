<?php
namespace App\Controllers;

use App\Lib\ConexaoWatson;

 class ChatBoxController {
    public $watson;
    public $pergunta = "";
    public $resposta = "";

    public function __construct(){
        $this->watson = new ConexaoWatson();
        $this->watson->set_credenciales("084210ba-f47e-4d7c-91f7-6430d04a6301","TyDSJamHaQ1i");    
    }

    public function index()
    {
        require_once PATH . '/App/Views/chatbox/index.php';
        
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
    
     
    public function enviarPergunta(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {  
            $this->pergunta = $this->test_input($_POST["pergunta"]);
            $this->resposta = $this->watson->Enviar_Pergunta($this->pergunta, "211cb5de-fb59-48d8-b1c5-7d656e2648e6");
            $this->watson->set_contexto(json_encode($this->resposta['context']));
            echo json_encode($this->resposta['output']['text'][0],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
         }
    }
       

 }