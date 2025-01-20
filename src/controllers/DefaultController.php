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
    public function workouts()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }
        $this->render('workouts');
    }
    public function calorie()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }
        $this->render('calorie_calculator');
    }

    public function onerepmax() {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }
        $this->render('rm_calculator');
    }

    public function bmi() {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            return;
        }
        $this->render('bmi_calculator');
    }

}

?>