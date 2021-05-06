<?php
if (isset($_POST["submit"])) {
    include_once('functions.inc.php');
    include_once('db.inc.php');

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];

    if (emptyInputs($firstname,$lastname,$username,$password,$repeat_password) == true) {
        header("Location: ../register.php?error=emptyinputs");
        exit();
    } else if (incorrectLogin($username) == true) {
        header("Location: ../register.php?error=incorrectlogin");
        exit();
    } else if (passwordsMismatch($password,$repeat_password) == true) {
        header("Location: ../register.php?error=passwordsmismatch");
        exit();
    } else if(loginTaken($connection,$username) != false) {
        header("Location: ../register.php?error=logintaken");
        exit();
    }
    createUser($connection,$firstname,$lastname,$username,$password);
} else {
    header("Location: ../register.php");
    exit();
}
?>