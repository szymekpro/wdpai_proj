<?php

require_once __DIR__ . '/AppController.php';

class DefaultController extends AppController
{
    public function index()
    {
        $this->render('login');
    }
    public function main()
    {
        $this->render('main');
    }
}

?>