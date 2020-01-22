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

      $fnameErr = $lnameErr = $pnumErr = $emailErr = $dobErr = $genderErr = $addressErr = "";
      $fname = $lname = $pnum = $email = $dob = $gender = $address = "";

      if (isset($_POST["update-account-btn"]))
      {
        if (empty($_POST["fname"]))
        {
          $fnameErr = "first name is required";
        }
        else
        {
          $fname = test_input($_POST["fname"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$fname))
          {
            $fnameErr = "Only letters and white space allowed";
          }
        }

        if (empty($_POST["lname"]))
        {
          $lnameErr = "last name is required";
        }
        else
        {
          $lname = test_input($_POST["lname"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$lname))
          {
            $lnameErr = "Only letters and white space allowed";
          }
        }

        if (empty($_POST["pnum"]))
        {
          $pnumErr = "phone number is required";
        }
        else
        {
          $pnum = test_input($_POST["pnum"]);
          if (!preg_match("/^\d{10}$/",$pnum)) {
            $pnumErr = "incorrect phone number format";
          }
        }

        if (empty($_POST["email"]))
        {
          $emailErr = "Email is required";
        }
        else
        {
          $email = test_input($_POST["email"]);
          if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email))
          {
            $emailErr = "Invalid email address";
          }
        }

        if ($_POST["dob"] == "")
        {
          $dobErr = "date of birth is required";
        }
        else
        {
          $dob = test_input($_POST["dob"]);
        }

        if ($_POST["gender"] == "")
        {
          $genderErr = "gender is required";
        }
        else
        {
          $gender = test_input($_POST["gender"]);
        }

        if ($_POST["address"] == "")
        {
          $addressErr = "address is required";
        }
        else
        {
          $address = test_input($_POST["address"]);
        }


        if (empty($fnameErr) && empty($lnameErr) && empty($pnumErr) && empty($emailErr) && empty($dobErr) && empty($genderErr) && empty($addressErr))
        {
          $update_data = array('fname' => $fname, 'lname' => $lname, 'pnum' => $pnum, 'email' => $email, 'dob' => $dob, 'gender' => $gender, 'address' => $address);
          update_user_profile($conn, $update_data);
        }
      }

      $oldpasswordErr = $newpasswordErr = $cnfmnewpasswordErr = "";
      $oldpassword = $newpassword = $cnfmnewpassword = "";

      if (isset($_POST["changepassword-btn"]))
      {
        if (empty($_POST["oldpass"]))
        {
          $oldpasswordErr = "old password is required";
        }
        else
        {
          $oldpassword = test_input($_POST["oldpass"]);
          if (!old_password_check($conn, $oldpassword))
          {
            $oldpasswordErr = "wrong old password inserted";
          }
        }

        if (empty($_POST["newpass"]))
        {
          $newpasswordErr = "new password is required";
        }
        else
        {
          $newpassword = test_input($_POST["newpass"]);
          if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,16}$/", $password))
          {
            $newpasswordErr = "password must contain 8 to 16 characters, at least one lowercase letter, one uppercase letter, one numeric digit, and one special character";
          }
        }

        $cnfmnewpassword = test_input($_POST["cnfm_pass"]);
        if ($newpassword != $cnfmnewpassword)
        {
          $cnfmnewpasswordErr = "passwords didn't match";
        }

        if (empty($oldpasswordErr) && empty($newpasswordErr) && empty($cnfmnewpasswordErr))
        {
          $update_password_data = array('oldpass' => $oldpassword, 'cnfmnewpass' => $cnfmnewpassword);
          function update_password($conn, $update_password_data);
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
      <form class="" action="" method="post">
        <fieldset>
          <table>
            <tr>
              <td>First name: </td><td><input type="text" name="fname" value="<?php echo $fname; ?>"><span class="error"> <?php echo $fnameErr;?></span> </td>
            </tr>
            <tr>
              <td>Last name: </td><td><input type="text" name="lname" value="<?php echo $lname; ?>"><span class="error"> <?php echo $lnameErr;?></span> </td>
            </tr>
            <tr>
              <td>Phone number: </td><td><input type="text" name="pnum" value="<?php echo $pnum; ?>"><span class="error"> <?php echo $pnumErr;?></span> </td>
            </tr>
            <tr>
              <td>Email: </td><td><input type="text" name="email" value="<?php echo $email; ?>"><span class="error"> <?php echo $emailErr;?></span> </td>
            </tr>
            <tr>
              <td>Date of Birth: </td><td><input type="date" name="dob" value="<?php echo $dob; ?>"><span class="error"> <?php echo $dobErr;?></span> </td>
            </tr>
            <tr>
              <td>Gender: </td>
              <td>
                <input type="radio" name="gender" <?php if ($gender=="female") echo "checked";?> value="female"> Female
                <input type="radio" name="gender" <?php if ($gender=="male") echo "checked";?> value="male"> Male
                <input type="radio" name="gender" <?php if ($gender=="other") echo "checked";?> value="other"> Other
                <span class="error"> <?php echo $genderErr;?></span>
              </td>
            </tr>
            <tr>
              <td>Address: </td><td><input type="text" name="address" value="<?php echo $address; ?>"><span class="error"> <?php echo $addressErr;?></span> </td>
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
            <td>Old password: </td><td><input type="text" name="oldpass" value="<?php echo $oldpassword; ?>"><span class="error"> <?php echo $oldpasswordErr;?></span> </td>
          </tr>
          <tr>
            <td>New password: </td><td><input type="text" name="newpass" value="<?php echo $newpassword; ?>"><span class="error"> <?php echo $newpasswordErr;?></span> </td>
          </tr>
          <tr>
            <td>Confirm new password: </td><td><input type="text" name="cnfmnewpass" value="<?php echo $cnfmnewpassword; ?>"><span class="error"> <?php echo $cnfmnewpasswordErr;?></span> </td>
          </tr>
          <tr>
            <td><input class="btn btn-success" type="submit" id="changepassword-btn1" name="changepassword-btn" value="change password"> </td><td><input class="btn btn-secondary" type="reset" name="" value="reset form"> </td>
          </tr>
        </table>
      </form>
    </div>
  </body>
</html>

<?php
  include('private/db_connection_close.php');
?>
