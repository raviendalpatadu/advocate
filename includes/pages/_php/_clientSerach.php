<?php
require_once('../../connection.php');
$func = new functions();
// echo "hello";
$user_list = '';
if (isset($_POST['name'])) {
    // filter set
    $name = trim($_POST['name']);
    
    // echo $nic;

    $query = "SELECT * FROM clientdetails WHERE client_isDelete=0 AND client_name LIKE '%" . $name . "%' ORDER BY client_name  ASC";
    $result = mysqli_query($connection, $query);

    $func->verify_query($result);
    $user_list = '<ul class="list-unstyled">';
    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            
            $user_list .= "<li id = \"client_name_search\">{$user['client_name']}</li>";
            
        } 
    }else{
        $user_list .= "No result Found";
    }
    $user_list .= '</ul>';
    echo $user_list;
}elseif(isset($_POST['client_nic'])){

    $nic = trim($_POST['client_nic']);
    
    // echo $nic;

    $query = "SELECT * FROM clientdetails WHERE client_isDelete=0 AND client_nic LIKE '%" . $nic . "%' ORDER BY client_name  ASC";
    $result = mysqli_query($connection, $query);

    $func->verify_query($result);
    $user_nic = '<ul class="list-unstyled">';
    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            
            $user_nic .= "<li id = \"client_nic_search\">{$user['client_nic']}</li>";
            
        } 
    }else{
        $user_nic .= "No result Found";
    }
    $user_nic .= '</ul>';
    echo $user_nic;
    
} elseif (isset($_POST['nic'])) {
    $nic = $_POST['nic'];
    $query = "SELECT client_id,client_name FROM clientdetails WHERE client_nic = '$nic'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) ==  1) {
        $v = mysqli_fetch_assoc($result);
        $data['id'] = $v['client_id'];
        $data['name'] = $v['client_name'];
        echo json_encode($data);
    }
}
else {
    echo 'failed';
}
