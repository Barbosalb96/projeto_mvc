<?php

namespace App\Controllers;

use App\Helpers\Util;

class Controller
{
    private $_params;
    private $existeLayout = true;


    public function render($view)
    {

        $params = $this->getVarView();

        require_once PATH . '/App/Views/layouts/header.php';
        ($this->existeLayout) ? require_once PATH . '/App/Views/layouts/menu.php' : "";
        require_once PATH . '/App/Views/' . $view . '.php';
        require_once PATH . '/App/Views/layouts/footer.php';

    }

    public function error($code)
    {
        require_once PATH . "/App/Views/error/$code.php";
    }

    public function redirect($view)
    {
        Util::redirect($view);
    }

    public function getVarView()
    {
        return $this->_params;
    }


    public function setViewParam($nameVar, $valueVar)
    {
        if ($nameVar != "" && $valueVar != "") {
            $this->_params[$nameVar] = $valueVar;
        }
    }


    public function existeLayout($isLayout)
    {
        $this->existeLayout = $isLayout;
    }


}