<?php
// session_start();

class template
{
    //load the template

    //gets the <head> part of document
    //CSS in this part
    public function getHeader($title, $page = 'main')
    {
        if ($page == 'main') {
            if (!isset($_SESSION['dbId'])) {
                header('Location:zindex.php');
            }
        }

        echo '
        <head>
            <meta charset="UTF-8">
            <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="X-UA-Compatible" content="ie=edge" />
            <title>' . $title . '</title>
                <link rel="stylesheet" href="' . BASE_URL . 'css/main.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/bootstrap.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/bootstrap.min.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/bootstrap-grid.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/bootstrap-grid.min.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/bootstrap-reboot.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/bootstrap-reboot.min.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/bootstrap-responsive.min.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/fontawesome-free-5.15.1-web/css/all.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/fontawesome-free-5.15.1-web/css/all.min.css">
                <link rel="stylesheet" type="text/css" media="all" href="' . BASE_URL . 'css/daterangepicker.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/sidebar.css">
                <link rel="stylesheet" href="' . BASE_URL . 'css/forms.css">
                <script src="' . BASE_URL . 'js/jquery.js"></script>
                <script src="' . BASE_URL . 'js/jquery.min.js"></script>
        </head>
        ';
    }
    //gets the <script> part of document
    public function getFooter()
    {
        echo '
        
        <!--wrapper-->
        </div>
        
        <script>
            $(document).ready(function () {
                $(\'#sidebarCollapse\').on(\'click\', function () {
                    $(\'#sidebar\').toggleClass(\'active\');
                });
            });  
        </script>
        <script>
            setTimeout(function() {
                $(\'#alert-msg\').remove();
            }, 3000);
        </script>
        <script src="' . BASE_URL . 'js/bootstrap.min.js"></script>
        <script src="' . BASE_URL . 'js/jquery.ui.custom.js"></script>
        <script src="' . BASE_URL . 'js/moment.min.js"></script>    
        <script src="' . BASE_URL . 'js/popper.min.js"></script>
        
        ';
        // clock
        echo '
        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                // add a zero in front of numbers<10
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById("clock").innerHTML = h + ":" + m + ":" + s;
                var t = setTimeout(function(){ startTime() }, 500);
            }

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }
        </script>
        <script>

        var overlay = document.getElementById("overlay");
            window.addEventListener(\'load\', function(){
                overlay.style.display = \'none\';
            })
        </script>
        ';
    }
    //gets the navigation bar of document
    public function getNavBar($name)
    {
        //gives the navigation bar.
        // parameter should be either 'login' for login page or 'main' for the rest
        $value = $name;
        if ($value == 'main') {
            echo "
            <nav class=\"navbar navbar-dark navbar-expand-sm bg-info\" id=\"navbar\">
                <a href=\"" . BASE_URL . "includes/pages/main.php\" class=\"navbar-brand\"><img src=\"" . BASE_URL . "img/menu.png\" style=\"width:145px;height:45px;\"></a>
                <div class=\"collapse navbar-collapse justify-content-center\" id=\"clock\">
                </div>
                    <ul class=\"navbar-nav\">
                    
                    <li class=\"nav-item\"><a href=\"" . BASE_URL . "includes/pages/userProfile.php?userId={$_SESSION['dbId']}\" class=\"nav-link\"><i class=\"far fa-user-circle\"></i> Hello " . ucfirst($_SESSION['dbName']) . "!</a></li>
                    <li class=\"nav-item\"><a href=\"" . BASE_URL . "includes/pages/calender.php\" class=\"nav-link\"><i class=\"far fa-calendar-alt\"></i> Calendar</a></li>
                    <li class=\"nav-item\"><a class=\"nav-link\" onclick=\"logout()\"><i class=\"fas fa-sign-out-alt\"></i> Logout</a></li>
                    </ul>
            </nav>";
        }?>
        <script>
            function logout() {
                if (confirm("Are you sure you want to logout?")) {
                    window.location.href="<?php echo  BASE_URL . "includes/pages/_php/_logout.php";?>";
                }
            }
        </script>
    <?php }
    // //gets the sidebar of document
    public function getSideBar()
    {
        echo '
        <div id="overlay">
            <div class="spinner"></div> 
        </div>
        <div class="wrapper">
            <nav id="sidebar">
                <!--<div class="sidebar-header">
                    <h3>
                    </h3>
                </div>-->


                <ul class="list-unstyled components">
                    <p></p>
                    <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="far fa-user"> Client</i></a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/clientRegistration.php"><i class="fas fa-user-plus"></i> Client Registration</a>
                            </li>
                            <li>
                                <!--search-->
                                <a href="' . BASE_URL . 'includes/pages/clientProfile.php"><i class="fas fa-users"></i> Client Profile</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-cog"></i> User</a>
                        <ul class="collapse list-unstyled" id="userSubmenu">';
        if ($_SESSION['usertype'] == 'ADMIN') {
            echo '
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/adduser.php"><i class="fas fa-user-plus"></i> User Registration</a>
                            </li>
                            ';
        }
        echo '<li>
                                <!--search-->
                                <a href="' . BASE_URL . 'includes/pages/userProfile.php"><i class="fas fa-users"></i> User Profile</a>
                            </li>

                        </ul>
                    </li>

                    
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-balance-scale"></i> Case</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=deed"><i class="fab fa-deezer"></i>  Deeds</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=submission"><i class="fab fa-deezer"></i>  Submission</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=CHARGE SHEET"><i class="fab fa-deezer"></i>  Charge Sheet</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=estate case"><i class="fab fa-deezer"></i>  Estate Cases</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType= URBAN CONCIL-PRADESHEEYA SABHA"><i class="fab fa-deezer"></i>  Urban Council/Pradeshiya Sabha</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=bail"><i class="fab fa-deezer"></i>  Bail Cases</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=high court"><i class="fab fa-deezer"></i>  High Court</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=ARBITRATION(ENTHARAWASI)"><i class="fab fa-deezer"></i>  Arbitration(entharawasi)</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=AGREEMENTS"><i class="fab fa-deezer"></i>  Agreements</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=family matters"><i class="fab fa-deezer"></i>  Family Matters</a>
                            </li>
                            <li>
                                <a href="' . BASE_URL . 'includes/pages/caseType.php?caseType=s-list"><i class="fab fa-deezer"></i>  S-List</a>
                            </li> 
                        </ul>
                    </li>
                    <li>
                        <a href="' . BASE_URL . 'includes/pages/cases.php"><i class="fas fa-briefcase"></i> Cases</a>
                    </li>
                    <li>
                        <a href="' . BASE_URL . 'includes/pages/caseRegistration.php"><i class="fas fa-briefcase"></i> Case Registration</a>
                    </li>
                    <li>
                        <a href="' . BASE_URL . 'includes/pages/caseSearch.php"><i class="fas fa-search"></i> Case Search</a>
                    </li>
                    
                </ul>

                <ul class="list-unstyled CTAs">
                    <li>
                        
                    </li>
                    <li>
                        
                    </li>
                </ul>
            </nav>';
    }
}

class functions
{
    // check for errors in mysqli queries
    public function verify_query($result)
    {
        global $connection;
        if (!$result) {
            die('query failed' . mysqli_error($connection) . mysqli_errno($connection));
        }
    }

    //checks requierd fields
    public function check_required_fields($req_field)
    {
        $errors = array();

        foreach ($req_field as $field) {
            if (empty(trim($_POST[$field]))) {
                $_SESSION['errors'][] = $field . " is required";
            }
        }
        return $errors;
    }
    //displays errors of arrays
    public function display_errors($errors, $session_name)
    {
        // format and displays form errors
        echo '<div class="alert alert-danger" id="alert-msg" role="alert">';
        foreach ($errors as $error) {
            $error = ucfirst(str_replace("_", " ", $error));
            echo '- ' . $error . '<br>';
        }
        echo '</div>';

        unset($_SESSION[$session_name]);
    }
    //displays errors of arrays
    public function display_success($success, $session_name)
    {
        // format and displays form errors
        echo '<div class="alert alert-success" role="alert">';
        foreach ($success as $msg) {
            $msg = ucfirst(str_replace("_", " ", $msg));
            echo '- ' . $msg . '<br>';
        }
        echo '</div>';

        unset($_SESSION[$session_name]);
    }
    //    check max length of an input field
    public function check_max_len($max_len_fields)
    {
        // checks max length
        $errors = array();

        foreach ($max_len_fields as $field => $max_len) {
            if (strlen(trim($_POST[$field])) > $max_len) {
                $_SESSION['errors'][] = $field . ' must be less than ' . $max_len . ' characters';
            }
        }
        return $errors;
    }

    //check whether the Email is valid
    public function is_email($email)
    {
        return (preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
    }

    // pagination
    public function pagination($tableName, $row_per_page, $start=null, $page_no=null)
    {   
        global $connection;
        $count = $tableName.'_id';
        $table = $tableName.'details';
        $query_pagination = "SELECT COUNT($count) AS total_rows FROM $table";
        $result_pagination = mysqli_query($connection, $query_pagination);
        $rows = mysqli_fetch_assoc($result_pagination);

        $total_rows = $rows['total_rows'];
        // echo $total_rows;
        $rows_per_page = $row_per_page;

        if (isset($_GET['pageNo'])) {
            $page_no = $_GET['pageNo'];
        } else {
            $page_no = 1;
        }

        if ($total_rows <= 10) {
            $start = 0;
        } else {
            $start = ($page_no - 1) * $rows_per_page;
            $row_per_page = 10;
        }
    }
}
