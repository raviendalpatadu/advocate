<?php
require('../connection.php');
$template = new template();
$func = new functions();
?>
<?php
if (isset($_GET['resultTemplate']) || isset($_GET['client_id'])) {
    if ($_GET['resultTemplate'] == 'single') {
        // after go button is pressed in many search results are found
        if (isset($_GET['client_id']) && isset($_GET['case_id'])) {
            $client_id = $_GET['client_id'];
            $case_id = $_GET['case_id'];
            $query = "SELECT * FROM casedetails, clientdetails ";
            $query .= "WHERE clientdetails.client_id = '$client_id' AND casedetails.case_id='$case_id' LIMIT 1";

            $result = mysqli_query($connection, $query);
            $func->verify_query($result);

            $search = mysqli_fetch_assoc($result);
            $_SESSION['search_res']['number'] = $search['case_number'];
            $_SESSION['search_res']['court'] = $search['case_court'];
            $_SESSION['search_res']['name'] = $search['case_name'];
            $_SESSION['search_res']['sectionNumber'] = $search['case_sectionNumber'];
            $_SESSION['search_res']['decision'] = $search['case_decision'];
            $_SESSION['search_res']['type'] = $search['case_type'];
            $_SESSION['search_res']['date'] = $search['case_date'];
            $_SESSION['search_res']['client_id'] = $search['client_id'];
            $_SESSION['search_res']['case_id'] = $search['case_id'];
            $_SESSION['search_res']['delete'] = $search['case_isDelete'];
        }
        $number = $_SESSION['search_res']['number'];
        $court = $_SESSION['search_res']['court'];
        $name = $_SESSION['search_res']['name'];
        $sectionNumber = $_SESSION['search_res']['sectionNumber'];
        $decision = $_SESSION['search_res']['decision'];
        $type = $_SESSION['search_res']['type'];
        $date = $_SESSION['search_res']['date'];
        $delete = $_SESSION['search_res']['delete'];
        // whole html code under echo
        $resultrescived = '
                <section class="get-in-touch">
                    <h1 class="title">Search Result</h1>
                    <form action="searchResult.php" method="post">
                        <div class="container-fluid">
                            <div class="contact-form row">
                                <div class="form-field col-lg-6">
                                    <input id="case_num" class="input-text" type="text" name="caseNumber" value="' . $number . '">
                                    <label for="case_num" class="label"> Case Number</label>
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="case_num" class="input-text" type="text" name="caseName" value="' . $name . '">
                                    <label for="case_num" class="label"> Case Name</label>
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="Section_num" class="input-text" type="text" name="sectionNumber" value="' . $sectionNumber . '">
                                    <label for="Section_num" class="label">Section Number</label>
                                    <i class="fas fa-list-ol"></i>
                                </div>

                                <div class="form-field col-lg-6">
                                    <input id="case_date" class="input-text" type="text" name="caseCourt" value="' . $court . '" >
                                    <label for="case_date" class="label"> Case Court</label>
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="case_date" class="input-text" type="text" name="caseDecision" value="' . $decision . '">
                                    <label for="case_date" class="label"> Case Decision</label>
                                    <i class="fas fa-poll"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="case_date" class="input-text" type="text" name="caseDate" value="' . $date . '">
                                    <label for="case_date" class="label"> Case Date</label>
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input id="case_date" class="input-text" type="text" name="caseType" value="' . $type . '">
                                    <label for="case_date" class="label"> Case Type</label>
                                    <i class="fas fa-font"></i>
                                </div>
                            </div>
                            <div class="contact-form row">
                                <div class="form-field col-lg-6">';
                                
                                if($delete == 1){
                                    
                                    $resultrescived .= '<input value="Finished" class="Submit-btn" disabled>';
                                }else{   
                                    $resultrescived .='<input type="submit" name="update" value="Update" class="Submit-btn">';
                                }
             $resultrescived .='</div>
                                <div class="form-field col-lg-6">
                                    <input type="submit" name="back" value="Back" class="Submit-btn">
                                </div>
                            </div>
                        </div>
                    </form>
                </section>';
    }
    // if many search results where found
    elseif ($_GET['resultTemplate'] == 'many') {
        $caseNumber = $_SESSION['search_res']['number'];
        $client_nic = $_SESSION['search_res'] ['client_nic'];

        $query = "SELECT * FROM casedetails, clientdetails WHERE clientdetails.client_id = casedetails.client_fk AND (clientdetails.client_nic = '$client_nic' OR casedetails.case_number = '$caseNumber')";

        $result = mysqli_query($connection, $query);
        $func->verify_query($result);
        $search_list = "";
        while ($search = mysqli_fetch_assoc($result)) {
            $search_list .= "<tr>";
            $search_list .= "<td>{$search['case_number']}</td>";
            $search_list .= "<td>{$search['case_type']}</td>";
            $search_list .= "<td>{$search['client_name']}</td>";
            $search_list .= "<td>{$search['case_date']}</td>";
            if ($search['case_isDelete'] == 1) {
                $search_list .= "<td><li class=\"badge badge-danger\">Finished</li></td>";
            } else{
                $search_list .= "<td><a href=\"searchResult.php?client_id={$search['client_id']}&case_id={$search['case_id']}&resultTemplate=single\" class=\"badge badge-warning\">GO</a></td>";
            }
            $search_list .= "</tr>";
        }
        // html coding
        $resultrescived = '   <div id="content">
                    <div class="container-fluid">';

        if (!empty($_SESSION['errors'])) {
            $func->display_errors($_SESSION['errors'], 'errors');
        } elseif (isset($_GET['create'])) {
            echo '<div class="alert alert-success" id="alert-msg">client Updated. </div>';
        } elseif (isset($_GET['delete'])) {
            echo '<div class="alert alert-success" id="alert-msg">client Deleted. </div>';
        }
        $resultrescived .= '
                        <hr>
                        <div class="row-fluid">
                            <div class="span12">
    
                                <h1>Search Results</h1>
                                <table class="table table-gray-dark table-striped">
                                    <tr>
                                        <th>Case Number</th>
                                        <th>Case Type</th>
                                        <th>Client Name</th>
                                        <th>Case Date</th>
                                        <th>Go</th>
                                    </tr>'
            . $search_list . '
                                </table>
                            </div>
                        </div>
                    </div>';
    }
}


if (isset($_POST['update'])) {
    
    header("Location:" . BASE_URL . "includes/pages/caseUpdate.php?clientId={$_SESSION['search_res'] ['client_id']}&caseId={$_SESSION['search_res'] ['case_id']}&resultTemplate=single&caseType={$_SESSION['search_res'] ['type']}&from=caseSearch");
}
if (isset($_POST['back'])) {
    unset($_SESSION['search_res']);
    header('Location:' . BASE_URL . 'includes/pages/caseSearch.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Case Search'); ?>

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();


    echo $resultrescived;
    ?>



</body>

</html>
<?php
$template->getFooter();
mysqli_close($connection);
?>