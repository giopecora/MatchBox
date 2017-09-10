<?php

 namespace App\Controllers;

 use App\Lib\Sessao;
 
 abstract class Controller {
    protected $app;
    private $viewVar;

    public function __construct($app)
    {
        $this->setViewParam('nameController',$app->getControllerName());
    }
    public function render($view)
    {
        $viewVar = $this->getViewVar();
        // require_once PATH . '/App/Views/layouts/header.php';
        require_once '/App/Views/' . $view . '.php';
        
    }


    public function redirect($view)
    {
        header('Location: http://' . APP_HOST . $view);
        exit;
    }

    public function getViewVar()
    {
        return $this->viewVar;
    }

    public function setViewParam($varName, $varValue)
    {
        if ($varName != "" && $varValue != "") {
            $this->viewVar[$varName] = $varValue;
        }
    }
}