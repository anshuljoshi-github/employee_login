<?php
  require_once('private/functions.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/bootstrap_css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user_dashboard.css">
    <script src="javascript/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="javascript/user_dashboard.js"></script>
  </head>
  <body>
    <h2 id="main-heading">User Dashboard</h2>
    <div id="div1" class="topnavbar-div">
      <ul id="topnavbar">
        <li><a href="private/logout.php" id="logout-btn">Logout</a></li>
      </ul>
    </div>
    <div id="div2" class="sidenavbar-div">
      <ul id="sidenavbar">
        <a id="home-btn"><li class="sidenavbar-items">Home</li></a>
        <a id="profile-btn"><li class="sidenavbar-items">Profile </li></a>
        <a id="changepassword-btn"><li class="sidenavbar-items">Change Password</li></a>
        <!-- <li><a class="sidenavbar-items" href=""></a></li> -->
      </ul>
    </div>
    <div id="home-div" class="display-div-content">
      <h2>
        <?php echo "Welcome\t".$_SESSION['fname']."!"; ?></h2>
    </div>
    <div id="profile-div" class="display-div-content">
      <h2>profile</h2><br>
      <form class="" action="" method="post">
        <table>
          <tr>
            <td>First name: </td><td><input type="text" name="fname" value="<?php echo $_SESSION['fname']; ?>"> </td>
          </tr>
          <tr>
            <td>Last name: </td><td><input type="text" name="lname" value="<?php echo $_SESSION['lname']; ?>"> </td>
          </tr>
          <tr>
            <td>Phone number: </td><td><input type="text" name="pnum" value="<?php echo $_SESSION['pnum']; ?>"> </td>
          </tr>
          <tr>
            <td>Email: </td><td><input type="text" name="email" value="<?php echo $_SESSION['email']; ?>"> </td>
          </tr>
          <tr>
            <td>Date of Birth: </td><td><input type="date" name="dob" value="<?php echo $_SESSION['dob']; ?>"> </td>
          </tr>
          <tr>
            <td>Gender: </td><td><input type="text" name="gender" value="<?php echo $_SESSION['gender']; ?>"> </td>
          </tr>
          <tr>
            <td>Address: </td><td><input type="text" name="address" value="<?php echo $_SESSION['address']; ?>"> </td>
          </tr>
          <tr>
            <td><input type="submit" name="update-account-btn" value="update account"> </td><td><input type="reset" name="" value="reset form"> </td>
          </tr>
        </table>
      </form>
    </div>
    <div id="changepassword-div" class="display-div-content">
      <h2>changepassword</h2>
      <form class="" action="" method="post">
        <table>
          <tr>
            <td>Old password: </td><td><input type="text" name="oldpass" value=""> </td>
          </tr>
          <tr>
            <td>New password: </td><td><input type="text" name="newpass" value=""> </td>
          </tr>
          <tr>
            <td>Confirm new password: </td><td><input type="text" name="cnfmnewpass" value=""> </td>
          </tr>
          <tr>
            <td><input type="submit" name="changepassword-btn" value="change password"> </td><td><input type="reset" name="" value="reset form"> </td>
          </tr>
        </table>
      </form>
    </div>
  </body>
</html>
<?php
  if (isset($_POST["update-account-btn"]))
  {
    $e_id = $_SESSION["e_id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $pnumber = $_POST["pnum"];
    $email1 = $_POST["email"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $address1 = $_POST["address"];
    $update_profile_sql = "UPDATE employee_details SET first_name='$fname', last_name='$lname', phone_number='$pnumber', email='$email1', dob='$dob', gender='$gender',address='$address1' WHERE e_id=$e_id";
    $update_profile_exec = mysqli_query($conn, $update_profile_sql);
    console.log(print_r($update_profile_exec));
  }
?>
<?php
  if (isset($_POST["changepassword-btn"]))
  {
    $e_id = $_SESSION["e_id"];
    $get_oldpass_sql = "SELECT hashed_password FROM employee_details WHERE e_id='$e_id'";
    $get_oldpass_exec = mysqli_query($conn, $get_oldpass_sql);
    $data=mysqli_fetch_assoc($get_oldpass_exec);
    console.log("get_oldpass_exec:\t".$get_oldpass_exec);
    if (md5($_POST["oldpass"]) == $data['hashed_password'])
    {
      if ($_POST["newpass"] == $_POST["cnfmnewpass"])
      {
        $newhashedpass = md5($_POST["cnfmnewpass"]);
      }
      $update_password_sql = "UPDATE employee_details SET hashed_password='$newhashedpass' WHERE e_id=$e_id";
      $update_password_exec = mysqli_query($conn, $update_password_sql);
      console.log(print_r("update_password_exec:\t".$update_password_exec));
    }

  }
?>
<?php
  include('private/db_connection_close.php');
?>
