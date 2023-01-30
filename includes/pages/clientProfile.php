<?php require('../connection.php');
$template = new template();
$func = new functions();

// pagination
$query_pagination = "SELECT COUNT(client_id) AS total_rows FROM clientdetails";
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


$query = "SELECT * FROM clientdetails WHERE client_isDelete = 0 LIMIT {$start}, {$rows_per_page}";
$result = mysqli_query($connection, $query);
$func->verify_query($result);


$client_list = '';
while ($client = mysqli_fetch_assoc($result)) {
    $client_list .= "<tr>";
    $client_list .= "<td>{$client['client_id']}</td>";
    $client_list .= "<td>{$client['client_nic']}</td>";
    $client_list .= "<td>{$client['client_name']}</td>";
    $client_list .= "<td><a href=\"clientProfileResult.php?client_id={$client['client_id']}\" class=\"badge badge-warning\"><i class=\"fas fa-edit\"></i> Edit</li></a></td>";
    $client_list .= "<td><a href=\"_php/_clientProfileDelete.php?delete={$client['client_id']}\" class=\"badge badge-danger\"><i class=\"far fa-trash-alt\"> Delete</i></a></td>";
    $client_list .= "</tr>";
}


?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Client Profile'); ?>

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();
    ?>


    <!-- chechking whether the  client id is not set using get method in admin -->


    <div id="content">
        <div class="container-fluid">
            <?php
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            } elseif (isset($_GET['create'])) {
                echo '<div class="alert alert-success" id="alert-msg">client Updated. </div>';
            } elseif (isset($_GET['delete'])) {
                echo '<div class="alert alert-success" id="alert-msg">client Deleted. </div>';
            } ?>

            <hr>
            <div class="row-fluid">
                <div class="span12">

                    <h1>Client Profiles</h1>
                    <table class="table table-gray-dark table-striped">
                        <tr>
                            <th>Client ID</th>
                            <th>Client NIC</th>
                            <th>Client Name</th>
                            <th>Modify Client</th>
                            <th>Delete</th>
                        </tr>
                        <?php echo $client_list ?>
                    </table>
                    <?php 
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
                                            <a class=\"page-link\" href=\"clientProfile.php?pageNo={$previous_page_no}\">Previous</a>
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
                                            <a class=\"page-link\" href=\"clientProfile.php?pageNo={$next_page_no}\">Next</a>
                                        </li>";
                                
                            }
                            echo $previous;
                            for ($i=1; $i<=$last_page_no ; $i++) { 
                                $number = "<li class=\"page-item\"><a class=\"page-link\" href=\"clientProfile.php?pageNo={$i}\">".$i."</a></li>";
                                echo $number;
                            }
                            echo $next.'
                        </ul>
                    </nav>';
                    ?>
                </div>
            </div>
        </div>


</body>

</html>
<?php $template->getFooter(); ?>
<?php mysqli_close($connection); ?>