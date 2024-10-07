<?php

#RUTAS DE ARCHIVOS CON FUNCIONES GLOBALES
include 'includes/db.php';
include 'includes/functions.php';

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);

    if($password === $confirmPassword){
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $error = "El correo electronico ya esta registrado.";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$hashed_password')";
            if($conn->query($sql) === TRUE){
                $_SESSION['flash-message'] = "Registro de usuario exitoso. Ahora puedes iniciar sesion.";
                header("Location: login.php");
                exit();
            } else {
                $error = "Error en el registro".$conn->error;
            }
        }
    } else {
        $error = "Las contraseñas no coinciden";
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
        <h1>Task Manager Register</h1>

        <?php if(isset($error)): ?>
        <?php echo $error; ?>
        <?php endif; ?>

        <form method="POST" action="" id="register-form" class="form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">email:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>