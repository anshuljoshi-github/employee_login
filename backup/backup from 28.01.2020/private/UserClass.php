<?php
  require_once('DBclass.php');

  class user_class extends DBoperations
  {
    function get_fields_data($get_field)
    {
      $get_data_query = "SELECT ".$get_field." FROM employee_details WHERE e_id=?";
      $stmt = $GLOBALS['conn']->prepare($get_data_query);
      $stmt->bind_param('i', $_SESSION['e_id']);
      $stmt->execute();
      $res = $stmt->get_result();
      $data = $res->fetch_assoc();
      return $data[$get_field];
    }

    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  }

  $userOBJ = new user_class();
?>
