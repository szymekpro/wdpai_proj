<?php

require_once __DIR__ . '/AppController.php';

class WorkoutController extends AppController
{
    public function new()
    {
        $this->render('new_workout');
    }
}