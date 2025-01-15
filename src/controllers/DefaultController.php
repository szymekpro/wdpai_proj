<?php

require_once __DIR__ . '/AppController.php';

class DefaultController extends AppController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }
        $this->render('login');
    }
    public function main()
    {
        if (!isset($_SESSION['user_id'])) {
            echo $_SESSION['user_id'];
            $this->render('login');
            return;
        }
        $this->render('main');
    }
    public function exercises()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }
        $this->render('exercises_list');
    }
    public function new()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }
        $this->render('new_workout');
    }
}

?>