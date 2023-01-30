<?php require('../connection.php');
$template = new template();
$func = new functions();
if ($_SESSION['usertype'] == 'ADMIN') {



    // pagination
    $query_pagination = "SELECT COUNT(user_id) AS total_rows FROM userdetails";
    $result_pagination = mysqli_query($connection, $query_pagination);
    $func->verify_query($result_pagination);
    $rows = mysqli_fetch_assoc($result_pagination);

    $total_rows = $rows['total_rows'];
    // echo $total_rows;
    $rows_per_page = 10;

    if (isset($_GET['pageNo'])) {
        $page_no = $_GET['pageNo'];
    } else {
        $page_no = 1;
    }

    if ($total_rows <= 10) {
        $start = 0;
    } else {
        $start = ($page_no - 1) * $rows_per_page;
        $rows_per_page = 10;
    }



    $query = "SELECT * FROM userdetails WHERE user_type='USER' LIMIT {$start}, {$rows_per_page} ";
    $result = mysqli_query($connection, $query);
    $func->verify_query($result);

    $user_list = '';
    while ($user = mysqli_fetch_assoc($result)) {
        $user_list .= "<tr>";
        $user_list .= "<td>{$user['user_id']}</td>";
        $user_list .= "<td>{$user['user_NIC']}</td>";
        $user_list .= "<td>{$user['user_name']}</td>";
        $user_list .= "<td><a href=\"userProfile.php?userId={$user['user_id']}\" class=\"badge badge-warning\"><i class=\"fas fa-edit\"></i> Edit</li></a></td>";
        $user_list .= "<td><a href=\"_php/_userProfile.php?delete={$user['user_id']}\" class=\"badge badge-danger\"><i class=\"far fa-trash-alt\"> Delete</i></a></td>";
        $user_list .= "</tr>";
    }
} else {
    $value = 'user is in';
}
?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('User Profile'); ?>

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();
    ?>

    <?php
    //chechking whether the  user id is not set using get method in admin
    if (!isset($_GET['userId'])) {
        if ($_SESSION['usertype'] == 'ADMIN') {
            echo '<div id="content">
                                <div class="container-fluid">';
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            } elseif (isset($_GET['create'])) {
                echo '<div class="alert alert-success" >User Updated. </div>';
            } elseif (isset($_GET['delete'])) {
                echo '<div class="alert alert-success" >User Deleted. </div>';
            }

            echo '<hr>
                <div class="row-fluid">
                    <div class="span12">
                        
                        <h1>User Profiles</h1>
                        <table class="table table-gray-dark table-striped">
                            <tr>
                                <th>User ID</th>
                                <th>User NIC</th>
                                <th>User Name</th>
                                <th>Modify User</th>
                                <th>Delete</th>
                            </tr>'
                            . $user_list .
                        '</table>';
            // pagination
            echo "
                <nav aria-label=\"Page navigation example\">
                    <ul class=\"pagination justify-content-center\">
                        <li class=\"page-item\">";
            // last page
            $last_page_no = ceil($total_rows / $rows_per_page);

            //previous page
            if ($page_no <= 1) {
                $previous = "<li class=\"page-item\">
                                <a class=\"page-link\">Previous</a>
                            </li>";
            } else {
                $previous_page_no = $page_no - 1;
                $previous = "<li class=\"page-item\">
                                <a class=\"page-link\" href=\"userProfile.php?pageNo={$previous_page_no}\">Previous</a>
                            </li>";
            }

            // next page
            if ($page_no >= $last_page_no) {
                $next = "<li class=\"page-item\">
                            <a class=\"page-link\">Next</a>
                        </li>";
            } else {
                $next_page_no = $page_no + 1;
                $next = "<li class=\"page-item\">
                            <a class=\"page-link\" href=\"userProfile.php?pageNo={$next_page_no}\">Next</a>
                        </li>";
            }
            echo $previous;
            for ($i = 1; $i <= $last_page_no; $i++) {
                $number = "<li class=\"page-item\"><a class=\"page-link\" href=\"userProfile.php?pageNo={$i}\">" . $i . "</a></li>";
                echo $number;
            }
            echo $next . '
                                                </ul>
                                            </nav>

                                        </div>
                                     </div>
                                </div>
                        ';
        } elseif ($_SESSION['usertype'] == 'USER' || isset($_GET['userId'])) {
            if (isset($_GET['userId'])) {
                $userid = $_GET['userId'];
            } else {
                $userid = $_SESSION['dbId'];
            }
            $query_user = "SELECT * FROM userdetails WHERE user_id = '{$userid}' LIMIT 1";
            $result_user = mysqli_query($connection, $query_user);
            $func->verify_query($result_user);

            $data = mysqli_fetch_assoc($result_user);
            $name = $data['user_name'];
            $email = $data['user_email'];
            $nic = $data['user_NIC'];
            $address = $data['user_address'];
            $tel = $data['user_tel'];


            echo '
            <section class="get-in-touch">
                <h1 class="title"><i class="fas fa-user-edit"></i> '. $name .'</h1>
            <form action="_php/_userProfile.php" method="post">';
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            } elseif (isset($_GET['create'])) {
                echo '<div class="alert alert-success" id="alert-msg" >User Registered. </div>';
            }
            echo "
                <div class=\"container-fluid\">
                            <div class=\"contact-form row\">
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"name\" class=\"input-text\" type=\"text\" name=\"name\" value = \"" . $name . "\">
                                    <label for=\"\" class=\"label\"> Name</label>
                                    <i class=\"far fa-user\"></i>
                                    <input type=\"hidden\" name=\"h_id\" value=\"" . $userid . "\">
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"idno\" class=\"input-text\" type=\"text\" name=\"idno\" value = \"" . $nic . "\">
                                    <label for=\"idno\" class=\"label\">Id Number</label>
                                    <i class=\"far fa-address-card\"></i>
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"phone\" class=\"input-text\" type=\"text\" name=\"phone\" value = \"" . $tel . "\">
                                    <label for=\"phone\" class=\"label\"> Telephone</label>
                                    <i class=\"fas fa-phone-alt\"></i>
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"Address\" class=\"input-text\" type=\"text\" name=\"address\" value = \"" . $address . "\">
                                    <label for=\"Address\" class=\"label\"> Address</label>
                                    <i class=\"fas fa-map-marker-alt\"></i>
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"Address\" class=\"input-text\" type=\"text\" name=\"email\" value = \"" . $email . "\">
                                    <label for=\"Address\" class=\"label\"> Email</label>
                                    <i class=\"far fa-envelope\"></i>
                                </div>

                            </div>
                            <div class=\" contact-form row\">
                                <div class=\"form-field col-lg-6\">
                                    <input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"Submit-btn\">
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <a href=\"changePassword.php?userId={$userid}\" class=\"badge badge-warning\"> Change Password </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>";
        }
        //if user id is set headind to edit interface
    } else {
        if ($_SESSION['usertype'] == 'USER' || isset($_GET['userId'])) {

            if (isset($_GET['userId'])) {
                $userid = $_GET['userId'];
            } else {
                $userid = $_SESSION['dbId'];
            }
            $query_user = "SELECT * FROM userdetails WHERE user_id = '{$userid}' LIMIT 1";
            $result_user = mysqli_query($connection, $query_user);
            $func->verify_query($result_user);

            $data = mysqli_fetch_assoc($result_user);
            $name = $data['user_name'];
            $email = $data['user_email'];
            $nic = $data['user_NIC'];
            $address = $data['user_address'];
            $tel = $data['user_tel'];



            echo '
            <section class="get-in-touch">
                <h1 class="title"><i class="fas fa-user-edit"></i> '. $name .'</h1>
            <form action="_php/_userProfile.php" method="post">';
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            } elseif (isset($_GET['create'])) {
                echo '<div class="alert alert-success" id="alert-msg">User Updated. </div>';
            } elseif (isset($_GET['password'])) {
                echo '<div class="alert alert-success" id="alert-msg">Password Updated. </div>';
            }
            echo "
                <div class=\"container-fluid\">
                            <div class=\"contact-form row\">
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"name\" class=\"input-text\" type=\"text\" name=\"name\" value=\"" . $name . "\">
                                    <label for=\"\" class=\"label\"> Name</label>
                                    <input type=\"hidden\" name=\"h_id\" value=\"" . $userid . "\">
                                    <i class=\"far fa-user\"></i>
                                    </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"idNo\" class=\"input-text\" type=\"text\" name=\"idno\" value=\"" . $nic . "\">
                                    <label for=\"idNo\" class=\"label\">Id Number</label>
                                    <i class=\"far fa-address-card\"></i>
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"Telephone\" class=\"input-text\" type=\"text\" name=\"phone\" value=\"" . $tel . "\">
                                    <label for=\"Telephone\" class=\"label\"> Telephone</label>
                                    <i class=\"fas fa-phone-alt\"></i>
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"address\" class=\"input-text\" type=\"text\" name=\"address\" value=\"" . $address . "\">
                                    <label for=\"address\" class=\"label\"> Address</label>
                                    <i class=\"fas fa-map-marker-alt\"></i>
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <input id=\"email\" class=\"input-text\" type=\"text\" name=\"email\" value=\"" . $email . "\">
                                    <label for=\"email\" class=\"label\"> Email</label>
                                    <i class=\"far fa-envelope\"></i>
                                </div>
                            </div>
                            <div class=\" contact-form row\">
                                <div class=\"form-field col-lg-6\">
                                    <input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"Submit-btn\">
                                </div>
                                <div class=\"form-field col-lg-6\">
                                    <a href=\"changePassword.php?userId={$userid}\" class=\"badge badge-warning\"> Change Password </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>";
        }
    }
    ?>
</body>

</html>
<?php $template->getFooter(); ?>
<?php mysqli_close($connection); ?>