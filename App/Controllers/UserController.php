<?php

namespace App\Controllers;

use App\Models\Cidade;
use App\Services\User;

class UserController extends Controller
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
        self::setViewParam('nameController', $this->app->getNameController());
    }

    public function index()
    {
        $user = (new User())->all();
        self::setViewParam('user', $user);
        $this->render('user/index');

    }

    public function create($params = [])
    {
        $cidades = (new Cidade())->getAll();
        self::setViewParam('params', $params);
        self::setViewParam('cidades', $cidades);
        $this->render('user/create');
    }

    public function save()
    {
        $user = (new User())->save($_POST, $_FILES["arquivo"]);

        if (!array_key_exists('success', $user)) {
            return $this->create([$_POST, $user]);
        }

        $this->redirect('user/index');
    }

    public function detail()
    {
        $user = (new User())->findOrFail($_GET);

        self::setViewParam('params', $user);
        $this->render('user/detail');
    }

}