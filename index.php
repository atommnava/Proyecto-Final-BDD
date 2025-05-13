<?php
session_start(); // To access the data stored

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
// To determine which form is active [login, register]

$activeForm = $_SESSION['active_form'] ?? 'login';

// It removes all existing session variables, however the session itself
// remains active.
session_unset();


function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}


function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lobby</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container"> 
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_register.php" method="post">
                <h2>Iniciar sesión</h2>
                <!-- This is intended to display login error messages -->
                <!-- if there are error messages stored in the session-->
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Correo" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit" name="login">Iniciar sesión</button>
                <p>No tiene una cuenta? <a href="#" onclick="showForm('register-form')">Registrarse</a></p>
            </form>
        </div>

        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
            <form action="login_register.php" method="post">
                <h2>Registrarse</h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="name" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Correo" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <select name="role" required>
                    <option value="">--Tipo de usuario--</option>
                    <option value="u">Usuario</option>
                </select>
                <button type="submit" name="register">Registrarse</button>
                <p>Ya tiene una cuenta? <a href="#" onclick="showForm('login-form')">Iniciar sesión</a></p>
            </form>
        </div>
    </div>

    <script src="script2.js">

    </script>
</body>
</html>