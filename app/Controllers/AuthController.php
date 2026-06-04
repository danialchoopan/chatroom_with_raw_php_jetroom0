<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    public function showLogin() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/chat');
        }
        $this->view('auth/login');
    }

    public function login() {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "لطفاً تمام فیلدها را پر کنید.";
            $this->redirect('/login');
        }

        $user = $this->userModel->verify($username, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $this->redirect('/chat');
        } else {
            $_SESSION['error'] = "نام کاربری یا رمز عبور اشتباه است.";
            $this->redirect('/login');
        }
    }

    public function showRegister() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/chat');
        }
        $this->view('auth/register');
    }

    public function register() {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "لطفاً تمام فیلدها را پر کنید.";
            $this->redirect('/register');
        }

        if ($this->userModel->findByUsername($username)) {
            $_SESSION['error'] = "این نام کاربری قبلاً انتخاب شده است.";
            $this->redirect('/register');
        }

        if ($this->userModel->create($username, $password)) {
            $_SESSION['success'] = "ثبت‌نام با موفقیت انجام شد. اکنون وارد شوید.";
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = "خطایی در ثبت‌نام رخ داد.";
            $this->redirect('/register');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
