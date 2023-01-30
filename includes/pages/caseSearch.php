<?php require('../connection.php');
$template = new template();
$func = new functions();
?>
<!DOCTYPE html>
<html lang="en">
<?php $template->getHeader('Case Search'); ?>

<body onload="startTime()">
    <?php $template->getNavBar('main');
    $template->getSideBar();
    ?>
    <section class="get-in-touch">
                <form action="_php/_caseSearch.php" method="post">
        <div class="container-fulid">
            <div class="row-fluid get-in-touch">
                <!-- <section class=""> -->
                <h1 class="title">Case Search</h1>
                <?php
                if (!empty($_SESSION['errors'])) {
                    $func->display_errors($_SESSION['errors'], 'errors');
                }
                if (isset($_GET['create'])) {
                    echo '<div class="alert alert-success" id="alert-msg">Client/Case Updated. </div>';
                }
                ?>
                    <!-- <div class="container-fluid"> -->
                        <div class="contact-form row">
                            <div class="form-field col-lg-6">
                                <input id="case_num" class="input-text" type="text" name="caseNumber">
                                <label for="case_num" class="label"> Case number</label>
                                <i class="fas fa-briefcase"></i>
                            </div>

                            <div class="form-field col-lg-6">
                                <input id="Client_nic" class="input-text" type="text" name="client_nic">
                                <label for="Client_nic" class="label">Client NIC</label>
                                <i class="far fa-address-card"></i>
                            </div>
                        </div>
                        <div class="contact-form row">
                            <div class="form-field col-lg-6">
                                <input type="submit" name="submit" value="Submit" class="Submit-btn">
                            </div>
                            <div class="form-field col-lg-6">
                                <input type="reset" name="" value="Reset" class="Submit-btn" id="reset">
                            </div>
                        </div>
                    <!-- </div> -->

            </div>

        </div>
                </form>
    </section>
</body>

</html>
<?php $template->getFooter(); ?>
<?php mysqli_close($connection); ?>