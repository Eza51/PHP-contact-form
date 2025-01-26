<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        header('Location: index.php?error=All fields are required!');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?error=Invalid email address!');
        exit();
    }

    // Save to JSON file
    $data = [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'date' => date('Y-m-d H:i:s'),
    ];

    $file = 'messages.json';
    $messages = [];

    if (file_exists($file)) {
        $messages = json_decode(file_get_contents($file), true);
    }

    $messages[] = $data;

    if (file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT))) {
        header('Location: index.php?success=1');
    } else {
        header('Location: index.php?error=Failed to save the message!');
    }
} else {
    header('Location: index.php');
    exit();
}
