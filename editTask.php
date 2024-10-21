<?php
include "includes/db.php";
include "includes/functions.php";

session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not logged in."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    $task_name = sanitizeInput($_POST['task_name']);
    $description = sanitizeInput($_POST['description']);
    $status = sanitizeInput($_POST['status']);
    $user_id = $_SESSION['id'];

    $sql = $conn->prepare("UPDATE tasks SET task_name = ?, description = ?, status = ? WHERE id = ? AND user_id = ?");
    $sql->bind_param("ssiii", $task_name, $description, $status, $task_id, $user_id);

    if ($sql->execute()) {
        echo json_encode(["success" => "Task updated successfully."]);
    } else {
        echo json_encode(["error" => "Failed to update task."]);
    }

    $sql->close();
} else {
    echo json_encode(["error" => "Invalid request."]);
}

$conn->close();

header("Location: index.php");
exit();
