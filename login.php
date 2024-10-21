<?php
include "includes/db.php";
include "includes/functions.php";

session_start();

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];

        $sql = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows == 0) {
            $error = "No se encontró el usuario.";
        } else {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (!password_verify($password, $hashedPassword)) {
                $error = "Contraseña incorrecta";
            } else {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $row['id'];
                header('Location: index.php');
                exit();
            }
        }
        $sql->close();
    } else {
        $error = "Por favor ingrese su nombre de usuario y contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Task Manager</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container">
        <h1>Task Manager Login</h1>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" id="login-form" class="form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
