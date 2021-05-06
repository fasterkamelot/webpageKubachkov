<?php
include_once('functions.inc.php');
include_once('db.inc.php');

if (isset($_POST["edit"])) {
    session_start();
    $username = $_SESSION["username"];
    unset($_SESSION["profileimage"]);
    $uploaddir = "uploads/";
    $profileimage_name = $_FILES['profileimage']['name'];
    $profileimage_tmp = $_FILES['profileimage']['tmp_name'];
    $profileimage_size = $_FILES['profileimage']['size'];
    $_SESSION["profileimage"] = $uploaddir . $profileimage_name;
    $uploadedfile = $uploaddir . $profileimage_name;
    if($profileimage_size > 10*1024) {
        exit("Файл слишком большой");
    } else {
        move_uploaded_file($profileimage_tmp,"../".$uploaddir.$profileimage_name);
        profileEdit($username,$uploadedfile,$connection);
    }
} else if (isset($_POST["change"])) {
    session_start();
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_SESSION["username"];
    if (nameChange($connection,$firstname,$lastname,$username) == false) {
        header("Location: ../profile.php?error=emptyinputs");
        exit();
    } else {
      header("Location: ../profile.php");
    }
}
?>