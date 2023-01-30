<?php require('../connection.php'); ?>

<!DOCTYPE html>
<html lang="en">

<?php
$template = new template();
$template->getHeader('Contact');
?>

<body onload="startTime()">
 <!DOCTYPE html>
<html dir="ltr" lang="en-US">
   <head>
      <meta charset="UTF-8" />
      <title>A date range picker for Bootstrap</title>

      <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" />-->

      <!-- <link rel="stylesheet" type="text/css" media="all" href="daterangepicker.css" /> -->

      <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script> -->

      <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script> -->

      <!-- <script type="text/javascript" src="daterangepicker.js"></script> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   </head>
   <body style="margin: 60px 0">

      <div class="container">

        <h1 style="margin: 0 0 20px 0">Configuration Builder</h1>

        <div class="well configurator">
           
          <form>
          <div class="row">

            <div class="col-md-4">

              <div class="form-group">
                <label for="parentEl">parentEl</label>
                <input type="text" class="form-control" id="parentEl" value="" placeholder="body">
              </div>

              <div class="form-group">
                <label for="startDate">startDate</label>
                <input type="text" class="form-control" id="startDate" value="07/01/2015">
              </div>

              <div class="form-group">
                <label for="endDate">endDate</label>
                <input type="text" class="form-control" id="endDate" value="07/15/2015">
              </div>

              <div class="form-group">
                <label for="minDate">minDate</label>
                <input type="text" class="form-control" id="minDate" value="" placeholder="MM/DD/YYYY">
              </div>

              <div class="form-group">
                <label for="maxDate">maxDate</label>
                <input type="text" class="form-control" id="maxDate" value="" placeholder="MM/DD/YYYY">
              </div>

            </div>
            <div class="col-md-4">

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="autoApply"> autoApply
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="singleDatePicker"> singleDatePicker
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="showDropdowns"> showDropdowns
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="showWeekNumbers"> showWeekNumbers
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="showISOWeekNumbers"> showISOWeekNumbers
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="timePicker" checked="checked"> timePicker
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="timePicker24Hour"> timePicker24Hour
                </label>
              </div>

              <div class="form-group">
                <label for="timePickerIncrement">timePickerIncrement (in minutes)</label>
                <input type="text" class="form-control" id="timePickerIncrement" value="1">
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="timePickerSeconds"> timePickerSeconds
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="dateLimit"> dateLimit (with example date range span)
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="ranges" checked="checked"> ranges (with example predefined ranges)
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="locale"> locale (with example settings)
                </label>
                <label id="rtl-wrap">
                  <input type="checkbox" id="rtl"> RTL (right-to-left)
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="alwaysShowCalendars"> alwaysShowCalendars
                </label>
              </div>

            </div>
            <div class="col-md-4">

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="linkedCalendars" checked="checked"> linkedCalendars
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="autoUpdateInput" checked="checked"> autoUpdateInput
                </label>
              </div>

              <div class="checkbox">
                <label>
                  <input type="checkbox" id="showCustomRangeLabel" checked="checked"> showCustomRangeLabel
                </label>
              </div>

              <div class="form-group">
                <label for="opens">opens</label>
                <select id="opens" class="form-control">
                  <option value="right" selected>right</option>
                  <option value="left">left</option>
                  <option value="center">center</option>
                </select>
              </div>

              <div class="form-group">
                <label for="drops">drops</label>
                <select id="drops" class="form-control">
                  <option value="down" selected>down</option>
                  <option value="up">up</option>
                </select>
              </div>

              <div class="form-group">
                <label for="buttonClasses">buttonClasses</label>
                <input type="text" class="form-control" id="buttonClasses" value="btn btn-sm">
              </div>

              <div class="form-group">
                <label for="applyClass">applyClass</label>
                <input type="text" class="form-control" id="applyClass" value="btn-success">
              </div>

              <div class="form-group">
                <label for="cancelClass">cancelClass</label>
                <input type="text" class="form-control" id="cancelClass" value="btn-default">
              </div>

            </div>

          </div>
          </form>

        </div>

        <div class="row">

          <div class="col-md-4 col-md-offset-2 demo">
            <h4>Your Date Range Picker</h4>
            <center>
              <input type="text" id="config-demo" class="form-control">
            </center>
          </div>

          <div class="col-md-6">
            <h4>Configuration</h4>

            <div class="well">
              <textarea id="config-text" style="height: 300px; width: 100%; padding: 10px"></textarea>
            </div>
          </div>

        </div>

      </div>

      <style type="text/css">
      .demo { position: relative; }
      .demo i {
        position: absolute; bottom: 10px; right: 24px; top: auto; cursor: pointer;
      }
      </style>
<?php
require_once('../../connection.php');
$func = new functions();

// echo 'dfdsfd';
if (isset($_POST['mon'])) {
    $yearAndMonth = $_POST['mon'];
    $splitMontAndDate= preg_split("/[\s]+/",$yearAndMonth);
    $month = $splitMontAndDate[0];
    $year = $splitMontAndDate[1];
    // echo $yearAndMonth. "--> " .$month. "--->" . $year;
    switch ($month) {
        case 'January':
            $month = 1;
            break;
        case 'February':
            $month = 2;
            break;
        case 'March':
            $month = 3;
            break;
        case 'April':
            $month = 4;
            break;
        case 'May':
            $month = 5;
            break;
        case 'June':
            $month = 6;
            break;
        case 'July':
            $month = 7;
            break;
        case 'August':
            $month = 8;
            break;
        case 'September':
            $month = 9;
            break;
        case 'October':
            $month = 10;
            break;
        case 'November':
            $month = 11;
            break;
        case 'December':
            $month = 12;
            break;
        
        
    }
    $query = "SELECT DATE_FORMAT(case_date , '%Y %M  %e') AS case_date ,case_name FROM casedetails WHERE case_isDelete=0 AND MONTH(case_date) = 0{$month} ORDER BY case_date ASC";
    $result = mysqli_query($connection, $query);
    $func->verify_query($result);
    $func->verify_query($result);
    $user_list = '';
    
    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            $user_list .= $user['case_date'] . '-->' . $user['case_name'] . ',';   
           
        } 
    }else{
        $user_list .= "No result Found";
    }
    
    echo $user_list;
}

      
<!-- // calender script my -->
<script>
      $(document).ready(function() {
        var mon;
        // title of the calendar
        var mon = $('.fc-header-title strong').text();
        // console.log(mon);

        // if changed
        $('.fc-header-title strong').bind('DOMSubtreeModified', function() {
          $('#mydates').remove();
          var mon = $('.fc-header-title strong').text();
          console.log(mon);
          var $j = jQuery.noConflict();
          $.ajax({
            type: "POST",
            url: "_php/_calendar.php",
            data: {
              mon: mon,
            },
            success: function(data) {
              // console.log(data);
              
              var mo = $('.fc-header-title strong').text();
              var spiData = data.split(",");
              var len = spiData.length;
              // console.log(mo);

              $('#mydates').remove();
              for (let index = 0; index < len; index++) {

                var caseAndDate = spiData[index].split("-->");
                var caseName = caseAndDate[1];
                var CaseDate = caseAndDate[0];

                var dates = CaseDate.split(" ");
                // console.log(dates);

                // data from database

                var year = dates[0];
                var month = dates[1];
                var day = dates[3];
                // console.log(day);

                // var mon = title of the calendar

                // console.log(mon);
                var getY_M = mon.split(" ");
                var getYear = getY_M[1];
                var getMonth = getY_M[0];
                if (getMonth == month && getYear == year) {
                  // console.log("getmon: "+getMonth+"-->monthfrom db: "+month);
                  //selecting the correct date colunm
                  for (i = 1; i <= 42; i++) {
                    var loop = $('td:not(.fc-other-month).fc-day' + i + ' > div > .fc-day-number').text();
                    // console.log("loop: "+loop+"---- day: "+day);
                    if (loop == day) {
                      console.log("i"+i);
                      var calandarDate = $('td:not(.fc-other-month).fc-day' + i + ' > div > div.fc-day-content').after("<div id=\"mydates\" style=\"position:relative; background-color:red; color:white\">" + caseName + "</div>");
                      break;
                    }
                  }
                }

              }

            }
          });
        });

        // getting dates from datase and loading them into the calendar
        // var $j = jQuery.noConflict();
        // $.ajax({
        //   type: "POST",
        //   url: "_php/_calendar.php",
        //   data: {
        //     mon: mon,
        //   },
        //   success: function(data) {
        //     var mo = $('.fc-header-title strong').text();
        //     var spiData = data.split(",");
        //     var len = spiData.length;
        //     // console.log(mo);


        //     for (let index = 0; index < len; index++) {
        //       var caseAndDate = spiData[index].split("-->");
        //       var caseName = caseAndDate[1];
        //       var CaseDate = caseAndDate[0];

        //       var dates = CaseDate.split(" ");
        //       console.log(dates);

        //       // data from database

        //       var year = dates[0];
        //       var month = dates[1];
        //       var day = dates[3];
        //       // console.log(day);

        //       // var mon = title of the calendar

        //       // console.log(mon);
        //       var getY_M = mon.split(" ");
        //       var getYear = getY_M[1];
        //       var getMonth = getY_M[0];
        //       if (getMonth == month && getYear == year) {
        //         // console.log(day);

        //         //selecting the correct date colunm
        //         for (i = 1; i <= 42; i++) {
        //           var loop = $('.fc-day' + i + ' > div > .fc-day-number').text();
        //           // console.log("loop: "+loop+"---- day: "+day);
        //           if (loop == day) {
        //             // console.log(loop);
        //             var calandarDate = $('.fc-day' + i + ' > div > div.fc-day-content').append("<div style=\"position:relative; background-color:red; color:white\">" + caseName + "</div>");
        //             break;
        //           }
        //         }



        //       }

        //     }

        //   }
        // });

      });
    </script>

   </body>
</html>

<?php
$template->getFooter();
mysqli_close($connection);
?>