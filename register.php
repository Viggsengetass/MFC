<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - M.F.C MMA Tournament</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/register.css">
</head>
<body class="bg-gray-100">
<div class="container">
    <input type="checkbox" id="signup_toggle">
    <form class="form" method="post" action="register-process.php" class="space-y-4">
        <div class="form_front">
            <div class="form_details">Register</div>
            <input placeholder="Username" class="input" type="text">
            <input placeholder="Password" class="input" type="text">
            <input placeholder="Email" class="input" type="text">

            <button class="btn">Register</button>
            <span class="switch">Don't have an account?
                <label class="signup_tog" for="signup_toggle">
                    Sign Up
                </label>
            </span>
        </div>
        <div class="form_back">
            <div class="form_details">SignUp</div>
            <input placeholder="Firstname" class="input" type="text">
            <input placeholder="Username" class="input" type="text">
            <input placeholder="Email" class="input" type="text">
            <input placeholder="Password" class="input" type="text">
            <input placeholder="Confirm Password" class="input" type="text">
            <button class="btn">Signup</button>
            <span class="switch">Already have an account?
                <label class="signup_tog" for="signup_toggle">
                    Sign In
                </label>
            </span>
        </div>
    </form>
</div>
</body>
</html>
