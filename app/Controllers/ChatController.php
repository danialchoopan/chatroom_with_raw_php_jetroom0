<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Room;
use App\Models\Message;
use App\Models\User;
use App\Models\PrivateMessage;

class ChatController extends Controller {
    private $roomModel;
    private $messageModel;
    private $userModel;
    private $pmModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->roomModel = new Room();
        $this->messageModel = new Message();
        $this->userModel = new User();
        $this->pmModel = new PrivateMessage();
    }

    public function index() {
        $rooms = $this->roomModel->getAll();
        $currentRoomId = $_GET['room_id'] ?? 1;
        $currentRoom = $this->roomModel->findById($currentRoomId);
        $onlineUsers = $this->userModel->getOnlineUsers($_SESSION['user_id']);
        $activePms = $this->pmModel->getActiveChats($_SESSION['user_id']);

        $this->view('chat/index', [
            'rooms' => $rooms,
            'currentRoom' => $currentRoom,
            'onlineUsers' => $onlineUsers,
            'activePms' => $activePms,
            'username' => $_SESSION['username']
        ]);
    }

    public function getMessages() {
        $roomId = $_GET['room_id'] ?? 1;
        $messages = $this->messageModel->getByRoomId($roomId);

        // Clean for XSS before sending JSON
        foreach ($messages as &$msg) {
            $msg['message'] = htmlspecialchars($msg['message'] ?? '');
            $msg['username'] = htmlspecialchars($msg['username']);
        }

        $this->json($messages);
    }

    public function sendMessage() {
        $roomId = $_POST['room_id'] ?? 1;
        $messageText = trim($_POST['message'] ?? '');
        $userId = $_SESSION['user_id'];

        if (!empty($messageText)) {
            $this->messageModel->create($userId, $roomId, $messageText);
            $this->json(['status' => 'success']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Message is empty']);
        }
    }
}
