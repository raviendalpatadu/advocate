<?php require('../connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<?php
$template = new template();
$func = new functions();
$template->getHeader('Calendar');
?>

<link rel="stylesheet" href="../../css/fullcalendar.css" />
<link rel="stylesheet" href="../../css/matrix-style.css" />
<script src="../../js/moment.min.js"></script>
<script src="../../js/fullcalendar.min.js"></script>

<body>
  <!-- begin of nav bar -->
  <?php $template->getNavBar('main');
  $template->getSideBar(); ?>

  <div id="content">
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box widget-calendar">
            <div class="widget-content">
              <div class="panel-left">
                <div id="fullcalendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <script>
      $(document).ready(function() {

        $('#fullcalendar').fullCalendar({
          eventLimit: true,
          editable:false,
          themeSystem: 'bootstrap',
          header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,basicWeek,basicDay'
          },
          // height: 475,
          eventClick: function(event) {
            console.log(event.caseId);
            console.log(event.clientId);
            var caseId = event.caseId;
            var clientId = event.clientId;
            window.location.replace("caseupdate.php?clientId=" + clientId + "&caseId=" + caseId + "&resultTemplate=single&caseType=" + event.description + "&from=calender");
          },
          eventMouseover: function(calEvent, jsEvent) {
            var tooltip = '<div class="tooltipevent" style="width:auto;height:auto;background:#17a2b8;color:white;font-weight:bold;padding:5px;border-radius:15px;position:absolute;z-index:10001;">' + calEvent.description + '</div>';
            var $tooltip = $(tooltip).appendTo('body');

            $(this).mouseover(function(e) {
              $(this).css('z-index', 10000);
              $tooltip.fadeIn('500');
              $tooltip.fadeTo('10', 1.9);
            }).mousemove(function(e) {
              $tooltip.css('top', e.pageY + 10);
              $tooltip.css('left', e.pageX + 20);
            });
          },

          eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.tooltipevent').remove();
          },

          eventSources: [

            // your event source
            {
              url: '_php/_calendar.php', // use the `url` property
            }

            // any other sources...

          ]
        });

      });
    </script>

</body>
<?php //
$template->getFooter();
?>


</html>
<?php
mysqli_close($connection);
?>