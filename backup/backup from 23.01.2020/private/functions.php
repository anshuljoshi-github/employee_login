<?php
  require_once('db_connection.php');
?>

<?php

  function insert_user_data($conn, $user_data)
  {
    $check_email_query = "SELECT COUNT(*) countentry FROM employee_details WHERE email = ?";
    // echo $check_email_query; die;
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $user_data['email']);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = mysqli_fetch_assoc($res);
    // echo $data['countentry']; die;
    if ($data['countentry'] > 0)
    {
      ?>
      <script>
        alert("Email already exists choose another email");
      </script>
      <?php
    }
    else
    {
      $insert_query = "INSERT INTO employee_details(first_name, last_name, phone_number, email, hashed_password, dob, gender, address) VALUES (?,?,?,?,?,?,?,?)";
      // echo $insert_query;die;
      $stmt1 = $conn->prepare($insert_query);
      $stmt1->bind_param('ssssssss', $user_data['fname'], $user_data['lname'], $user_data['pnum'], $user_data['email'], md5($user_data['confirm_password']), $user_data['dob'], $user_data['gender'], $user_data['address']);
      $stmt1->execute();
      echo "New record created successfully";
      validate_login($conn, $user_data['email'], $user_data['confirm_password']);
      $stmt1->close();
    }
    $stmt->close();
  }

  function get_fields_data()
  {

  }

  function validate_login($conn,$email, $password1)
  {
    $password1 = md5($password1);
    $check_query = "SELECT * FROM employee_details WHERE email=? && hashed_password=?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $email, $password1);
    $stmt->execute();
    $res = $stmt->get_result();
    // print_r($res);die;
    if(mysqli_num_rows($res))
    {
      $data = $res->fetch_assoc();
      $_SESSION['e_id'] = $data['e_id'];
      header("Location: user_dashboard.php");
      return TRUE;
    }
    else
    {?>
      <script>
        alert("wrong email or password!!");
      </script>
    <?php
    }
    $stmt->close();
  }

  function update_user_profile($conn, $update_data)
  {
    $check_email_query = "SELECT COUNT(*) countentry FROM employee_details WHERE email = '";
    $check_email_query .= $update_data['email'];
    $check_email_query .= "' AND e_id != '".$_SESSION['e_id']."'";
    // echo $check_email_query; die;
    $res = mysqli_query($conn, $check_email_query);
    $data = mysqli_fetch_assoc($res);
    // echo $data['countentry']; die;
    if ($data['countentry'] > 0)
    {
      ?>
      <script>
        alert("Email already exists choose another email");
      </script>
      <?php
    }
    else
    {
      $update_profile_sql = "UPDATE employee_details SET first_name='";
      $update_profile_sql .= $update_data['fname'];
      $update_profile_sql .= "', last_name='";
      $update_profile_sql .= $update_data['lname'];
      $update_profile_sql .= "', phone_number='";
      $update_profile_sql .= $update_data['pnum'];
      $update_profile_sql .= "', email='";
      $update_profile_sql .= $update_data['email'];
      $update_profile_sql .= "', dob='";
      $update_profile_sql .= $update_data['dob'];
      $update_profile_sql .= "', gender='";
      $update_profile_sql .= $update_data['gender'];
      $update_profile_sql .= "',address='";
      $update_profile_sql .= $update_data['address'];
      $update_profile_sql .="' WHERE e_id=";
      $update_profile_sql .=  $_SESSION['e_id'];
      // echo $update_profile_sql;die
      $update_profile_exec = mysqli_query($conn, $update_profile_sql);
      $check_query = "SELECT * FROM employee_details WHERE email='".$_SESSION['email']."'";
      $query_exec = mysqli_query($conn, $check_query);
      if(mysqli_num_rows($query_exec))
      {
        $data=mysqli_fetch_assoc($query_exec);
        $_SESSION['e_id']=$data['e_id'];
        header("Location: user_dashboard.php");
      }
    }
  }

  function old_password_check($conn, $oldpass)
  {
    $e_id = $_SESSION["e_id"];
    $get_oldpass_sql = "SELECT hashed_password FROM employee_details WHERE e_id='$e_id'";
    $get_oldpass_exec = mysqli_query($conn, $get_oldpass_sql);
    $data=mysqli_fetch_assoc($get_oldpass_exec);
    if (md5($oldpass) == $data['hashed_password'])
    {
      return TRUE;
    }
    else
    {
      ?>
      <script>
        alert("wrong old password inserted");
      </script>
      <?php
    return false;
    }
  }

  function update_password($conn, $update_password_data)
  {
    $e_id = $_SESSION["e_id"];
    $newhashedpass = md5($update_password_data);
    $update_password_sql = "UPDATE employee_details SET hashed_password='$newhashedpass' WHERE e_id=$e_id";
    $update_password_exec = mysqli_query($conn, $update_password_sql);
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>
