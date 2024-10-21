<?php
include "includes/db.php";
include "includes/functions.php";

session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not logged in."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log(print_r($_POST, true));

    if (!isset($_POST['task_name']) || !isset($_POST['description'])) {
        echo json_encode(["error" => "Missing task name or description."]);
        exit();
    }

    $task_name = sanitizeInput($_POST['task_name']);
    $description = sanitizeInput($_POST['description']);
    $user_id = $_SESSION['id'];

    $sql = $conn->prepare("INSERT INTO tasks (task_name, description, user_id) VALUES (?, ?, ?)");
    $sql->bind_param("ssi", $task_name, $description, $user_id);

    if ($sql->execute()) {
        echo json_encode(["success" => "Task created successfully."]);
    } else {
        echo json_encode(["error" => "Failed to create task."]);
    }

    $sql->close();
} else {
    echo json_encode(["error" => "Invalid request."]);
}

$conn->close();

header("Location: index.php");
exit();
