<?php

namespace App\Controllers;

class HomeController extends Controller
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function index()
    {
        $this->render('home/index');
    }


}