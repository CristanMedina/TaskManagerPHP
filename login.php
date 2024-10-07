<?php

session_start(); //Creamos una sesion o reanudar una existente.

//verifica que el comentario fue enviado mediante el metodo post
if($_SERVER['REQUEST_METHOD']==='POST'){
    //Toma los datos de los campos
    $username = $_POST['username'];
    $password = $_POST['password']; 

//Compara los datoas obtenidos con los que ya se tienen.
    if($username === "nombre@cesun.edu.mx" && $password === "12345"){
        //Redirigira al usuario a la pagina index.php
        $_SESSION['loggedin'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = "Usuario o contraseña invalidos.";
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

        <?php if(isset($error)): ?>
        <?php echo $error; ?>
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