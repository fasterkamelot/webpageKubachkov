<?php
function emptyInputs($firstname,$lastname,$username,$password,$repeat_password) {
    $result;
    if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($repeat_password)) {
        $result = true;
    } else {
        $result = false;
    } 
    return $result;
}
function passwordsMismatch($password,$repeat_password) {
    $result;
    if ($password != $repeat_password){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function incorrectLogin($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
        $result = true;
    } else {
        $result = false;
    }
    echo $result;
    return $result;
}
function createUser($connection,$firstname,$lastname,$username,$password) {
    $sql = "INSERT INTO users (firstname,lastname,username,password) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../register.php?error=stmt");
        exit();
    }
    $pwdhashed = password_hash($password,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssss",$firstname,$lastname,$username,$pwdhashed);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../register.php?registration=success");
}
function loginTaken($connection,$username) {
    $result;
    $sql = "SELECT * FROM users WHERE username = ?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../register.php?error=stmt");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s",$username);
    mysqli_stmt_execute($stmt);
    $query_get = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($query_get)) {
        return $row; 
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
function userLogin($connection,$username,$password) {
    $userExists = loginTaken($connection,$username);
    if ($userExists == false) {
            header("Location: ../login.php?error=wronglogin");
            exit();
    }
    $hashedpwd = $userExists["password"];
    $checkpwd = password_verify($password,$hashedpwd);
    if($checkpwd == false) {
        header("Location: ../login.php?error=wronglogin");
        exit();
    } else if ($checkpwd == true) {
        session_start();
        $_SESSION['id'] = $userExists['id'];
        $_SESSION['firstname'] = $userExists['firstname'];
        $_SESSION['lastname'] = $userExists['lastname'];
        $_SESSION['username'] = $userExists['username'];
        $_SESSION['profileimage'] = $userExists['profileimage'];
        header("Location: ../index.php");
        exit();
    }
}
function emptyInputsLogin($username,$password) {
    $result;
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function profileEdit($username,$uploadedfile,$connection) {
    $sql = "UPDATE users SET profileimage = ? WHERE username = ?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../profile.php?error=stmt");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"ss",$uploadedfile,$username);
    mysqli_stmt_execute($stmt);
    $query_get = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../profile.php");
    if (empty($profileimage)) {
        header("Location: ../profile.php");
    }
}
function nameChange($connection,$firstname,$lastname,$username) {
    $result;
    if (empty($firstname) || empty($lastname) || !preg_match("/^[a-zA-Z0-9]*$/",$firstname) || !preg_match("/^[a-zA-Z0-9]*$/",$lastname)) {
        $result = true;
        unset($_SESSION["firstname"]); unset($_SESSION["lastname"]);
        $sql = "UPDATE users WHERE username = ? SET firstname = ? and lastname = ?;";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../profile.php?error=stmt");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"sss",$username,$firstname,$lastname);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ../profile.php");
    } else {
        $result = false;
    }
    echo $result;
    return $result;
}
?>
