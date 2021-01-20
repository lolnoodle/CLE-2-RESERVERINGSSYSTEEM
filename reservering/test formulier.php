<?php
/**@var $db */

require_once "includes/database.php";

// Check if form is submitted.
if (isset($_POST['submit'])) {
    // 'Post back' with the data from the form.
    $voornaam = mysqli_real_escape_string($db, $_POST['voornaam']);
    $achternaam = mysqli_real_escape_string($db, $_POST['achternaam']);
    $email = mysqli_real_escape_string($db, $_POST['e-mail']);
    $datum = mysqli_real_escape_string($db, $_POST['datum']);
    $tijd = mysqli_real_escape_string($db, $_POST['time']);


    $errors = [];
    if ($voornaam == '') {
        $errors['voornaam'] = 'Het veldnaam met voornaam mag niet leeg zijn.';
    }
    if ($achternaam == '') {
        $errors['achternaam'] = 'Het veldnaam met achternaam mag niet leeg zijn.';
    }


    if ($datum == '') {
        $errors['datum'] = 'Het veldnaam met datum mag niet leeg zijn.';
    }
    if ($tijd == '') {
        $errors['time'] = 'Het veldnaam met tijd mag niet leeg zijn.';
    }


    print_r($errors);
    if (empty($errors)) {
        // Now this data can be stored in de database
        $query = "INSERT INTO klanten (voornaam, achternaam, email, datum, tijd)
     VALUES('$voornaam','$achternaam','$email','$datum','$tijd') ";
        $result = mysqli_query($db, $query);
        if ($result) {
            $success = '<p class="error-msg">Je afspraak is opgeslagen</p>';
        } else {
            $errors['db'] = mysqli_error($db);
        }

    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Afspraak</title>
    <link rel="stylesheet" href="registratie.css">

</head>
<body >
<div class="container">
    <div class="container-time">
           <h2 class="heading">Openingstijden</h2>
        <h3 class="heading-days">Maandag-Donderdag</h3>
        <p>12:00-18:00</p>
        <h3 class="heading-days">Vrijdag</h3>
        <p>11:00-21:00</p>
        <h3 class="heading-days">Zaterdag</h3>
        <p>11:00-19:00</p>
        <h3 class="heading-days">Zondag</h3>
        <p>Gesloten</p>

        <hr>

     <h4 class="heading-phone">Tel: 06 42960014 </h4>
    </div>




<div class="container-form">
    <h2 class="heading heading-purple">Afspraak maken</h2>

    <?php
    if (isset($errors['db'])){
        echo $errors['db'];
    }elseif (isset($success)){
        echo $success;
    }
    ?>


    <form action="" method="post">

        <hr>
            <div class="data-field">
            <label for="voornaam">voornaam</label>
            <input id="voornaam" type="text" name="voornaam"
                   value="<?=  isset($voornaam) ? htmlentities($voornaam): ''  ?>"/>
                <span><?php if (isset($errors['voornaam'])){ echo $errors['voornaam']; } ?></span>
        </div>
        <div class="data-field">
            <label for="achternaam">achternaam</label>
            <input id="achternaam" type="text" name="achternaam"
                   value="<?= isset($achternaam) ? htmlentities($achternaam) : '' ?>"/>
            <span><?php if (isset($errors['achternaam'])){ echo $errors['achternaam']; } ?></span>
        </div>
        <div class="data-field">
            <label for="e-mail">e-mail</label>
            <input id="e-mail" type="text" name="e-mail"
                   value="<?= isset($email) ? htmlentities($email) : '' ?>"/>

        </div>
        <div class="data-field">
            <label for="datum">Datum</label>
            <input id="datum" type="date"  name="datum"
              value="  <?= isset($datum) ? htmlentities($datum) : '' ?>"/>
            <span><?php if (isset($errors['datum'])){ echo $errors['datum']; } ?></span>
        </div>
        <div class="data-field">
            <label for="time">Tijd</label>
            <input id="time" type="time"  name="time"
            value="<?= isset($tijd) ? htmlentities($tijd): ''?>"/>
            <span><?php if (isset($errors['time'])){ echo $errors['time']; } ?></span>
        </div>

           <div class="data-submit">
               <input type="submit" name="submit" value="Save"/>
           </div>
       </div>

</div>

<div>
    <a href="../../CLE-2-RESERVERINGSSYSTEEM/reservering/mainpage.html">Terug naar de homepage</a>
</div>
</body>
</html>


