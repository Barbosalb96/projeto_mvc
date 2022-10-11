<?php
/*
 * @Author Fabio Rocha
 */

namespace App;

use App\Controllers\HomeController;
use App\Lib\Config;
use App\Lib\Util;
use Exception;

class App
{
    private $controller;
    private $controllerFile;
    private $controllerName;
    private $action;
    private $params;
    private $oConfig;

    public function __construct()
    {
        /*
         * Constantes do sistema
         */
        define('APP_HOST', $_SERVER['HTTP_HOST']);
        define('PATH', realpath('./'));

        $this->friendlyUrl();
        $this->initConfig();

    }

    public function initConfig()
    {
        if (!file_exists(PATH . "/config.json")) {
            throw new Exception("Arquivo de configuração inválido.!", 500);
        }
        $this->oConfig = new Config(PATH . "/config.json");
    }

    public function run()
    {

        if ($this->controller) {
            $this->controllerName = preg_replace('/[^a-zA-Z]/i', '', ucwords($this->controller) . 'Controller');
        } else {
            $this->controllerName = null;
        }

        $this->controllerFile = $this->controllerName . '.php';
        $this->action = preg_replace('/[^a-zA-Z]/i', '', $this->action);

        if (!$this->controller) {

            $this->controller = new HomeController($this);
            $this->controller->index();

            return;

        }

        if (!file_exists(PATH . '/App/Controllers/' . $this->controllerFile)) {

            throw new Exception("Página não encontrada.", 404);

        }

        $noClass = "\\App\\Controllers\\" . $this->controllerName;

        $oController = new $noClass($this);

        if (!class_exists($noClass)) {

            throw new Exception("Nosso suporte já esta verificando desculpe!", 500);

            return;

        }

        if (method_exists($oController, $this->action)) {

            $oController->{$this->action}($this->params);

            return;

        } else if (!$this->action && method_exists($oController, 'index')) {

            $oController->index($this->params);

            return;

        } else {

            throw new Exception("Nosso suporte já esta verificando desculpe!", 500);

        }

        throw new Exception("Página não encontrada.", 404);

        return;
    }

    public function friendlyUrl()
    {

        if (isset($_GET['url'])) {

            $path = $_GET['url'];

            $path = rtrim($path, '/'); //REMOVE ULTIMA BARRA
            $path = filter_var($path, FILTER_SANITIZE_URL); // LIMPA URL

            $path = explode('/', $path);

            $this->controller = $this->checkArray($path, 0);
            $this->action = $this->checkArray($path, 1);

            // Configura os parâmetros
            if ($this->checkArray($path, 2)) {
                //REMOVE CONTROLLER E ACTION
                unset($path[0]);
                unset($path[1]);

                //PEGA TODOS VALORES DO ARRAY
                $this->params = array_values($path);
            }
        }
    }

    private function checkArray($array, $key)
    {
        if (isset($array[$key]) && !empty($array[$key])) {
            return $array[$key];
        }
        return null;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getNameController()
    {
        return $this->controllerName;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getConfig()
    {
        return $this->oConfig->getConfig();
    }
}