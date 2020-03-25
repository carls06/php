  <?php
  // error handler function
  function errorHandler($errno, $errstr) {
    echo "<h3 style='text-align:center'>Error: [$errno] $errstr</h3>";
    //echo "<script>alert('Error: [$errno] $errstr');</script>";
    exit();
  }
   
  // set error handler
  set_error_handler("errorHandler");
  ?>