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
    <?php
    $fnameerr = $lnameerr = $pnumerr = $emailerr = $doberr = $gendererr = $addresserr = "";
      if ($_SERVER["REQUEST_METHOD"] == "POST")
      {
        if (empty($_POST["fname"]))
        {
          $fnameerr = "first name can't be empty";
        }
        else
        {
          $_SESSION["fname"] = test_input($_POST["fname"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$_SESSION["fname"]))
          {
            $fnameerr = "Only letters and white space allowed";
          }
        }

        if (empty($_POST["lname"]))
        {
          $lnameerr = "last name can't be empty";
        }
        else
        {
          $_SESSION["lname"] = test_input($_POST["lname"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$_SESSION["lname"]))
          {
            $lnameerr = "Only letters and white space allowed";
          }
        }

        if (empty($_POST["pnum"]))
        {
          $pnumerr = "phone number is required";
        }
        else
        {
          $_SESSION["pnum"] = test_input($_POST["pnum"]);
          if (!preg_match("/^\d{10}$/",$_SESSION["pnum"]))
          {
            $pnumerr = "incorrect phone number format";
          }
        }

        if (empty($_POST["email"]))
        {
          $emailerr = "Email is required";
        }
        else
        {
          $_SESSION["email"] = test_input($_POST["email"]);
          if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",$_SESSION["email"]))
          {
            $emailerr = "Invalid email address";
          }
        }

        if ($_POST["dob"] == "Invalid Date")
        {
          $doberr = "date of birth is required";
        }
        else
        {
          $_SESSION['dob'] = $_POST["dob"];
        }

        if (empty($_POST["gender"]))
        {
          $gendererr = "gender is required";
        }
        else
        {
          $_SESSION["gender"] = test_input($_POST["gender"]);
        }

        if (empty($_POST["address"]))
        {
          $addresserr = "address is required";
        }
        else
        {
          $_SESSION["address"] = test_input($_POST["address"]);
        }
      }
    ?>
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
      <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset>
          <table>
            <tr>
              <td>First name: </td><td><input type="text" name="fname" value="<?php echo $_SESSION['fname']; ?>"> <span class="error"> <?php echo $fnameerr;?></span></td>
            </tr>
            <tr>
              <td>Last name: </td><td><input type="text" name="lname" value="<?php echo $_SESSION['lname']; ?>"> <span class="error"> <?php echo $lnameerr;?></span></td>
            </tr>
            <tr>
              <td>Phone number: </td><td><input type="text" name="pnum" value="<?php echo $_SESSION['pnum']; ?>"> <span class="error"> <?php echo $pnumerr;?></span></td>
            </tr>
            <tr>
              <td>Email: </td><td><input type="text" name="email" value="<?php echo $_SESSION['email']; ?>"> <span class="error"> <?php echo $emailerr;?></span></td>
            </tr>
            <tr>
              <td>Date of Birth: </td><td><input type="date" name="dob" value="<?php echo $_SESSION['dob']; ?>"> <span class="error"> <?php echo $doberr;?></span></td>
            </tr>
            <tr>
              <td>Gender: </td>
              <td>
                <input type="radio" name="gender" <?php if ($_SESSION["gender"]=="female") echo "checked";?> value="female"> Female
                <input type="radio" name="gender" <?php if ($_SESSION["gender"]=="male") echo "checked";?> value="male"> Male
                <input type="radio" name="gender" <?php if ($_SESSION["gender"]=="other") echo "checked";?> value="other"> Other
                <span class="error"> <?php echo $gendererr;?></span>
              </td>
            </tr>
            <tr>
              <td>Address: </td><td><input type="text" name="address" value="<?php echo $_SESSION['address']; ?>"> <span class="error"> <?php echo $addresserr;?></span></td>
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
  $e_id = $_SESSION["e_id"];
  if ($fnameerr == "" && $lnameerr == "" && $pnumerr == "" && $emailerr == "" && $doberr == "" && $gendererr == "" && $addresserr == "")
  {
    $update_profile_sql = "UPDATE employee_details SET first_name='" . $_SESSION['fname'] . "', last_name='". $_SESSION['lname'] ."', phone_number='". $_SESSION['pnum'] ."', email='". $_SESSION['email'] ."', dob='". $_SESSION['dob'] ."', gender='". $_SESSION['gender'] ."',address='". $_SESSION['address'] ."' WHERE e_id=$e_id";
    $update_profile_exec = mysqli_query($conn, $update_profile_sql);
    if ($update_profile_exec == TRUE)
    {
      header("Location: user_dashboard.php");
    }
    else
    {?>
      <script type="text/javascript">
        alert("email already exists");
      </script>
    <?php
    }
  }

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
