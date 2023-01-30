<?php require('../connection.php');
$template = new template();
$func = new functions();

if (isset($_SESSION['clientID'])) {
    // getting the client information
    $client_id = $_SESSION['clientID'];
    $query = "SELECT * FROM clientdetails WHERE client_nic = \"{$client_id}\" LIMIT 1";
    $func->verify_query($query);
    $result_set = mysqli_query($connection, $query);

    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            // user found
            $result = mysqli_fetch_assoc($result_set);
            $id = $result['client_id'];
            $nic = $result['client_nic'];
            $name = $result['client_name'];
        } else {
            // user not found
            echo "u failed";
            // header('Location: users.php?err=user_not_found');	
        }
    } else {
        // query unsuccessful
        echo "q failed";
        // header('Location: users.php?err=query_failed');
    }
} else {
    $id = false;
    $name = null;
    $nic = null;
}






?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Case Registration'); ?>

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();
    ?>
    <section class="get-in-touch">
        <h1 class="title">Case Registration</h1>
        <form action="_php/_caseRegistration.php" method="post" enctype="multipart/form-data">
            <?php
            if (!empty($_SESSION['errors'])) {
                $func->display_errors($_SESSION['errors'], 'errors');
            } elseif (!empty($_SESSION['success'])) {
                $func->display_success($_SESSION['success'], 'success');
            }
            ?>
            <script>
                $(document).ready(function() {
                    var clientId = $('#client_num').val();
                    var clientNic = $('#client_nic').val();
                    var clientName = $('#client_name').val();
                    // $('#searchResult').hide()
                    if (clientId == false) {
                        $('#client_number').hide();

                        $('#client_name').keyup(function() {
                            var clientName = $('#client_name').val();
                            var clientNic = $('#client_nic').val();
                            var $j = jQuery.noConflict();
                            console.log(clientName);
                            $.ajax({
                                type: "POST",
                                url: "_php/_clientSerach.php",
                                data: {
                                    name: $('#client_name').val(),
                                },
                                success: function(data) {
                                    $('#searchResultName').fadeIn();
                                    $('#searchResultName').html(data);
                                }
                            })
                        });
                        $(document).on('click', '#client_name_search', function() {
                            $('#client_name').val($(this).text());
                            $('#searchResultName').fadeOut();
                        });
                        $('#client_nic').keyup(function() {
                            var clientNic = $('#client_nic').val();
                            var $j = jQuery.noConflict();
                            console.log(clientName);
                            $.ajax({
                                type: "POST",
                                url: "_php/_clientSerach.php",
                                data: {
                                    client_nic: $('#client_nic').val(),
                                },
                                success: function(data) {
                                    $('#searchResultNic').fadeIn();
                                    $('#searchResultNic').html(data);
                                }
                            })
                        });

                        $(document).on('click', '#client_nic_search', function() {
                            var dat = $(this).text();
                            $('#client_nic').attr('value', dat);
                            $('#client_nic').val($(this).text());
                            $('#searchResultNic').fadeOut();
                            var $j = jQuery.noConflict();
                            $.ajax({
                                type: "POST",
                                url: "_php/_clientSerach.php",
                                dataType: 'JSON',
                                data: {
                                    nic: dat,
                                },
                                success: function(data) {
                                    $('#h_id').attr('value', data.id);
                                    $('#client_name').attr('value', data.name);
                                }
                            })
                            // console.log(dat);


                        });

                        $('#client_nic').focusout(function() {
                            $('#searchResultNic').fadeOut();
                        });
                        $('#client_name').focusout(function() {
                            $('#searchResultName').fadeOut();
                        });
                    }
                });
            </script>
            <div class="container-fluid">
                <div class="contact-form row">
                    <div class="form-field col-lg-6" id="client_number">
                        <input id="client_num" class="input-text" type="text" name="id" value="<?php echo $id; ?>">
                        <label for="client_num" class="label">Client ID</label>
                        <input type="hidden" id="h_id" name="id" value="<?php echo $id; ?>">
                        <i class="far fa-id-badge"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="client_nic" class="input-text" type="text" name="nic" value="<?php echo $nic; ?>">
                        <label for="client_nic" class="label">Client NIC</label>
                        <i class="far fa-address-card"></i>
                        <div id="searchResultNic" style="position: absolute; z-index:1; background-color:#17a2b8; width:inherit; color:white;">

                        </div>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="client_name" class="input-text" type="text" name="name" value="<?php echo $name; ?>">
                        <label for="client_name" class="label">Client Name</label>
                        <div id="searchResultName" style="position: absolute; z-index:1; background-color:#17a2b8; width:inherit; color:white;">
                        </div>
                        <i class="far fa-user"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <label for="Case_type" class="label"> Case Type</label>
                        <i class="fas fa-font" style="color: #297186;top: 9px;left: 25px;"></i>
                        <select name="caseType" id="Case_type" class="btn btn-info dropdown-toggle" style="padding-left: 30px;height: 34px;padding-top: 4px;">
                            <option value="DEED">DEED</option>
                            <option value="SUBMISSION">SUBMISSION</option>
                            <option value="CHARGE SHEET">CHARGE SHEET</option>
                            <option value="ESTATE CASE">ESTATE CASE</option>
                            <option value="URBAN CONCIL-PRADESHEEYA SABHA">URBAN CONCIL/PRADESHEEYA SABHA</option>
                            <option value="BAIL">BAIL CASES</option>
                            <option value="HIGH COURT">HIGH COURT</option>
                            <option value="ARBITRATION(ENTHARAWASI)">ARBITRATION(ENTHARAWASI)</option>
                            <option value="AGREEMENTS">AGREEMENTS</option>
                            <option value="FAMILY MATTERS">FAMILY MATTERS</option>
                            <option value="S-LIST">S-LIST</option>
                        </select>
                    </div>
                    <script>
                        $(document).ready(function() {
                            var caseType = $('#Case_type').val();
                            if (caseType == 'DEED') {
                                $('#caseNum').text('Deed Number');
                            } else {
                                $('#caseNum').text('Case Number');
                            }
                            $('#Case_type').on('change', function() {
                                var caseType = $('#Case_type').val();
                                if (caseType == 'DEED') {
                                    $('#caseNum').text('Deed Number');
                                } else {
                                    $('#caseNum').text('Case Number');
                                }
                            });
                        });
                    </script>
                    <div class="form-field col-lg-6">
                        <input id="Case_num" class="input-text" type="text" name="caseNumber">
                        <label for="Case_num" class="label" id="caseNum"> Case Number</label>
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="Section_num" class="input-text" type="text" name="sectionNumber">
                        <label for="Section_num" class="label"> section Number</label>
                        <i class="fas fa-list-ol"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="court" class="input-text" type="text" name="court">
                        <label for="court" class="label">Court </label>
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="Decision" class="input-text" type="text" name="decision">
                        <label for="Decision" class="label"> Decision</label>
                        <i class="fas fa-poll"></i>
                    </div>
                    <div class="form-field col-lg-6">
                        <input id="Case_name" class="input-text" type="text" name="caseName">
                        <label for="Case_name" class="label"> Case Name</label>
                        <i class="fas fa-briefcase"></i>
                    </div>

                </div>
                <div class="contact-form row">
                    <div class="form-field col-lg-6">
                        <input id="Case_file" class="btn btn-primary" type="File" name="file[]" multiple>
                        <label for="Case_file" class="label" style="bottom:35px;">UPLOAD FILES</label>
                    </div>
                </div>
                <div class="contact-form row">
                    <div class="form-field col-lg-6">
                        <input type="submit" name="submit" value="Submit" class="Submit-btn">
                    </div>
                    <div class="form-field col-lg-6">
                        <input type="reset" name="" value="Reset" class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
    </section>

</body>

</html>
<script src="../../js/jquery-3.3.1.slim.min.js"></script>
<?php $template->getFooter(); ?>
<?php mysqli_close($connection); ?>