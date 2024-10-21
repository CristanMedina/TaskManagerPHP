<?php
include "includes/db.php";
include "includes/functions.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch existing tasks for the logged-in user
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="header">
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
    <div class="container">
        <h1>Task Manager</h1>

        <!-- Add Task Form -->
        <form method="POST" action="addTask.php">
            <input type="text" name="task_name" placeholder="Enter a new task" required>
            <textarea name="description" placeholder="Description (optional)"></textarea>
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <!-- Task List -->
        <ul id="task-list">
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong><?php echo htmlspecialchars($task['task_name']); ?></strong>
                    [<?php echo htmlspecialchars($task['status']); ?>]

                    <!-- Edit Task Form -->
                    <form method="POST" action="editTask.php" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                        <textarea name="description" placeholder="Description (optional)"><?php echo htmlspecialchars($task['description']); ?></textarea>
                        <input type="text" name="status" value="<?php echo htmlspecialchars($task['status']); ?>" placeholder="Status" required>
                        <button type="submit" name="edit_task">Edit</button>
                    </form>

                    <!-- Delete Task Form -->
                    <form method="POST" action="deleteTask.php" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" name="delete_task" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
