<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <h1>Task Manager</h1>
        <form id="add-task-form">
            <input type="text" id="task-input" placeholder="Enter a new task" required>
            <button type="submit">Add Task</button>
        </form>
        <ul id="task-list">

        </ul>
    </div>
</body>
</html>