<?php
  require_once('private/UserClass.php');
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
      if (!isset($_SESSION['e_id']))
      {
        header('Location: index.php');
      }
      else
      {
        $fnameErr = $lnameErr = $pnumErr = $emailErr = $dobErr = $genderErr = $addressErr = "";
        $fname = $GLOBALS['userOBJ']->get_fields_data("first_name");
        $lname = $GLOBALS['userOBJ']->get_fields_data("last_name");
        $pnum = $GLOBALS['userOBJ']->get_fields_data("phone_number");
        $email = $GLOBALS['userOBJ']->get_fields_data("email");
        $dob = $GLOBALS['userOBJ']->get_fields_data("dob");
        $gender = $GLOBALS['userOBJ']->get_fields_data("gender");
        $address = $GLOBALS['userOBJ']->get_fields_data("address");
        // print_r($fname."\t".$lname."\t".$pnum."\t".$email."\t".$dob."\t".$gender."\t".$address);die;

        if (isset($_POST["update-account-btn"]))
        {
          if (empty($_POST["fname"]))
          {
            $fnameErr = "first name is required";
          }
          else
          {
            $fname = $GLOBALS['userOBJ']->test_input($_POST["fname"]);
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
            $lname = $GLOBALS['userOBJ']->test_input($_POST["lname"]);
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
            $pnum = $GLOBALS['userOBJ']->test_input($_POST["pnum"]);
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
            $email = $GLOBALS['userOBJ']->test_input($_POST["email"]);
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
            $dob = $GLOBALS['userOBJ']->test_input($_POST["dob"]);
          }

          if ($_POST["gender"] == "")
          {
            $genderErr = "gender is required";
          }
          else
          {
            $gender = $GLOBALS['userOBJ']->test_input($_POST["gender"]);
          }

          if ($_POST["address"] == "")
          {
            $addressErr = "address is required";
          }
          else
          {
            $address = $GLOBALS['userOBJ']->test_input($_POST["address"]);
          }

          if (empty($fnameErr) && empty($lnameErr) && empty($pnumErr) && empty($emailErr) && empty($dobErr) && empty($genderErr) && empty($addressErr))
          {
            $update_data = array('fname' => $fname, 'lname' => $lname, 'pnum' => $pnum, 'email' => $email, 'dob' => $dob, 'gender' => $gender, 'address' => $address);
            $GLOBALS['userOBJ']->update_user_profile($update_data);
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
            $oldpassword = $GLOBALS['userOBJ']->test_input($_POST["oldpass"]);
            if (!$GLOBALS['userOBJ']->old_password_check($oldpassword))
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
            $newpassword = $GLOBALS['userOBJ']->test_input($_POST["newpass"]);
            if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,16}$/", $newpassword))
            {
              $newpasswordErr = "password must contain 8 to 16 characters, at least one lowercase letter, one uppercase letter, one numeric digit, and one special character";
            }
          }

          $cnfmnewpassword = $GLOBALS['userOBJ']->test_input($_POST["cnfmnewpass"]);
          if ($newpassword != $cnfmnewpassword)
          {
            $cnfmnewpasswordErr = "passwords didn't match";
          }

          if (empty($oldpasswordErr) && empty($newpasswordErr) && empty($cnfmnewpasswordErr))
          {
            $GLOBALS['userOBJ']->update_password($cnfmnewpassword);
          }
        }

        $cnfm_delete_val = $cnfm_delete_val_Err = "";
        if (isset($_POST["confirm-delete-btn"]))
        {
          if (empty($_POST["cnfm_delete_input"]))
          {
            $cnfm_delete_val_Err = "Please type the given word";
          }
          else
          {
            $cnfm_delete_val = $GLOBALS['userOBJ']->test_input($_POST["cnfm_delete_input"]);
            if ($_POST["cnfm_delete_input"] != "DELETE")
            {
              $cnfm_delete_val_Err = "Wrong word typed";
            }
            else
            {
              $GLOBALS['userOBJ']->deleteaccount();
            }
          }
        }
      }
    ?>
    <h2 id="main-heading">User Dashboard</h2>
    <div id="div1" class="topnavbar-div">
      <ul id="topnavbar">
        <li><a href="private/logout.php" id="logout-btn" onclick="signOut();">Logout</a></li>
      </ul>
    </div>
    <div id="div2" class="sidenavbar-div">
      <ul id="sidenavbar">
        <a id="home-btn"><li class="sidenavbar-items">Home</li></a>
        <a id="profile-btn"><li class="sidenavbar-items">Profile </li></a>
        <a id="changepassword-btn"><li class="sidenavbar-items">Change Password</li></a>
        <a id="deleteaccount-btn"><li class="sidenavbar-items">Delete Account</li></a>
        <!-- <li><a class="sidenavbar-items" href=""></a></li> -->
      </ul>
    </div>
    <div id="home-div" class="display-div-content">
      <h2>
        <?php echo "Welcome\t".$GLOBALS['userOBJ']->get_fields_data("first_name")."!"; ?></h2>
    </div>
    <div id="profile-div" class="display-div-content">
      <h2>profile</h2>
      <form class="" action="" method="post">
        <fieldset>
          <table>
            <tr>
              <td>First name: </td><td><input type="text" id="fname-id" name="fname" value="<?php echo $fname; ?>"><span class="error"> <?php echo $fnameErr;?></span> </td>
            </tr>
            <tr>
              <td>Last name: </td><td><input type="text" id="lname-id" name="lname" value="<?php echo $lname; ?>"><span class="error"> <?php echo $lnameErr;?></span> </td>
            </tr>
            <tr>
              <td>Phone number: </td><td><input type="text" id="pnum-id" name="pnum" value="<?php echo $pnum; ?>"><span class="error"> <?php echo $pnumErr;?></span> </td>
            </tr>
            <tr>
              <td>Email: </td><td><input type="text" id="email-id" name="email" value="<?php echo $email; ?>"><span class="error"> <?php echo $emailErr;?></span> </td>
            </tr>
            <tr>
              <td>Date of Birth: </td><td><input type="date" id="dob-id" name="dob" value="<?php echo $dob; ?>"><span class="error"> <?php echo $dobErr;?></span> </td>
            </tr>
            <tr>
              <td>Gender: </td>
              <td>
                <input type="radio" name="gender" class="gender" <?php if ($gender=="female") echo "checked";?> value="female"> Female
                <input type="radio" name="gender" class="gender" <?php if ($gender=="male") echo "checked";?> value="male"> Male
                <input type="radio" name="gender" class="gender" <?php if ($gender=="other") echo "checked";?> value="other"> Other
                <span class="error"> <?php echo $genderErr;?></span>
              </td>
            </tr>
            <tr>
              <td>Address: </td><td><input type="text" id="address-id" name="address" value="<?php echo $address; ?>"><span class="error"> <?php echo $addressErr;?></span> </td>
            </tr>
            <tr>
              <td><input id="update-account-btn1" class="btn btn-success" type="submit" name="update-account-btn" value="update account"> </td>
              <td><input class="btn btn-secondary" type="reset" name="" value="reset form"> </td>
            </tr>
          </table>
        </fieldset>
      </form>
    </div>
    <div id="changepassword-div" class="display-div-content">
      <h2>change password</h2>
      <form id="changepassword-form" class="" action="" method="post">
        <table>
          <tr>
            <td>Old password: </td><td><input type="password" id="oldpass-id" name="oldpass" value=""><span class="error"> <?php echo $oldpasswordErr;?></span> </td>
          </tr>
          <tr>
            <td>New password: </td><td><input type="password" id="newpass-id" name="newpass" value=""><span class="error"> <?php echo $newpasswordErr;?></span> </td>
          </tr>
          <tr>
            <td>Confirm new password: </td><td><input type="password" id="cnfmnewpass-id" name="cnfmnewpass" value=""><span class="error"> <?php echo $cnfmnewpasswordErr;?></span> </td>
          </tr>
          <tr>
            <td><input class="btn btn-success" type="submit" id="changepassword-btn-id" name="changepassword-btn" value="change password"> </td>
            <td><input class="btn btn-secondary" type="reset" name="" value="reset form"> </td>
          </tr>
        </table>
      </form>
    </div>
    <div id="delete-account-div" class="display-div-content">
      <h2><b>Do you want to delete your account ? </b></h2>
      <form class="" action="" method="post">
        <td><button class="btn btn-warning" type="button" id="delete-btn">Delete account</button> </td>
      </form>
    </div>
    <div id="confirm-delete-div" class="display-div-content">
      <h2><b>Are you sure you want delete your account ? Type "DELETE" to confirm</b></h2>
      <form id="cnfm_delete_form" class="" action="" method="post">
        <table>
          <tr>
            <td colspan="2"><input type="text" name="cnfm_delete_input" value="<?php echo $cnfm_delete_val ?>"><span class="error"><?php echo $cnfm_delete_val_Err ?></span> </td>
          </tr>
          <tr>
            <td><input class="btn btn-warning" type="submit" name="confirm-delete-btn" id="confirm-delete-btn-id" value="Confirm Delete"></td>
            <td><input class="btn btn-secondary" type="reset" id="cancel-delete-btn" value="Cancel"></td>
          </tr>
        </table>
      </form>
    </div>
  </body>
</html>

<?php
  include('private/db_connection_close.php');
?>
