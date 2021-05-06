<?php
session_start();
if (isset($_SESSION["id"])) {
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    echo 'Hello, ' . $_SESSION["username"] .'!';
    echo '<br>';
    echo '<img src="' . $_SESSION["profileimage"] . '" alt="avatar" style="width: 14%;">';
    echo '<br>';
    echo '<br>';
    echo 'Here you can edit your profile!';
    echo '<form action="includes/profile.inc.php" method="POST" enctype="multipart/form-data">';
    echo '<input type="file" name="profileimage" accept="image/*">';
    echo '<br>';
    echo '<button type="submit" name="edit">Edit</button>';
    echo '</form>';
    echo '<h1>' . $firstname . ' ' . $lastname . '</h1>';
    echo '<h2>Change name</h2>';
    echo '<form action="includes/profile.inc.php" method="POST">';
    echo '<input type="text" name="firstname" value="'.$firstname.'">';
    echo '<br><br>';
    echo '<input type="text" name="lastname" value="'.$lastname.'">';
    echo '<br><br>';
    echo '<button type="submit" name="change">Change</button>';
    echo '</form>';
    echo '<a href="includes/logout.inc.php">Logout</a>';




}
?>