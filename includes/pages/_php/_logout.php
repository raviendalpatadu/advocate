<?php
  require('../../connection.php');

//---------------------------logout process------------------------------------------



  // If the user is logged in, delete the session vars to log them out

  if (isset($_SESSION)) {
      
        echo "<h1>up session</h1><pre>";
        print_r($_SESSION);
        echo '</pre>';
        
        
        unset($_SESSION['dbId']);
        unset($_SESSION['dbName']);
        unset($_SESSION['user_type']);
        unset($_SESSION['active']);
        unset($_SESSION['clientID']);
        unset($_SESSION['search_res']);
        unset($_SESSION['errors']);
        unset($_SESSION['today_total_cases']);
        session_destroy();
        header("Location: ". BASE_URL ."index.php?logout=true");

        die();
        
        // check whether the session is unset
        // echo "<h1>down session</h1><pre>";
        // print_r($_SESSION);
        // echo '</pre>';
  }
  
  


?>
