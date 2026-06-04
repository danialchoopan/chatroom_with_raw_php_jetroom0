<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\PrivateMessage;

class PrivateController extends Controller {
    private $userModel;
    private $pmModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->userModel = new User();
        $this->pmModel = new PrivateMessage();
    }

    public function chat() {
        $receiverId = $_GET['user_id'] ?? null;
        if (!$receiverId) {
            $this->redirect('/chat');
        }

        $receiver = $this->userModel->findById($receiverId);
        if (!$receiver) {
            $this->redirect('/chat');
        }

        $this->view('chat/private', [
            'receiver' => $receiver,
            'username' => $_SESSION['username']
        ]);
    }

    public function getMessages() {
        $receiverId = $_GET['user_id'] ?? null;
        $senderId = $_SESSION['user_id'];

        if ($receiverId) {
            $messages = $this->pmModel->getChatHistory($senderId, $receiverId);
            foreach ($messages as &$msg) {
                $msg['message'] = htmlspecialchars($msg['message'] ?? '');
                $msg['sender_name'] = htmlspecialchars($msg['sender_name']);
            }
            $this->json($messages);
        }
    }

    public function sendMessage() {
        $receiverId = $_POST['receiver_id'] ?? null;
        $messageText = trim($_POST['message'] ?? '');
        $senderId = $_SESSION['user_id'];

        if ($receiverId && !empty($messageText)) {
            $this->pmModel->create($senderId, $receiverId, $messageText);
            $this->json(['status' => 'success']);
        } else {
            $this->json(['status' => 'error']);
        }
    }
}
