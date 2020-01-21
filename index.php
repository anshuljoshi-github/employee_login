<?php
  require_once('private/functions.php');
?>

<html>
  <head>
    <link rel="stylesheet" href="css/bootstrap_css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login_page.css">
    <script src="javascript/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="javascript/login_page.js"></script>
    <meta charset="utf-8">
    <title>Login page</title>
  </head>
  <body>
    <?php
      if (isset($_POST["login-btn1"]))
      {
        validate_login($conn,test_input($_POST["login-email"]), test_input($_POST["login-password"]));
      }

      $fnameErr = $lnameErr = $pnumErr = $emailErr = $passwordErr = $confirm_passwordErr = $dobErr = $genderErr = $addressErr = "";
      $fname = $lname = $pnum = $email = $password = $confirm_password = $dob = $gender = $address = "";

      if(isset($_POST["signup"]))
      {
        if (empty($_POST["first_name"]))
        {
          $fnameErr = "first name is required";
        }
        else
        {
          $fname = test_input($_POST["first_name"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$fname))
          {
            $fnameErr = "Only letters and white space allowed";
          }
        }

        if (empty($_POST["last_name"]))
        {
          $lnameErr = "last name is required";
        }
        else
        {
          $lname = test_input($_POST["last_name"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$lname))
          {
            $lnameErr = "Only letters and white space allowed";
          }
        }

        if (empty($_POST["phone_number"]))
        {
          $pnumErr = "phone number is required";
        }
        else
        {
          $pnum = test_input($_POST["phone_number"]);
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

        if (empty($_POST["password"]))
        {
          $passwordErr = "password is required";
        }
        else
        {
          $password = test_input($_POST["password"]);
          if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,16}$/", $password))
          {
            $passwordErr = "password must contain 8 to 16 characters, at least one lowercase letter, one uppercase letter, one numeric digit, and one special character";
          }
        }

        if (empty($_POST["cnfm_pass"]))
        {
          $confirm_passwordErr = "confirm password can't be empty";
        }
        else
        {
          $confirm_password = test_input($_POST["cnfm_pass"]);
          if ($password != $confirm_password)
          {
            $confirm_passwordErr = "passwords didn't match";
          }
          else
          {
            $hashed_password = md5($confirm_password);
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

        if (empty($fnameErr) && empty($lnameErr) && empty($pnumErr) && empty($emailErr) && empty($passwordErr) && empty($confirm_passwordErr) && empty($dobErr) && empty($genderErr) && empty($addressErr))
        {
          $insert_query = "INSERT INTO employee_details(first_name, last_name, phone_number, email, hashed_password, dob, gender, address) VALUES ('$fname','$lname','$pnum', '$email', '$hashed_password', '$dob', '$gender', '$address')";
          $insert_result = mysqli_query($conn, $insert_query);
          if ($insert_result == TRUE)
          {
            echo "New record created successfully";
            validate_login($conn, $email, $confirm_password);
          }
          else
          {?>
            <script>
              alert("<?php echo 'Error:\t' . $insert_query . '\n' . mysqli_error($conn); ?>");
            </script>
          <?php
          }
        }
        else
        {
          echo "not in insert block";
        }
      }
    ?>
    <div id="login-div" class="" method="post">
      <form class="" action="" method="post">
        <fieldset>
          <h2>login for employees</h2>
          <table>
            <tr>
              <td><p>Email: </p></td><td><input type="text" id="user_email" name="login-email" value=""></td>
            </tr>
            <tr>
              <td><p>Password: </p></td><td> <input type="password" id="user_password" name="login-password" value=""> </td>
            </tr>
            <tr>
              <td><button name="login-btn1" id="login-btn" type="submit" class="btn btn-primary">Log in</button></td><td>&nbsp &nbsp<button id="login-signup-btn" type="button" class="btn btn-outline-secondary">Signup</button></td>
            </tr>
          </table>
        </fieldset>
      </form>
    </div>
    <div id="signup-div">
      <form class="" action="" method="post">
        <fieldset>
          <h2>Signup form for new employees</h2>
          <table>
            <tr>
              <td>First name: </td><td> <input id="first-name" type="text" name="first_name" value="<?php echo $fname; ?>"> <span class="error"> <?php echo $fnameErr;?></span></td>
              <td>Last name: </td><td> <input id="last-name" type="text" name="last_name" value="<?php echo $lname; ?>"> <span class="error"> <?php echo $lnameErr;?></span></td>
            </tr>
            <tr>
              <td >Phone Number: </td><td colspan="3"><input id="phone-number" class="col-3-input" type="text" name="phone_number" value="<?php echo $pnum; ?>"> <span class="error"> <?php echo $pnumErr;?></span></td>
            </tr>
            <tr>
              <td >Email: </td><td colspan="3"><input id="email" class="col-3-input" type="text" name="email" value="<?php echo $email; ?>"><span class="error"> <?php echo $emailErr;?></span></td>
            </tr>
            <tr>
              <td>Password: </td><td colspan="3"><input id="pass" class="col-3-input" type="text" name="password" value="<?php echo $password ?>"> <span class="error"> <?php echo $passwordErr;?></span></td>
            </tr>
            <tr>
              <td>Confirm Password: </td><td colspan="3"><input id="cnfm-pass" class="col-3-input" type="text" name="cnfm_pass" value="<?php echo $confirm_password ?>"> <span class="error"> <?php echo $confirm_passwordErr;?></span></td>
            </tr>
            <tr>
              <td>Date of Birth: </td><td colspan="3"><input id="dob" class="col-3-input" type="date" name="dob" value="<?php echo $dob ?>"> <span class="error"> <?php echo $dobErr;?></span></td>
            </tr>
            <tr>
              <td>Gender: </td>
              <td colspan="3">
                <input class="gender" type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male"> Male
                <input class="gender" type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female"> Female
                <input class="gender" type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other"> Other
                <span class="error"> <?php echo $genderErr;?></span>
              </td>
            </tr>
            <tr>
              <td>Address: </td><td colspan="3"><input id="addr" class="col-3-input" type="text" name="address" value="" style=""> <span class="error"> <?php echo $addressErr;?></span></td>
            </tr>
            <tr>
              <td></td><td colspan="2"><button id="signup-btn" type="submit" name="signup" class="btn btn-success">Sign Up</button> &nbsp &nbsp <button id="cancel-btn" type="button" class="btn btn-secondary">Cancel</button></td><td></td>
            </tr>
          </table>
        </fieldset>
      </form>
    </div>
  </body>
</html>

<?php
  include('private/db_connection_close.php');
?>
