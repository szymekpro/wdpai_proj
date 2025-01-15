<?php
session_start();
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login() {

        //session_start();

        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }
        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['Wrong email or password!']]);
        }
        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }
        $_SESSION['user_email'] = $user->getEmail();
        $_SESSION['user_id'] = $user->getId();
        //echo $_SESSION['user_email'];
        return $this->render('main');
    }
}

?>