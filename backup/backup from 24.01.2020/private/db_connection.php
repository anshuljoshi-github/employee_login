<?php

  define("DB_SERVER", "localhost");
  define("DB_USER", "anshul");
  define("DB_PASS", "1234");
  define("DB_NAME", "practice_project_db");

  // Create connection
  $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if (!$conn)
  {
      die("Connection failed: " . mysqli_connect_error());
  }
  session_start();

?>
