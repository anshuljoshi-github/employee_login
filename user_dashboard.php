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
      <h2>profile</h2>
      <form class="" action="" method="post">
        <fieldset>
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
              <td>Gender: </td>
              <td>
                <input type="radio" name="gender" <?php if ($_SESSION["gender"]=="female") echo "checked";?> value="female"> Female
                <input type="radio" name="gender" <?php if ($_SESSION["gender"]=="male") echo "checked";?> value="male"> Male
                <input type="radio" name="gender" <?php if ($_SESSION["gender"]=="other") echo "checked";?> value="other"> Other
              </td>
            </tr>
            <tr>
              <td>Address: </td><td><input type="text" name="address" value="<?php echo $_SESSION['address']; ?>"> </td>
            </tr>
            <tr>
              <td><input id="update-account-btn1" class="btn btn-success" type="submit" name="update-account-btn" value="update account"> </td><td><input class="btn btn-secondary" type="reset" name="" value="reset form"> </td>
            </tr>
          </table>
        </fieldset>
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
            <td><input class="btn btn-success" type="submit" name="changepassword-btn" value="change password"> </td><td><input class="btn btn-secondary" type="reset" name="" value="reset form"> </td>
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
    $_SESSION['fname'] = $_POST["fname"];
    $_SESSION['lname'] = $_POST["lname"];
    $_SESSION['pnum'] = $_POST["pnum"];
    $_SESSION['email'] = $_POST["email"];
    $_SESSION['dob'] = $_POST["dob"];
    $_SESSION['gender'] = $_POST["gender"];
    $_SESSION['address'] = $_POST["address"];
    $update_profile_sql = "UPDATE employee_details SET first_name='" . $_SESSION['fname'] . "', last_name='". $_SESSION['lname'] ."', phone_number='". $_SESSION['pnum'] ."', email='". $_SESSION['email'] ."', dob='". $_SESSION['dob'] ."', gender='". $_SESSION['gender'] ."',address='". $_SESSION['address'] ."' WHERE e_id=$e_id";
    $update_profile_exec = mysqli_query($conn, $update_profile_sql);
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
?>
<?php
  if (isset($_POST["changepassword-btn"]))
  {
    $e_id = $_SESSION["e_id"];
    $get_oldpass_sql = "SELECT hashed_password FROM employee_details WHERE e_id='$e_id'";
    $get_oldpass_exec = mysqli_query($conn, $get_oldpass_sql);
    $data=mysqli_fetch_assoc($get_oldpass_exec);
    if (md5($_POST["oldpass"]) == $data['hashed_password'])
    {
      if ($_POST["newpass"] == $_POST["cnfmnewpass"])
      {
        $newhashedpass = md5($_POST["cnfmnewpass"]);
      }
      $update_password_sql = "UPDATE employee_details SET hashed_password='$newhashedpass' WHERE e_id=$e_id";
      $update_password_exec = mysqli_query($conn, $update_password_sql);
    }
    else
    {?>
      <script>
        alert("wrong old password inserted");
      </script>
    <?php
    }
  }
?>
<?php
  include('private/db_connection_close.php');
?>
