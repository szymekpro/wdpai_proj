<?php
session_start();
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{

    public function login()
    {
        $userRepository = new UserRepository();
        if (!$this->isPost()) {
            return $this->render('login');
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $userRepository->getUser($email);

        if (!$user) {
            $this->render('login', ['messages' => ['Ten użytkownik nie istnieje!']]);
            return;
        }
        if ($user->getEmail() !== $email) {
            $this->render('login', ['messages' => ['Użytkownik z tym emailem nie istnieje!']]);
            return;
        }

        if (password_verify($password, $user->getPassword())) {

            $_SESSION["user_email"] = $user->getEmail();
            $_SESSION['user_id'] = $user->getId();

            return $this->render('main');
        } else {
            $this->render('login', ['messages' => ['Złe hasło!']]);
        }

    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }
        $email = $_POST['email'];
        $email = strtolower($email);
        $password = $_POST['password'];
        $surname = $_POST['surname'];
        $name = $_POST['name'];

        if ($email === '' || $password === '' || $name === '' || $surname === '') {
            $this->render('register', ['messages' => ['Wypełnij wszystkie pola!']]);
            return;
        }

        if (!preg_match('/^[A-Z]/', $name)) {
            $this->render('register', ['messages' => ['Imie musi się zaczynać z dużej litery!']]);
            return;
        }

        if (!preg_match('/^[A-Z]/', $surname)) {
            $this->render('register', ['messages' => ['Nazwiskp musi się zaczynać z dużej litery!']]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('register', ['messages' => ['Zły email!']]);
            return;
        }

        if (strlen($password) < 3) {
            $this->render('register', ['messages' => ['Hasło jest za krótkie!']]);
            return;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $this->render('register', ['messages' => ['Hasło musi zawierać jedną dużą literę!']]);
            return;
        }

        if (!preg_match('/[0-9]/', $password)) {
            $this->render('register', ['messages' => ['Hasło musi zawierać jedną cyfrę!']]);
            return;
        }


        $userRepository = new UserRepository();
        $user = $userRepository->getUser($email);

        if ($user) {
            $this->render('register', ['messages' => ['Taki użytkownik już istnieje!']]);
            return;
        }

        $role = 'user';
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $userRepository->addUser($name,$surname,$email, $hash,$role);

        $this->render('login', ['messages' => ['Rejestracja powiodła się!']]);

    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->render('login');
    }

    public function settings()
    {
        return $this->render('settings');
    }

    public function changePassword() {

        $data = json_decode(file_get_contents('php://input'), true);
        $oldPass = $data['old_password'] ?? null;
        $newPass = $data['new_password'] ?? null;

        if ($oldPass === '' || $newPass === '') {
            echo json_encode(['messages' => ['Wypełnij wszystkie pola!']]);
            return;
        }

        if (strlen($newPass) < 7) {
            echo json_encode(['messages' => ['Hasło jest za krótkie! Musi zawierać minimum 7 znaków.']]);
            return;
        }

        if (!preg_match('/[A-Z]/', $newPass)) {
            echo json_encode(['messages' => ['Hasło musi zawierać jedną dużą literę!']]);
            return;
        }

        if (!preg_match('/[0-9]/', $newPass)) {
            echo json_encode(['messages' => ['Hasło musi zawierać jedną cyfrę!']]);
            return;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($_SESSION['user_email']);

        if (!$user) {
            echo json_encode(["message" => "empty"]);
            return;
        }

        if (!password_verify($oldPass, $user->getPassword())) {
            echo json_encode(["message" => "old"]);
            return;
        }
        $hash = password_hash($newPass, PASSWORD_BCRYPT);

        $test = $userRepository->changePassword($hash, $_SESSION['user_id']);
        if ($test) {
            echo json_encode(["message" => "success"]);
            //header('Location: settings');
            return;
        } else {
            echo json_encode(["message" => "empty"]);
            //header('Location: Location: settings');
            return;
        }
    }

    public function deleteUser() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $userRepository = new UserRepository();
            $workoutRepository = new WorkoutRepository();
            $workoutInfoRepository = new WorkoutInfoRepository();

            $workoutInfoRepository->deleteAllUserExercises($userId);
            $workoutRepository->deleteAllUserWorkouts($userId);
            $userRepository->deleteUser($userId);
            session_destroy();

            echo json_encode(['message' => 'success']);
        }
        else {
            echo json_encode(["message" => "Niezalogowany!"]);
        }
    }


}

?>