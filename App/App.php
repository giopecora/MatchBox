<?php

namespace App;

use App\Controllers\ChatBoxController;

class App{

    private $controller;
    private $controllerFile;
    private $action;
    private $params;
    public $controllerName;

    public function __construct(){
       /*
        * Constantes do sistema
        */
       define('PATH'           , realpath('./'));

       $this->url();
    }
    public function url(){
        
        if( isset($_GET['url']) ){
            $path = $_GET['url'];
            $path = rtrim($path. '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

            $path = explode('/', $path);

            $this->controller = $this->verificaArray( $path, 0);

            
            $this->action = $this->verificaArray( $path, 1);

            if($this->verificaArray($path,2)){
                unset($path[0]);
                unset($path[1]);
                $this->params = array_values($path);
            }
        }
    }
    
    public function run(){
        
        if ($this->controller) {
            $this->controllerName = ucwords($this->controller) . 'Controller';
            $this->controllerName = preg_replace('/[^a-zA-Z]/i', '', $this->controllerName);
        } else {
            $this->controllerName = "ChatBoxController";
        }

        $this->controllerFile   = $this->controllerName . '.php';
        $this->action           = preg_replace('/[^a-zA-Z]/i', '', $this->action);

        if (!$this->controller) {
            $this->controller = new ChatBoxController($this);
            $this->controller->index();
        }

        $nomeClasse     = "\\App\\Controllers\\" . $this->controllerName;
        $objetoController = new $nomeClasse($this);

        if (method_exists($objetoController, $this->action)) {
            
            $objetoController->{$this->action}($this->params);
            return;
        } else if (!$this->action && method_exists($objetoController, 'index')) {
            $objetoController->index($this->params);
            return;
        }
    }
    public function getControllerName(){
        return $this->controllerName;   
    }
    public function verificaArray($path, $posicao){
        return $path[$posicao];
    }

}