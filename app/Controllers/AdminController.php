<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Message;

class AdminController extends Controller {
    private $userModel;
    private $messageModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $this->userModel = new User();
        $this->messageModel = new Message();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        return $this->view('admin/dashboard', ['users' => $users]);
    }

    public function toggleBlock() {
        $userId = $_POST['user_id'] ?? null;
        if ($userId) {
            $this->userModel->toggleBlock($userId);
        }
        header('Location: /admin');
    }

    public function deleteUser() {
        $userId = $_POST['user_id'] ?? null;
        if ($userId) {
            $this->userModel->delete($userId);
        }
        header('Location: /admin');
    }

    public function deleteMessage() {
        $messageId = $_POST['message_id'] ?? null;
        if ($messageId) {
            $this->messageModel->delete($messageId);
            return $this->json(['success' => true]);
        }
        return $this->json(['success' => false], 400);
    }
}
