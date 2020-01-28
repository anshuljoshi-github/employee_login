<?php
  require_once('db_connection.php');

  class DBoperations
  {
    function insert_user_data($user_data)
    {
      $check_email_query = "SELECT COUNT(*) countentry FROM employee_details WHERE email = ?";
      // echo $check_email_query; die;
      $stmt = $GLOBALS['conn']->prepare($check_email_query);
      $stmt->bind_param("s", $user_data['email']);
      $stmt->execute();
      $res = $stmt->get_result();
      $data = $res->fetch_assoc();
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
        $stmt1 = $GLOBALS['conn']->prepare($insert_query);
        $stmt1->bind_param('ssssssss', $user_data['fname'], $user_data['lname'], $user_data['pnum'], $user_data['email'], md5($user_data['confirm_password']), $user_data['dob'], $user_data['gender'], $user_data['address']);
        $stmt1->execute();
        echo "New record created successfully";
        $this->validate_login($user_data['email'], $user_data['confirm_password']);
        $stmt1->close();
      }
      $stmt->close();
    }

    function validate_login($email, $password1)
    {
      $password1 = md5($password1);
      $check_query = "SELECT * FROM employee_details WHERE email=? && hashed_password=?";
      $stmt = $GLOBALS['conn']->prepare($check_query);
      $stmt->bind_param("ss", $email, $password1);
      $stmt->execute();
      $res = $stmt->get_result();
      // print_r($res->num_rows);die;
      if($res->num_rows)
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

    function update_user_profile($update_data)
    {
      $check_email_query = "SELECT COUNT(*) countentry FROM employee_details WHERE email = ? AND e_id != ?";
      $stmt = $GLOBALS['conn']->prepare($check_email_query);
      $stmt->bind_param('ss', $update_data['email'], $_SESSION['e_id']);
      $stmt->execute();
      $res = $stmt->get_result();
      $data = $res->fetch_assoc();
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
        $update_profile_sql = "UPDATE employee_details SET first_name = ?, last_name = ?, phone_number = ?, email = ?, dob = ?, gender = ?, address= ? WHERE e_id=?";
        $stmt1 = $GLOBALS['conn']->prepare($update_profile_sql);
        $stmt1->bind_param('sssssssi', $update_data['fname'], $update_data['lname'], $update_data['pnum'], $update_data['email'], $update_data['dob'], $update_data['gender'], $update_data['address'], $_SESSION['e_id']);
        $stmt1->execute();
        $stmt1->close();
      }
      $stmt->close();
    }

    function old_password_check($oldpass)
    {
      $get_oldpass_sql = "SELECT hashed_password FROM employee_details WHERE e_id=?";
      $stmt = $GLOBALS['conn']->prepare($get_oldpass_sql);
      $stmt->bind_param('i', $_SESSION["e_id"]);
      $stmt->execute();
      $res = $stmt->get_result();
      $data = $res->fetch_assoc();
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

    function update_password($update_password_data)
    {
      $newhashedpass = md5($update_password_data);
      $update_password_sql = "UPDATE employee_details SET hashed_password=? WHERE e_id=?";
      $stmt = $GLOBALS['conn']->prepare($update_password_sql);
      $stmt->bind_param('si', $newhashedpass, $_SESSION["e_id"]);
      $stmt->execute();
    }

    function deleteaccount()
    {
      $dlt_acc_sql = "DELETE FROM employee_details WHERE e_id=?";
      $stmt = $GLOBALS['conn']->prepare($dlt_acc_sql);
      $stmt->bind_param('i', $_SESSION['e_id']);
      $stmt->execute();
      header('Location: private/logout.php');
    }
  }
?>
