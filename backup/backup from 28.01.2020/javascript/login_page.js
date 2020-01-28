$(document).ready(
  function()
  {
    $("#login-signup-btn").click(
      function()
      {
        $("#login-div").hide();
        $("#signup-div").show();
      });
    $("#cancel-btn").click(
      function()
      {
        $("#login-div").show();
        $("#signup-div").hide();
      });

    $("#login-btn").click(
      function()
      {
        var user_email = $("#user_email").val();
        var user_password = $("#user_password").val();

        if (user_email == "")
        {
          alert("please enter email");
        }
        else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(user_email)))
        {
          alert("You have entered an invalid email address!");
        }
        else if (user_password == "")
        {
          alert("please enter a password.");
        }
        else
        {
          alert("email: "+user_email+"\npassword: "+user_password);
          // redirect_to('user_dashboard.php');
        }
      }
    );

    $("#signup-btn").click(
      function()
      {
        var first_name = $("#first-name").val();
        var last_name = $("#last-name").val();
        var phone_number = $("#phone-number").val();
        var email = $("#email").val();
        var pass = $("#pass").val();
        var cnfm_pass = $("#cnfm-pass").val();
        var dob = new Date($("#dob").val());
        var day = dob.getDate();
        var month = dob.getMonth() + 1;
        var year = dob.getFullYear();
        var gender = $(".gender:checked").val();
        var address = $("#addr").val();

        if(first_name == "")
        {
          alert("please enter first name");
          return false;
        }
        else if (last_name == "")
        {
          alert("please enter last name");
          return false;
        }
        else if (phone_number == "")
        {
          alert("please enter phone number");
          return false;
        }
        else if (!(phone_number.match(/^\d{10}$/)))
        {
          alert("phone number should be an integer value and must be of 10 digits.");
          return false;
        }
        else if (email == "")
        {
          alert("please enter email");
          return false;
        }
        else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)))
        {
          alert("You have entered an invalid email address!");
          return false;
        }
        else if (pass == "")
        {
          alert("please enter a password.");
          return false;
        }
        else if (!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,16}$/.test(pass)))
        {
          alert("password must contain 8 to 16 characters, at least one lowercase letter, one uppercase letter, one numeric digit, and one special character");
          return false;
        }
        else if (pass != cnfm_pass)
        {
          alert("passwords didn't match");
          return false;
        }
        else if (dob == "Invalid Date")
        {
          alert("dob is necessary");
          return false;
        }
        else if (gender == undefined)
        {
          alert("gender not selected");
          return false;
        }
        else if (address == "")
        {
          alert("please enter address");
          return false;
        }
        else
        {
          alert("first_name: "+first_name+
                "\nlast_name: "+last_name+
                "\nphone number: "+phone_number+
                "\nemail: "+email+
                "\npass: "+pass+
                "\ncnfm_pass: "+cnfm_pass+
                "\ndob: "+dob+
                "\ndate: "+day+"\tmonth: "+month+"\tyear: "+year+
                "\ngender: "+gender+
                "\naddress: "+address);
        }
        $("#login-div").hide();
        $("#signup-div").show();
      }
    );
  }
);
