<?php
session_start();
$username= '';
$email = '';
$password = '';

//If our session doesn't exist, redirect & exit script
if (isset($_SESSION['loggedInUser'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    //Require database in this file & image helpers
    /** @var mysqli $db */
    require_once "includes/database.php";

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $username = mysqli_real_escape_string($db,$_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if ($username ==''){
        $errors['username']= 'De gebruikersnaam mag niet leeg zijn';
    }

    if ($email == '') {
        $errors['email'] = 'De email mag niet leeg zijn';
    }
    if ($password == '') {
        $errors['password'] = 'Het wachtwoord mag niet leeg zijn';
    }

    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username,email, password) VALUES('$username','$email','$password')";
        $result = mysqli_query($db, $query)
        or die('Error: ' . $query);

        if ($result) {
            header('Location: mainpage.html');
            exit;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="signupstijl.css">
</head>
<body>
<div class="bck-img">
    <div class="content">
        <header>Signup</header>
<form action="test%20formulier.php " method="post" enctype="multipart/form-data">
    <div class="data-field">

        <input id="username" type="text" placeholder="username" value="<?=$username?>"/>
        <span class="errors"><?= isset($errors['username']) ? $errors['username']: ''?></span>
    </div>

    <div class="data-field">

        <input id="email" type="email" placeholder="email" value="<?= $email ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>

    <div class="data-field">

        <input id="password" type="password" placeholder="password"/>
        <span class="errors"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
    </div>

    <div class="data-submit space">
        <input type="submit" placeholder="submit" value="Save"/>
    </div>
</form>
</div>
</div>
</body>
</html>