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

/*
 * @brief It returns an HTML P element containing the error message of "error is not empty".
 * @param error Parameter called error 
 */
function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

/*
 * @parameter activeForm
 * @parameter formName
 * @brief This function checks whether the given form name matches the active form,
 * if it does, it will return the string active which is used to add a class to the HTML element.
 */
function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Stack Login & Register Form with User $ Admin page</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container"> 
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_register.php" method="post">
                <h2>Login</h2>
                <!-- This is intended to display login error messages -->
                <!-- if there are error messages stored in the session-->
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
            <form action="login_register.php" method="post">
                <h2>Register</h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

    <script src="script2.js">

    </script>
</body>
</html>