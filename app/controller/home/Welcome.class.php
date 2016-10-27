<?php
namespace Home;

use GYC\sys\Controller;

class Welcome extends Controller
{
    private $dt = array();

    public function index()
    {
        $this->dt['hello'] = 'Hello World!';
        $this->dt['title'] = '6K & 3o';
        $this->loadView('welcome', $this->dt);
    }
}