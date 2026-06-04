<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Message;
use App\Models\PrivateMessage;

class UploadController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $this->json(['status' => 'error', 'message' => 'Unauthorized']);
        }
    }

    public function upload() {
        if (!isset($_FILES['image'])) {
            $this->json(['status' => 'error', 'message' => 'No file uploaded']);
        }

        $file = $_FILES['image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Security Checks
        if (!in_array($ext, ALLOWED_EXTENSIONS)) {
            $this->json(['status' => 'error', 'message' => 'Invalid file extension']);
        }

        if ($file['size'] > MAX_UPLOAD_SIZE) {
            $this->json(['status' => 'error', 'message' => 'File too large']);
        }

        // Verify Mime-Type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/jpg'])) {
            $this->json(['status' => 'error', 'message' => 'Invalid image type']);
        }

        // Generate Random Name
        $newName = md5(uniqid() . time()) . '.' . $ext;
        $targetPath = UPLOAD_DIR . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $relativeUrl = '/static/uploads/' . $newName;
            $userId = $_SESSION['user_id'];

            // Save to DB based on context (Room or PV)
            if (isset($_POST['room_id'])) {
                $model = new Message();
                $model->create($userId, $_POST['room_id'], '', $relativeUrl);
            } elseif (isset($_POST['receiver_id'])) {
                $model = new PrivateMessage();
                $model->create($userId, $_POST['receiver_id'], '', $relativeUrl);
            }

            $this->json(['status' => 'success', 'url' => $relativeUrl]);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to move uploaded file']);
        }
    }
}
