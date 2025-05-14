<?php
// Manejador de login y registro
session_start();
include "config.php";

// REGISTRO
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT correo FROM usuarios_pf WHERE correo = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'El correo ya está registrado!';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO usuarios_pf(nombre, correo, contrasenia, tipo) VALUES('$name', '$email', '$password', '$role')");
    }

    header("Location: index.php");
    exit();
}

// LOGIN
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $result = $conn->query("SELECT * FROM usuarios_pf WHERE correo = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['contrasenia'])) {
            // Guardar datos en sesión
            $_SESSION['idUsuario'] = $user['idUsuario'];
            $_SESSION['name'] = $user['nombre'];
            $_SESSION['email'] = $user['correo'];
            $_SESSION['tipo'] = $user['tipo'];

            // Redirigir por tipo
            if ($user['tipo'] === 'a') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'El correo y/o la contraseña es incorrecta...';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}
?>