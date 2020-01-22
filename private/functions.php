<?php
  require_once('db_connection.php');
?>

<?php

  function insert_user_data($conn, $user_data)
  {
    $insert_query = "INSERT INTO employee_details(first_name, last_name, phone_number, email, hashed_password, dob, gender, address) VALUES";
    $insert_query .= "('".$user_data['fname']."'";
    $insert_query .= ", '".$user_data['lname']."'";
    $insert_query .= ", '".$user_data['pnum']."'";
    $insert_query .= ", '".$user_data['email']."'";
    $insert_query .= ", '".md5($user_data['confirm_password'])."'";
    $insert_query .= ", '".$user_data['dob']."'";
    $insert_query .= ", '".$user_data['gender']."'";
    $insert_query .= ", '".$user_data['address']."')";
    // echo $insert_query;die;
    $insert_result = mysqli_query($conn, $insert_query);
    if ($insert_result == TRUE)
    {
      echo "New record created successfully";
      validate_login($conn, $user_data['email'], $user_data['confirm_password']);
    }
    else
    {?>
      <script>
        alert("<?php echo 'Error:\t' . $insert_query . '\n' . mysqli_error($conn); ?>");
      </script>
    <?php
    }
  }

  function validate_login($conn,$email, $password1)
  {
    $password1 = md5($password1);
    $check_query = "SELECT * FROM employee_details WHERE email='$email' && hashed_password='$password1'";
    $query_exec = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($query_exec))
    {
      $data=mysqli_fetch_assoc($query_exec);
      $_SESSION['fname']=$data['first_name'];
      $_SESSION['lname']=$data['last_name'];
      $_SESSION['pnum']=$data['phone_number'];
      $_SESSION['dob']=$data['dob'];
      $_SESSION['gender']=$data['gender'];
      $_SESSION['address']=$data['address'];
      $_SESSION['e_id']=$data['e_id'];
      $_SESSION["email"]=$data['email'];
      header("Location: user_dashboard.php");
    }
    else
    {?>
      <script>
        alert("wrong email or password!!");
      </script>
    <?php
    }
  }

  function update_user_profile($conn, $update_data)
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
    if ($update_profile_exec == TRUE)
    {
      $check_query = "SELECT * FROM employee_details WHERE email='".$_SESSION['email']."'";
      $query_exec = mysqli_query($conn, $check_query);
      if(mysqli_num_rows($query_exec))
      {
        $data=mysqli_fetch_assoc($query_exec);
        $e_id=$data['e_id'];
        $_SESSION['fname']=$data['first_name'];
        $_SESSION['lname']=$data['last_name'];
        $_SESSION['pnum']=$data['phone_number'];
        $_SESSION['dob']=$data['dob'];
        $_SESSION['gender']=$data['gender'];
        $_SESSION['address']=$data['address'];
        $_SESSION['e_id']=$e_id;
        $_SESSION["email"]=$data['email'];
        header("Location: user_dashboard.php");
      }
    }
    else
    {?>
      <script type="text/javascript">
        alert("email already exists");
      </script>
    <?php
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
    {?>
      <script>
        alert("wrong old password inserted");
      </script>
    <?php
    return false;
    }
  }

  function update_password($conn, $update_password_data)
  {
    if ($update_password_data["newpass"] == $update_password_data["cnfmnewpass"])
    {
      $newhashedpass = md5($["cnfmnewpass"]);
      $update_password_sql = "UPDATE employee_details SET hashed_password='$newhashedpass' WHERE e_id=$e_id";
      $update_password_exec = mysqli_query($conn, $update_password_sql);
    }
    else
    {?>
      <script type="text/javascript">
        alert("passwords didn't match!!!");
      </script>
    <?php
    }
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>
