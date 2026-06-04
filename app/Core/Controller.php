<?php

namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . "/../../views/" . $view . ".php";

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $view not found.");
        }
    }

    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
