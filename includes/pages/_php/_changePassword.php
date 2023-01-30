<?php
require('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {
    $id = $_POST['id'];

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    // echo $id;
    echo $password .'<br>';
    echo $confirm_password;
    if (empty($password) || empty($confirm_password)) {
        $_SESSION['errors'][] = "Please enter data";
        header("Location:" . BASE_URL . "includes/pages/changePassword.php?userId={$id}");

    }
    if (empty($_SESSION['errors'])) {
        $password = sha1(trim(mysqli_real_escape_string($connection, $_POST['password'])));
        $confirm_password = sha1(trim(mysqli_real_escape_string($connection, $_POST['confirm_password'])));
        
    
        if ($password != $confirm_password) {
            $_SESSION['errors'][] = "Passwords Doesn\'t match";
        }
        $query = "UPDATE userdetails SET user_password='$confirm_password' WHERE user_id='$id'";
        $result = mysqli_query($connection, $query);
        $func->verify_query($result);

        if ($result == 1) {
            header("Location:" . BASE_URL . "includes/pages/userProfile.php?userId={$id}&password=ture");
        }
    }
}
if (isset($_POST['back'])) {
    $id = $_POST['id'];
    header("Location:" . BASE_URL . "/includes/pages/userProfile.php?userId=$id");
}


mysqli_close($connection);
