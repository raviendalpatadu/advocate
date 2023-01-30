<?php
require_once('../../connection.php');
$func = new functions();
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $id = mysqli_real_escape_string($connection, $_POST['idno']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

    //checking required fields
    $required_field = array('name','idno','phone','address','email','password','confirm_password');
    $func->check_required_fields($required_field);

    //check whether the email is valid
    if (!$func->is_email($_POST['email'])) {
        $_SESSION['errors'][] = 'Email address is invalid.';
    }

    //checking max characters
    $maxchar = array('name' => 100,'idno' => 12,'email' => 100,'password' => 500,'phone' => 10);
    $func->check_max_len($maxchar);
    //checking whether the entered passwords match
    if ($confirm_password != $password) {
        $_SESSION['errors'][] = 'Passwords Does Not Match';
    }
    if (empty($_SESSION['errors'])) {
        $passwordH = sha1($password);
        $query = "INSERT INTO userdetails (user_name, user_NIC, user_email, user_address, user_password, user_tel, user_type) ";
        $query .= "VALUES('$name', '$id', '$email', '$address', '$passwordH', '$phone', 'USER') LIMIT 1"; 
        $func->verify_query($query); 
        $result = mysqli_query($connection, $query);
        if ($result) {
            $_SESSION['active'] = 'main';
            header("Location:" . BASE_URL . "includes/pages/adduser.php?create=true");
        } 
    } else{
        $_SESSION['active'] = 'main';
        header('Location:'. BASE_URL . 'includes/pages/adduser.php');
    }
}
$connection->close();
?>