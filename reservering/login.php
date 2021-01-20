<?php
session_start();
/** @var mysqli $db  */
require_once "includes/database.php";

if (isset($_SESSION['loggedInUser'])) {
    header("Location: test formulier.php");
    exit;
}

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($db,$_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];


$query="SELECT * FROM users WHERE username = '$username' AND email = '$email' ";
$result= mysqli_query($db, $query) or die ('Error: ' .$query);
$user = mysqli_fetch_assoc($result);

$errors = [];
if ($user) {
    //Validate password
    if (password_verify($password, $user['password'])) {
        //Set email for later use in Session
        $_SESSION['loggedInUser'] = [
            'name' => $user['name'],
            'id' => $user['id']
        ];

        //Redirect to secure.php & exit script
        header("Location: create.php");
        exit;
    } else {
        $errors[] = 'Uw logingegevens zijn onjuist';
    }
} else {
    $errors[] = 'Uw logingegevens zijn onjuist';
}
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>kapper Login</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="loginstijl.css">

</head>
<body>

<div class="kapper-img">

<div class="content">
<header>Inloggen</header>
<?php if (isset($errors) && !empty($errors)) { ?>
    <ul class="errors">
        <?php for ($i = 0; $i < count($errors); $i++) { ?>
            <li><?= $errors[$i]; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<form id="login" method="post" action="">


    <div class="data-field">

        <input id="username" type="text" placeholder="username" value="<?= (isset($username) ? $username : ''); ?>"/>

    </div>

    <div class="data-field ">

        <input type="email" placeholder="email" id="email" value="<?= (isset($email) ? $email : ''); ?>"/>
    </div>

    <div class="data-field ">

        <input type="password" placeholder="password" id="password"/>
    </div>

    <div class="data-field space">
        <input type="submit" placeholder="submit" value="Login"/>
    </div>
</form>
<div class="pass">
    <a href="sign-up.php">Sign-up</a>

    <hr>

    <a href="../../CLE-2-RESERVERINGSSYSTEEM/reservering/mainpage.html">Terug naar homepage</a>
</div>
</div>
</div>
</body>
</html>

