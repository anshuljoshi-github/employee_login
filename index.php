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
              <td>First name: </td><td> <input id="first-name" type="text" name="first_name" value=""></td><td>Last name:</td><td> <input id="last-name" type="text" name="last_name" value=""></td>
            </tr>
            <tr>
              <td >Phone Number: </td><td colspan="3"><input id="phone-number" class="col-3-input" type="text" name="phone_number" value=""></td>
            </tr>
            <tr>
              <td >Email: </td><td colspan="3"><input id="email" class="col-3-input" type="text" name="email" value=""></td>
            </tr>
            <tr>
              <td>Password: </td><td colspan="3"><input id="pass" class="col-3-input" type="text" name="password" value=""> </td>
            </tr>
            <tr>
              <td>Confirm Password: </td><td colspan="3"><input id="cnfm-pass" class="col-3-input" type="text" name="cnfm_pass" value=""> </td>
            </tr>
            <tr>
              <td>Date of Birth: </td><td colspan="3"><input id="dob" class="col-3-input" type="date" name="dob" value=""> </td>
            </tr>
            <tr>
              <td>Gender: </td>
              <td colspan="3">
                <input class="gender" type="radio" name="gender" value="male"> Male
                <input class="gender" type="radio" name="gender" value="female"> Female
                <input class="gender" type="radio" name="gender" value="other"> Other
              </td>
            </tr>
            <tr>
              <td>Address: </td><td colspan="3"><input id="addr" class="col-3-input" type="text" name="address" value="" style=""> </td>
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
  if (isset($_POST["login-btn1"]))
  {
    validate_login($conn,$_POST["login-email"], $_POST["login-password"]);
  }
?>
<?php
  if(isset($_POST["signup"]))
  {
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $phone_number1 = $_POST["phone_number"];
    $email = $_POST["email"];
    if($_POST["password"] == $_POST["cnfm_pass"])
    {
      $hashed_password = md5($_POST["cnfm_pass"]);
    }
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $insert_query = "INSERT INTO employee_details(first_name, last_name, phone_number, email, hashed_password, dob, gender, address) VALUES ('$fname','$lname','$phone_number1', '$email', '$hashed_password', '$dob', '$gender', '$address')";
    $insert_result = mysqli_query($conn, $insert_query);
    if ($insert_result == TRUE)
    {
      echo "New record created successfully";
      validate_login($conn,$_POST["email"], $_POST["cnfm_pass"]);
    }
    else
    {?>
      <script>
        alert("<?php echo 'Error:\t' . $insert_query . '\n' . mysqli_error($conn); ?>");
      </script>
    <?php
    }
  }
?>
<?php
  include('private/db_connection_close.php');
?>
