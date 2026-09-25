<?php

class AuthController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $firstName = trim(isset($_POST['first_name']) ? $_POST['first_name'] : '');
        $lastName = trim(isset($_POST['last_name']) ? $_POST['last_name'] : '');
        $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if ($firstName === '' || $lastName === '' || $email === '' || strlen($password) < 6) {
            $error = 'Please enter valid registration details.';
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email.';
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        if ($this->user->findByEmail($email)) {
            $error = 'Email already exists.';
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        $this->user->create($firstName, $lastName, $email, $password);

        header('Location: /index.php/login');
        exit;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $user = $this->user->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $error = 'Invalid email or password.';
            require __DIR__ . '/../views/auth/login.php';
            return;
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['first_name'];

        setcookie(
            'last_login',
            date('Y-m-d H:i:s'),
            time() + (7 * 24 * 60 * 60),
            '/',
            '',
            false,
            true
        );

        header('Location: /');
        exit;
    }

    public function logout() {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /');
        exit;
    }
}
