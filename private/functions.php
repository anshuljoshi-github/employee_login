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
    else
    {?>
      <script>
        alert("wrong email or password!!");
      </script>
    <?php
    }
  }

?>
