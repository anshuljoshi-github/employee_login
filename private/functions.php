<?php
  require_once('db_connection.php');
?>

<?php
  function validate_login($conn,$email, $password1)
  {
    $password1 = md5($password1);
    $email = mysqli_real_escape_string($conn,$email);
    $password = mysqli_real_escape_string($conn,$password1);
    $check_query = "SELECT * FROM employee_details WHERE email='$email' && hashed_password='$password'";
    $query_exec = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($query_exec))
    {
      $data=mysqli_fetch_assoc($query_exec);
      $e_id=$data['e_id'];
      $fname=$data['first_name'];
      $lname=$data['last_name'];
      $pnum=$data['phone_number'];
      $dob=$data['dob'];
      $gender=$data['gender'];
      $address=$data['address'];
      $_SESSION['e_id']=$e_id;
      $_SESSION["email"]=$email;
      $_SESSION['fname']=$fname;
      $_SESSION['lname']=$lname;
      $_SESSION['pnum']=$pnum;
      $_SESSION['dob']=$dob;
      $_SESSION['gender']=$gender;
      $_SESSION['address']=$address;
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

?>
